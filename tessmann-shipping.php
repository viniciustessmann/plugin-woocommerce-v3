<?php

use V3\Services\MenuService;
use V3\Services\RouterService;
use V3\Services\ShippingMethodService;

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
            //MenuService::create(plugin_dir_path(__FILE__));
            RouterService::init();
            ShippingMethodService::load();
        }
    }

    MelhorEnvioPlugin::init();
}
