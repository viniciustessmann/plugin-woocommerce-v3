<?php

namespace V3\Services;

use V3\Models\Order;

/**
 * Class ActionListOrderService
 * @package V3\Services
 */
class ActionListOrderService
{
    /**
     *
     */
    public static function actions()
    {
        add_action( 'manage_shop_order_posts_custom_column' , function($column, $post_id) {
            if ($column !== 'actions-me') {
                return;
            }

            $orderId = (new Order($post_id))->getOrderId();

            if (empty($orderId)) {
                echo '<button class="add-cart-me" data-id="' . $post_id . '">Adicionar ao carrinho do ME </button>';
                echo '<div class="order-id-me-' . $post_id . '"></div>';
            } else {
                echo '<p>Ordem: <b>' . $orderId . '</b></p>';
            }

        }, 20, 2 );
    }

}
