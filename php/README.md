# Custom Auth with php

The core logic is in `Ionic\CustomAuthenication` class which can be subclassed
and migrated to your own project independent of any frameworks. We are using a 
micro-framework [flight](https://github.com/mikecao/flight) for routing but it 
should be very simple to use your own.

We are using the [firebase/php-jwt](https://github.com/firebase/php-jwt) package 
to work with JWTs from the Ionic API.

Install the dependencies:

```bash
$ composer install
```

Start the server:

```bash
$ php -S localhost:8000 routing.php
```

For testing you can use follow this [link](http://localhost:8000/auth?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJkYXRhIjp7InVzZXJuYW1lIjoiVXNlcm5hbWUiLCJwYXNzd29yZCI6IlBhc3N3b3JkIn0sImV4cCI6MjQ3MjIxNjQ0NywiYXBwX2lkIjoiPFlPVVIgQVBQIElEPiJ9.J7nG8iM2eschTAjG882QBO-FXcO8hlwkkTGyB-hdS5k&redirect_uri=https://api.ionic.io/auth/integrations/custom?app_id=f028dfca). 
You should receive a 400 error, this at least means things are setup properly,
you just don't have a real token being sent. 
