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
        if (empty($_POST['post_id'])) {
            return wp_send_json([
                'message' => 'informar o parametro "post_id"'
            ], 500);
        }

        $order_id = (new OrdersService())->addCart($_POST['post_id']);

        /**if (!$order_id) {
            return wp_send_json([
                'success' => false,
                'message' => 'Ocorreu um erro ao enviar o pedido para o carrinho de compras'
            ], 500);
        }*/

        return wp_send_json([
            'success' => true,
            'order_id' => $order_id
        ], 200);
    }
}
