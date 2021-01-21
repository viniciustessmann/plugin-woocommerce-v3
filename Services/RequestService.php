<?php

namespace Tessmann\Services;


class RequestService
{
    const URL = 'https://api.melhorenvio.com/v2/me';

    //const URL = 'https://sandbox.melhorenvio.com.br/api/v2/me';

    const TIMEOUT = 120;

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
            'body'    => (!empty($body)) ? json_encode($body) : null,
            'timeout ' => self::TIMEOUT
        );

        /**if ($route == "/shipment/calculate") {
            echo '<pre>';
            var_dump(wp_remote_retrieve_body(
                wp_remote_post(self::URL . $route, $params)
            ));
            die;
        }*/

        return json_decode(
            wp_remote_retrieve_body(
                wp_remote_post(self::URL . $route, $params)
            )
        );
    }

}
