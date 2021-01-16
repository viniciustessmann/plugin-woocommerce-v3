<?php

namespace Tessmann\Services;

use Tessmann\Controllers\OrdersController;

class RouterService
{
    public static function init()
    {
        $ordersController = new OrdersController();

        add_action('wp_ajax_add_cart', [$ordersController, 'addCart']);
    }
}
