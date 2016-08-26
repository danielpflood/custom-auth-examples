<?php

namespace Ionic;

use Firebase\JWT\JWT;

class CustomAuthentication {
    /**
     * @return string Redirect URI.
     * @throws \Exception
     */
    public static function process() {
        $request = JWT::decode($_GET['token'], static::getSecret(), ["HS256"]);

        static::validateResponse($request);

        $user_id = static::signIn($request->data->username, $request->data->password);

        $token = JWT::encode(['user_id' => $user_id], static::getSecret());

        $redirect_uri = $_GET['redirect_uri'].'&token='.urlencode($token).'&state='.$_GET['state'];

        return $redirect_uri;
    }

    static function validateResponse($response) {
        if (strcmp($response->app_id, static::APP_ID) !== 0) {
            throw new \Exception('APP_ID ('.$response->app_id.') did not match expected APP_ID.');
        }
        if ($response->exp < time()) {
            throw new \Exception('Token expired. ('.$response->exp.' < '.time().')');
        }
    }

    /**
     * @param $username
     * @param $password
     * @return mixed
     * @throws \Exception
     */
    public static function signIn($username, $password) {
        $credentials = [
            'username' => 'Username',
            'password' => 'Password',
            'user_id' => 1
        ];

        if ($username == $credentials['username']) {
            if ($password == $credentials['password']) {
                return $credentials['user_id'];
            }
        }
        throw new \Exception('Invalid credentials.');
    }

    public static function getSecret() {
        return 'Foxtrot';
    }
    const APP_ID = "<YOUR APP ID>";
}
