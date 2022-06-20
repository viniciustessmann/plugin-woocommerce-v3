<?php

namespace Tessmann\Models;

use Tessmann\Helpers\NoticeHelper;

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

    public function isTokenValid()
    {   
        $token = get_option(self::POST_META_TOKEN_MELHOR_ENVIO, null);

        if (empty($token)) {
            NoticeHelper::addNotice('Você precisa gerar seu token Melhor Envio e adicionar o token nas configurações do plugin Tessmann cotações', 'notice-error');
            return false;
        }

        $decode_token = json_decode(
            base64_decode(
                str_replace('_', '/', 
                    str_replace('-','+',
                        explode('.', $token)[1]
                    )
                )
            )
        );

        if (!isset($decode_token->exp)) {
            NoticeHelper::addNotice('Seu token Melhor Envio está inválido, gere um novo token no painel do Melhor Envio', 'notice-error');
            return false;
        }

        if (date('Y-m-d', $decode_token->exp) < date('Y-m-d')) {
            NoticeHelper::addNotice('Seu token Melhor Envio está inválido ou expirado, gere um novo token no painel do Melhor Envio', 'notice-error');
            return false;
        }

        return true;
    }
}