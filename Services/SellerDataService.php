<?php

namespace V3\Services;

/**
 * Class SellerDataService
 * @package V3\Services
 */
class SellerDataService
{
    /**
     * @return objects
     */
    public function get()
    {
        $shipping_methods = \WC()->shipping->get_shipping_methods();
        $data = null;
        foreach($shipping_methods as $method) {
            if($method->id == 'tessmann-shipping') {
                unset($method->setting['token']);
                $data = $method->settings;
            }
        }

        $data['country_id'] = 'BR';
        unset($data['token']);
        unset($data['enabled']);

        return (object) $data;
    }
}