<?php

namespace Tessmann\Services;

use Tessmann\Helpers\NoticeHelper;
use Tessmann\Models\Token;

class RequestService
{
    const URL = 'https://api.melhorenvio.com/v2/me';

    // const URL = 'https://sandbox.melhorenvio.com.br/api/v2/me';

    const TIMEOUT = 120;

    const OPTION_MELHOR_ENVIO_TOKEN_VALID = 'token_me_invalid';

    protected $headers;

    public function __construct()
    {
        $token = (new Token())->get();

        $this->headers = array(
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            'Authorization' => 'Bearer ' . $token,
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

        if (!self::isValid()) {
            return [];
        }

        $result = json_decode(
            wp_remote_retrieve_body(
                wp_remote_post(self::URL . $route, $params)
            )
        );

        if (isset($result->message) && $result->message == 'Unauthenticated.') {
            self::setAsInvalid();
            return $result;
        }

        return $result;
    }

    public static function setAsInvalid()
    {
        add_option(self::OPTION_MELHOR_ENVIO_TOKEN_VALID, 'invalid');
    }

    public static function setAsValid()
    {
        delete_option(self::OPTION_MELHOR_ENVIO_TOKEN_VALID);
    }

    public static function isValid()
    {
        $option = get_option(self::OPTION_MELHOR_ENVIO_TOKEN_VALID);

        return ($option == 'invalid') ? false : true; 
    }
}
