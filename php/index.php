<?php

use Ionic\CustomAuthentication;

require 'vendor/autoload.php';

Flight::route('/auth',function () {
    try {
        $redirect_uri = CustomAuthentication::process();
        Flight::redirect($redirect_uri);
    } catch (\Exception $e) {
        Flight::json(['error' => $e->getMessage(), 'code' => $e->getCode()], 401);
    }
});

Flight::start();
