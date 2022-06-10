<?php

namespace Tessmann\Controllers;

use Tessmann\Services\Orders\PrintTicketService;

class PrintController
{
    public function print()
    {
        try {

            $url = (new PrintTicketService())->print(sanitize_text_field($_POST['post_id']));

            if (!$url) {
                return wp_send_json([
                    'success' => false,
                    'message' => 'Ocorreu um erro ao gerar o link de impressão.'
                ], 400);
            }

            return wp_send_json(['url' => $url], 200);


        } catch (\Exception $exception) {
             return wp_send_json([
                 'success' => false,
                 'message' => 'Ocorreu um erro não esperado'
             ], 500);
        }
    }
}
