# Ionic Platform Custom Auth Examples

These examples will get you up and running using Ionic Auth with your own
server backend.

Examples are organized by web framework. Each example runs on port 5000 and
defines a route, `/auth`, which is the entry point.

For these examples, we will be using the shared secret `foxtrot` and the
endpoint `http://localhost:5000/auth`. These custom auth config options are
specified in [apps.ionic.io](https://apps.ionic.io).

![custom auth setup](https://cloud.githubusercontent.com/assets/236501/13647355/53742d08-e5f9-11e5-918f-86a43f44a88b.png)

Use the included nodejs script to generate the URL to start the authentication
process.

```bash
$ node genurl.js <YOUR_APP_ID>
```

Boot up your preferred example. For nodejs:

```bash
$ node express/server.js
```

Copy the generated URL from the genurl.js script into curl or a tool like
[postman](https://www.getpostman.com/).

```bash
curl -L -X GET "<GENERATED_URL>"
```

The token (when successfully decoded) has the following payload, but you can
alter `genurl.js` to change what gets sent to your server.

```json
{
    "username": "dan",
    "password": "123"
}
```

Upon successful authentication, you should get a JSON response with the message
`You have successfully implemented custom authentication!` in it.

Then you can look in your users list and see your authenticated, created user.

![users list](https://cloud.githubusercontent.com/assets/236501/13648838/6e09216c-e600-11e5-8911-67b7676117f5.png)

Further documentation for custom authentication can be found
[here](http://docs.ionic.io/docs/custom-authentication).
