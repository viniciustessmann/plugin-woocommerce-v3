<?php

namespace Tessmann\Services;

use Tessmann\Controllers\OrdersController;
use Tessmann\Controllers\PrintController;
use Tessmann\Controllers\RemoveCartController;

class RouterService
{
    public static function init()
    {
        $ordersController = new OrdersController();

        $printController = new PrintController();   
        
        $removeCartController = new RemoveCartController();

        add_action('wp_ajax_add_cart', [$ordersController, 'addCart']);

        add_action('wp_ajax_print_ticket', [$printController, 'print']);

        add_action('wp_ajax_remove_cart', [$removeCartController, 'remove']);
    }
}
