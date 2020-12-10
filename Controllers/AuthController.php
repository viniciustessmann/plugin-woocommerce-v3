<?php

namespace V3\Controllers;

use V3\Services\AuthService;

class AuthController
{
    public function getCode()
    {
        try {
            if (!empty($_GET['code'])) {
                $token = (new AuthService())->createToken($_GET['code']);
            }
        } catch (\Exception $e) {
            return wp_send_json([
                'success' => false,
                'message' => 'Ocorreu um erro ao obter o token de acesso'
            ], 500);
        }
    }
}
