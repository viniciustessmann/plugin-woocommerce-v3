<?php

namespace V3\Services;


class RequestService
{
    const URL = 'https://api.melhorenvio.com/v2/me';

    const TIMEOUT = 600;

    protected $headers;

    public function __construct()
    {
        $this->headers = array(
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            'Authorization' => 'Bearer ' . (new SellerDataService())->getToken(),
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
            'body'    => json_encode($body),
            'timeout ' => self::TIMEOUT
        );

        return json_decode(
            wp_remote_retrieve_body(
                wp_remote_post(self::URL . $route, $params)
            )
        );
    }

}
