<?php

namespace Tessmann\Models;

/**
 * Class Token
 * @package Tessmann\Models
 */
class Token
{
    const POST_META_TOKEN_MELHOR_ENVIO = 'tessmann_melhor_envio_option';

    /**
     * @param string $token
     * @return false|mixed
     */
    public function set($token)
    {
        delete_option(self::POST_META_TOKEN_MELHOR_ENVIO);
        return add_option(self::POST_META_TOKEN_MELHOR_ENVIO, $token, true);
    }

    /**
     * @return string
     */
    public function get()
    {
       return get_option(self::POST_META_TOKEN_MELHOR_ENVIO, null);
    }
}