<?php

namespace V3\Services;

use V3\Controllers\OrdersController;
use V3\Controllers\AuthController;

class RouterService
{
    public static function init()
    {
        $authController = new AuthController();
        $ordersController = new OrdersController();

        add_action('wp_ajax_get_code', [$authController, 'getCode']);
        add_action('wp_ajax_add_cart', [$ordersController, 'addCart']);
    }
}
