<?php

namespace Tessmann\Services;

use Tessmann\Models\Token;

class RequestService
{
    const URL = 'https://melhorenvio.com/api/v2/me';

    // const URL = 'https://sandbox.melhorenvio.com.br/api/v2/me';

    const TIMEOUT = 120;

    protected $headers;

    public function __construct()
    {
        $this->headers = array(
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            'Authorization' => 'Bearer ' . (new Token())->get(),
        );
    }

    /**
     * Function to make a request to API Melhor Envio.
     *
     * @param string $route
     * @param string $typeRequest
     * @param object $body
     * @return object $response
     */
    public function request($route, $typeRequest, $body)
    {
        $params = array(
            'headers' => $this->headers,
            'method'  => $typeRequest,
            'body'    => (!empty($body)) ? json_encode($body) : null,
            'timeout ' => self::TIMEOUT
        );

        return json_decode(
            wp_remote_retrieve_body(
                wp_remote_post(self::URL . $route, $params)
            )
        );
    }
}
