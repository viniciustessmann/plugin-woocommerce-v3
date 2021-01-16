<?php

namespace Tessmann\Services;

class ShippingMethodService
{
    public static function load()
    {
        require_once plugin_dir_path(__DIR__) . 'includes/shipping_methods/shipping_method.php';
    }
}
