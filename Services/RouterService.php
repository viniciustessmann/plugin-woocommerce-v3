<?php

namespace Tessmann\Services;

use Tessmann\Controllers\AddBalanceController;
use Tessmann\Controllers\OrdersController;
use Tessmann\Controllers\PayTicketController;
use Tessmann\Controllers\PrintController;
use Tessmann\Controllers\RemoveCartController;
use Tessmann\Controllers\OrderTemplateController;

class RouterService
{
    public static function init()
    {
        $addBalanceController = new AddBalanceController();

        $ordersController = new OrdersController();

        $payTicketController = new PayTicketController();

        $printController = new PrintController();   
        
        $removeCartController = new RemoveCartController();

        $orderTemplateController = new OrderTemplateController();

        add_action('wp_ajax_add_balance', [$addBalanceController, 'add']);

        add_action('wp_ajax_add_cart', [$ordersController, 'addCart']);

        add_action('wp_ajax_pay_ticket', [$payTicketController, 'pay']);

        add_action('wp_ajax_print_ticket', [$printController, 'print']);

        add_action('wp_ajax_remove_cart', [$removeCartController, 'remove']);

        add_action('wp_ajax_get_template_order', [$orderTemplateController, 'get']);
    }
}
