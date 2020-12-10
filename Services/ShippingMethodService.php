<?php

namespace V3\Services;

class ShippingMethodService
{
    public function __construct()
    {
        include_once ABSPATH . 'wp-content/plugins/woocommerce/includes/class-woocommerce.php';
        include_once ABSPATH . 'wp-content/plugins/woocommerce/woocommerce.php';
        include_once ABSPATH . 'wp-content/plugins/woocommerce/includes/abstracts/abstract-wc-shipping-method.php';
    }

    public static function load()
    {
        require_once plugin_dir_path(__DIR__) . 'includes/shipping_methods/shipping_method.php';
    }
}
