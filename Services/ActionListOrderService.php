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
            
            $protocol = (new Order($post_id))->getProtocol();

            if (empty($protocol)) {
                echo '<button class="add-cart-me" data-id="' . $post_id . '">Adicionar</button>';
            } else {
               echo '<p style="font-size:10px; margin-top: 10px;">Protocolo: <b>' . $protocol . '</b></p>';
            }
        }, 20, 2 );
    }

}
