<?php

namespace Ionic;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;

class CustomAuthentication {
    /**
     * @param string GET parameter token.
     * @param string GET parameter state.
     * @param string GET parameter redirect uri.
     * @return string Redirect URI.
     * @throws \Exception
     * @throws ExpiredException
     */
    public static function process($token, $state, $redirect_uri) {
        $request = JWT::decode($token, static::SECRET, ["HS256"]);

        $credentials = [
            'username' => 'dan',
            'password' => '123',
            'user_id' => "user-from-php"
        ];

        // TODO: Authenticate your own real users here
        if ($request->data->username != $credentials['username'] || $request->data->password != $credentials['password']) {
            throw new \Exception('Invalid credentials.');
        } else {
            $user_id = $credentials['user_id'];
        }

        $token = JWT::encode(['user_id' => $user_id], static::SECRET);

        $redirect_uri = $redirect_uri . '&' . http_build_query([
            'token' => $token,
            'state' => $state,
            # TODO: Take out the redirect_uri parameter before production
            'redirect_uri' => 'https://api.ionic.io/auth/integrations/custom/success',
        ]);

        return $redirect_uri;
    }

    const SECRET = "foxtrot";
}
