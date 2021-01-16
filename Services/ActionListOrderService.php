<?php

namespace Tessmann\Services;

use Tessmann\Models\Order;

/**
 * Class ActionListOrderService
 * @package Tessmann\Services
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
            
            $protocol = (new Order($post_id))->getProtocol();

            if (empty($protocol)) {
                echo '<button class="add-cart-me" data-id="' . $post_id . '">Adicionar</button>';
            } else {
                echo '<p class="order-id-me-' . $post_id . '" style="font-size:10px; margin-top: 10px;">Protocolo: <b>' . $protocol . '</b></p>';
            }
            echo '<div class="receive-protocol-'. $post_id .' "></div>';

        }, 20, 2 );
    }

}
