var express = require('express');
var jwt = require('jsonwebtoken');

var app = express();

app.get('/auth', function(req, res) {
  // request received from Ionic Auth
  var mySharedSecret = 'foxtrot';
  var redirectUri = req.query.redirect_uri;
  var state = req.query.state;

  try {
    var incomingToken = jwt.verify(req.query.token, mySharedSecret);
  } catch (ex) { // lots of stuff can go wrong while decoding the jwt
    return res.status(401).send('jwt error');
  }

  // Here is sample code to get you started authenticating your own users
  var username = incomingToken.data.username;
  var password = incomingToken.data.password;
  var user_id;
  if (username == 'dan' && password == '123') {
    user_id = 1;
  }

  // authentication failure
  if (!user_id) {
    return res.status(401).send('auth error');
  }

  // make the outgoing token, which is sent back to Ionic Auth
  var outgoingToken = jwt.sign({"user_id": user_id}, mySharedSecret);
  var url = redirectUri +
    '?token=' + encodeURIComponent(outgoingToken) +
    '&state=' + encodeURIComponent(state);

  return res.redirect(url);
});

app.listen(5000, function() {
  console.log('listening on port 5000');
});
