# Custom Auth with PHP

The core logic is in `Ionic\CustomAuthentication` class which takes the token,
redirect_uri, and state from the GET request. We are using a micro-framework
[Flight](https://github.com/mikecao/flight) for routing but it should be very
simple to use your own.

We are using the [firebase/php-jwt](https://github.com/firebase/php-jwt)
package to work with JWTs from the Ionic API.

Install the dependencies (see [composer docs](https://getcomposer.org/)):

```bash
$ composer install
```

Start the server:

```bash
$ php -S localhost:5000 routing.php
```

For testing follow the instructions in the main
[readme](https://github.com/driftyco/custom-auth-examples/blob/master/README.md)
file.
