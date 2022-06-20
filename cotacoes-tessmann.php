<?php

use Tessmann\Helpers\NoticeHelper;
use Tessmann\Models\Token;
use Tessmann\Services\RequestService;
use Tessmann\Services\RouterService;
use Tessmann\Services\ShippingMethodService;
use Tessmann\Services\ColumnsListOrdersService;
use Tessmann\Services\ActionListOrderService;
use Tessmann\Services\HealthService;
use Tessmann\Services\BoxMetaService;
use Tessmann\Services\AddDataAccountClientService;

require __DIR__ . '/vendor/autoload.php';

/*
Plugin Name: Cotações Tessmann
Plugin URI: https://github.com/viniciustessmann/plugin-woocommerce-v3
Description: Esse plugin foi desenvolvido para realizar cotações com a API pública do Melhor Envio e também para inserir os pedidos do WooCommerce no carrinho de compras do Melhor Envio. 
Version: 1.8.0
Author: Vinícius Schlee Tessmann
Author URI:
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: baseplugin
Tested up to: 6.0
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
            (new Token())->isTokenValid();

            if (!RequestService::isValid()) {
                NoticeHelper::addNotice('Seu token Melhor Envio está inválido, gere um novo token no painel do Melhor Envio', 'notice-error');
            }

            add_action('woocommerce_init', function() {
                HealthService::check();
                RouterService::init();
                ShippingMethodService::load();
                ColumnsListOrdersService::insertColumnCart();
                ActionListOrderService::actions();
                BoxMetaService::add();

                add_action( 'admin_enqueue_scripts', function(){
                    wp_enqueue_script(
                        'actions-me',
                        plugin_dir_url(__FILE__) . 'src/js/actions.js'
                    );
                });
            });

            add_filter( 'woocommerce_account_orders_columns', function ($columns) {
                return AddDataAccountClientService::createColumn($columns);
            }, 10, 1 );
        

            add_action( 'woocommerce_my_account_my_orders_column_tracking_column', function ($order) {
                return AddDataAccountClientService::insertDataColumn($order);
            });
        }
    }

    MelhorEnvioPlugin::init();
}
