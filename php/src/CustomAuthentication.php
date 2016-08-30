<?php

namespace Ionic;

use Firebase\JWT\JWT;

class CustomAuthentication {
    /**
     * @param string GET parameter token.
     * @param string GET parameter state.
     * @param string GET parameter redirect uri.
     * @return string Redirect URI.
     * @throws \Exception
     */
    public static function process($token, $state, $redirect_uri) {
        $request = JWT::decode($token, static::SECRET, ["HS256"]);

        static::validateResponse($request);

        $credentials = [
            'username' => 'dan',
            'password' => '123',
            'user_id' => 1
        ];

        // TODO: Authenticate your own real users here
        if ($request->data->username != $credentials['username'] || $request->data->password != $credentials['password']) {
            throw new \Exception('Invalid credentials.');
        } else {
            $user_id = $credentials['user_id'];
        }

        $token = JWT::encode(['user_id' => $user_id], static::SECRET);

        $redirect_uri = $redirect_uri.'&token='.urlencode($token).'&state='.$state;

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

    const SECRET = "foxtrot";
    const APP_ID = "<YOUR APP ID>";
}
