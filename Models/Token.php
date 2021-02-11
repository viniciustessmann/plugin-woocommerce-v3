<?php

namespace Tessmann\Models;

/**
 * Class Token
 * @package Tessmann\Models
 */
class Token
{
    const MELHOR_ENVIO_TOKEN = 'melhor_envio_token';

    /**
     * @param $protocol
     * @return false|mixed
     */
    public function set($token)
    {
        delete_option(self::MELHOR_ENVIO_TOKEN);
        return (add_option(self::MELHOR_ENVIO_TOKEN, $token, true))
            ? $token
            : false;
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return get_option(self::MELHOR_ENVIO_TOKEN, false);
    }
}