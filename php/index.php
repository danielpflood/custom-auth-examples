<?php

use Ionic\CustomAuthentication;

require 'vendor/autoload.php';

Flight::route('/auth',function () {
    try {
        $redirect_uri = CustomAuthentication::process($_GET['token'], $_GET['state'], $_GET['redirect_uri']);
        Flight::redirect($redirect_uri);
    } catch (\Exception $e) {
        Flight::json(['error' => $e->getMessage(), 'code' => $e->getCode()], 401);
    }
});

Flight::start();
