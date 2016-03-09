var http = require('http');
var https = require('https');

var args = process.argv;

if (args.length < 3) {
  console.error("usage: node genurl.js <YOUR_APP_ID>");
  process.exit(1);
}

var appId = args[2];

if (appId == '<YOUR_APP_ID>') {
  console.error("you must actually supply your app ID to this script. replace <YOUR_APP_ID> with your actual app ID");
  process.exit(1);
}

var options = {
  hostname: 'api.ionic.io',
  // hostname: 'localhost',
  port: 443,
  // port: 7000,
  path: '/auth/login/custom',
  method: 'POST',
  headers: {
    'Content-Type': 'application/json'
  }
};

var req = https.request(options, function(res) {
  res.on('data', function(d) {
    d = JSON.parse(d.toString());

    if (res.statusCode != 200) {
      console.error("!!! Error in Ionic Auth !!!");
      console.error(JSON.stringify(d, null, '  '));
      process.exit(1);
    }

    console.log(d.data.url);
  });
});

var postData = {
  'app_id': appId,
  'data': {
    'username': 'dan',
    'password': '123'
  }
};

req.write(JSON.stringify(postData));
req.end();

req.on('error', function(e) {
  console.error(e);
  process.exit(1);
});
