<?php

namespace Tessmann\Services;

use Tessmann\Helpers\LoaderComponentHelper;
use Tessmann\Models\Order;
use Tessmann\Services\BoxMetaService;

/**
 * Class ActionListOrderService
 * @package Tessmann\Services
 */
class ActionListOrderService
{
    public static function actions()
    {
        add_action( 'manage_shop_order_posts_custom_column' , function($column, $post_id) {
            
            if ($column !== 'actions-me') {
                return;
            }
            
            $protocol = (new Order($post_id))->getProtocol();
            $urlPrint = (new Order($post_id))->getUrlPrint();

            if (empty($protocol)) {
                echo '<button class="button refund-items add-cart-me-list" data-id="' . $post_id . '">Adicionar</button>';
                echo LoaderComponentHelper::add('add-cart-me-list', $post_id,25);
                
            } else {
                echo '<p class="order-id-me-' . $post_id . '" style="font-size:10px; margin-top: 10px;">Protocolo: <b>' . $protocol . '</b></p>';

                if (!empty($urlPrint)) {
                    echo '<a target="_blank" href="' . $urlPrint . '">Imprimir</a>';
                }
            }
            echo '<div class="receive-protocol-'. $post_id .' "></div>';

        }, 20, 2 );
    }

}
