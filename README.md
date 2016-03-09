# Ionic Platform Custom Auth Examples

These examples will get you up and running using Ionic Auth with your own
server backend.

Examples are organized by web framework. Each example runs on port 5000 and
defines a route, `/auth`, which is the entry point.

For these examples, we will be using the shared secret `foxtrot` and the
endpoint `http://localhost:5000/auth`. These custom auth config options are
specified in **User Auth** settings in [apps.ionic.io](https://apps.ionic.io)
under **Custom**.

For testing purposes, after booting up one of the examples, you can simulate a
request from Ionic Auth with this URL (be aware of browsers caching redirects):

    http://localhost:5000/auth?redirect_uri=https%3A%2F%2Fionic.io&state=abcd&token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJkYXRhIjp7InlvdXJfZGF0YSI6dHJ1ZSwidXNlcm5hbWUiOiJkYW4iLCJwYXNzd29yZCI6IjEyMyJ9LCJhcHBfaWQiOiJ5b3VyX2FwcF9pZCIsImV4cCI6MjAwMDAwMDAwMH0.eFTjndCStK3D7M3IMHy0nW1OaS4HZkJCdoGu9Jr2vQA

The token (when successfully decoded) has the payload:

    {
        "your_data": true,
        "username": "dan",
        "password": "123"
    }

You will find that the `redirect_uri` is `https://ionic.io`, which means that
upon successful authentication, you will be redirected to Ionic's homepage.

Documentation for custom authentication can be found
[here](http://docs.ionic.io/docs/custom-authentication).
