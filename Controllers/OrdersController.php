<?php

namespace V3\Controllers;

use V3\Services\OrdersService;

class OrdersController
{
    /**
     * @return mixed
     */
    public function addCart()
    {
        try {
            if (empty($_POST['post_id'])) {
                return wp_send_json([
                    'message' => 'informar o parametro "post_id"'
                ], 500);
            }

            $post_id  = $_POST['post_id'];

            $dataOrder = (new OrdersService())->addCart($$post_id);

            return wp_send_json([
                'success' => true,
                'order_id' => $dataOrder->id,
                'protocol' => $dataOrder->protocol
            ], 200);

        } catch (\Exception $exception) {

             return wp_send_json([
                 'success' => false,
                 'message' => 'Ocorreu um erro ao enviar o pedido para o carrinho de compras'
             ], 500);
        }
    }
}
