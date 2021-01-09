<?php

namespace V3\Services;

/**
 * Class SellerDataService
 * @package V3\Services
 */
class SellerDataService
{
    const KEY_SHIPPING_METHOD_TESSMANN = 'tessmann-shipping';
    /**
     * @return objects
     */
    public function get()
    {
        $data = $this->getShippingMethodTessmann();
        $data['country_id'] = 'BR';
        unset($data['token']);
        unset($data['enabled']);

        return (object) $data;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        $data = $this->getShippingMethodTessmann();
        return  $data['token'];
    }

    /**
     * @return array
     */
    public function getShippingMethodTessmann()
    {
        $shipping_methods = \WC()->shipping->get_shipping_methods();
        $data = null;
        foreach($shipping_methods as $method) {
            if($method->id == self::KEY_SHIPPING_METHOD_TESSMANN) {
                $data = $method->settings;
            }
        }

        return $data;
    }
}