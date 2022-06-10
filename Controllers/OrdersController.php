<?php

namespace Tessmann\Controllers;

use Tessmann\Services\Orders\CartService;

class OrdersController
{
    /**
     * @return mixed
     */
    public function addCart()
    {
        try {
          
            $post_id  = sanitize_text_field($_POST['post_id']);

            if (empty($post_id)) {
                return wp_send_json([
                    'message' => 'informar o parametro "post_id"'
                ], 500);
            }

            $dataOrder = (new CartService())->add($post_id);

            if (isset($dataOrder->error)) {
                return wp_send_json([
                    'success' => false,
                    'message' => $dataOrder->message
                ], 500);
            }

            if (empty($dataOrder->id)) {
                return wp_send_json([
                    'success' => false,
                    'message' => 'Ocorreu um erro ao enviar o pedido para o carrinho de compras'
                ], 500);
            }
            
            return wp_send_json([
                'success' => true,
                'order_id' => $dataOrder->id,
                'protocol' => $dataOrder->protocol
            ], 200);

        } catch (\Exception $exception) {
             return wp_send_json([
                 'success' => false,
                 'message' => 'Ocorreu um erro não esperado'
             ], 500);
        }
    }
}
