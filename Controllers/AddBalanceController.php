<?php

namespace Tessmann\Controllers;

use Tessmann\Services\BalanceService;

class AddBalanceController
{
    public function add()
    {
        try {

            $gateway = sanitize_text_field($_POST['gateway']);

            $value = sanitize_text_field($_POST['value']);

            $response = (new BalanceService())->add($value, $gateway);

            return wp_send_json($response, 200);


        } catch (\Exception $exception) {
             return wp_send_json([
                 'success' => false,
                 'message' => 'Ocorreu um erro não esperado'
             ], 500);
        }
    }
}
