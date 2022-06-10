<?php

namespace Tessmann\Controllers;

use Tessmann\Services\Orders\CartService;

class RemoveCartController
{
    public function remove()
    {
        try {

            $result = (new CartService())->remove(sanitize_text_field($_POST['post_id']));

            if (!$result) {
                return wp_send_json([
                    'success' => false,
                    'message' => 'Ocorreu um erro ao remover o item do carrinho de compras'
                ], 400);
            }

            return wp_send_json([$result], 200);


        } catch (\Exception $exception) {
             return wp_send_json([
                 'success' => false,
                 'message' => 'Ocorreu um erro não esperado'
             ], 500);
        }
    }
}
