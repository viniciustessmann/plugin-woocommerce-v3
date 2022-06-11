<?php

namespace Tessmann\Controllers;

use Tessmann\Services\Orders\PayTicketService;

class PayTicketController
{
    public function pay()
    {
        try {

            $response = (new PayTicketService())->pay(sanitize_text_field($_POST['post_id']));

            return wp_send_json($response, 200);


        } catch (\Exception $exception) {
             return wp_send_json([
                 'success' => false,
                 'message' => 'Ocorreu um erro não esperado'
             ], 500);
        }
    }
}
