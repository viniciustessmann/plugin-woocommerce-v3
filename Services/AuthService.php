<?php

namespace V3\Services;

class AuthService
{
    public function createToken($code)
    {
        $this->requestToken($code);
        die;
    }

    private function requestToken($code)
    {
        $params = array(
            'headers' => array(
                'Accept' => 'application/json'
            ),
            'method'  => 'POST',
            'body'    => json_encode([
                'grant_type' => 'authorization_code',
                'client_id' => 1068,
                'client_secret' => 'lQIOShKBKQFzgNJFBmB6b54JylzZbbK9a0Xm0H5E',
                'redirect_uri' => 'http://127.0.0.1:8000/wp-admin',
                'code' => $code
            ]),
        );

        $response = json_decode(
            wp_remote_retrieve_body(
                wp_remote_post('https://sandbox.melhorenvio.com.br/oauth/token', $params)
            )
        );

        echo '<pre>';
        var_dump($response);
        die;
    }
}
