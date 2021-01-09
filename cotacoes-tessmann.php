<?php

use V3\Services\RouterService;
use V3\Services\ShippingMethodService;
use V3\Services\ColumnsListOrdersService;
use V3\Services\ActionListOrderService;

require __DIR__ . '/vendor/autoload.php';

/*
Plugin Name: Tessmann Envio
Plugin URI:
Description: Plugin para cotação e compra de fretes utilizando a API pública do Melhor Envio.
Version: 1.0.0
Author: Vinícius Schlee Tessmann
Author URI:
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: baseplugin
Tested up to: 5.0
Requires PHP: 5.6
WC requires at least: 4.0
WC tested up to: 5.6
Domain Path: /languages
*/

if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__));
}

if (!class_exists('MelhorEnvioPlugin')) {

    /**
     * Class MelhorEnvioPlugin
     *
     */
    class MelhorEnvioPlugin
    {
        public static function init()
        {
            RouterService::init();
            ShippingMethodService::load();
            ColumnsListOrdersService::insertColumnCart();
            ActionListOrderService::actions();

            add_action( 'admin_enqueue_scripts', function(){
                wp_enqueue_script(
                    'actions-me',
                    '/wp-content/plugins/tessmann-cotacoes/src/js/actions.js'
                );
            });
        }
    }

    MelhorEnvioPlugin::init();
}
