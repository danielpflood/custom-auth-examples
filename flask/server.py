try:
    from urllib.parse import urlencode
except ImportError:
    from urllib import urlencode  # Python 2

import jwt
from flask import Flask, abort, redirect, request

app = Flask(__name__)

@app.route('/auth', methods=['GET'])
def auth():
    # request received from Ionic Auth
    my_shared_secret = 'foxtrot'
    redirect_uri = request.args['redirect_uri']
    state = request.args['state']

    try:
        incoming_token = jwt.decode(request.args['token'], my_shared_secret)
    except jwt.InvalidTokenError: # lots of stuff can go wrong while decoding the jwt
        abort(401)

    # Here is sample code to get you started authenticating your own users
    username = incoming_token['data']['username']
    password = incoming_token['data']['password']
    if username == 'dan' and password == '123':
        user_id = 1
    else:
        user_id = None

    # authentication failure
    if user_id is None:
        abort(401)

    # make the outgoing token, which is sent back to Ionic Auth
    outgoing_token = jwt.encode({'user_id': user_id}, my_shared_secret)
    params = urlencode({'token': outgoing_token, 'state': state})
    url = '{}?{}'.format(redirect_uri, params)
    return redirect(url)


if __name__ == '__main__':
    app.run(debug=True)
