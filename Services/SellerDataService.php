<?php

namespace Tessmann\Services;

use Tessmann\Helpers\NormalizePostalCodeHelper;
use Tessmann\Helpers\ExtractNumberHelper;

/**
 * Class SellerDataService
 * @package Tessmann\Services
 */
class SellerDataService
{
    const KEY_SHIPPING_METHOD_TESSMANN = 'tessmann-shipping';
    /**
     * @return objects
     */
    public function get()
    {
        $store_address     = get_option( 'woocommerce_store_address' );
        $store_address_2   = get_option( 'woocommerce_store_address_2' );
        $store_city        = get_option( 'woocommerce_store_city' );
        $store_postcode    = get_option( 'woocommerce_store_postcode' );

        $store_raw_country = get_option( 'woocommerce_default_country' );
        $split_country = explode( ":", $store_raw_country );
        $store_country = $split_country[0];
        $store_state   = $split_country[1];

        $data = $this->getShippingMethodTessmann();

        return (object) [
            "name" =>  $data['name'],
            "phone" => ExtractNumberHelper::extract($data['phone']),
            "email" => $data['email'],
            "document" => ExtractNumberHelper::extract($data['document']),
            "address" => $store_address,
            "number" => $store_address_2,
            "city" => $store_city,
            "country_id" => $store_country,
            'state' => $store_state,
            "postal_code" => NormalizePostalCodeHelper::get(get_option( 'woocommerce_store_postcode' ))
        ];
    }

    /**
     * @return string
     */
    public function getToken()
    {
        $data = $this->getShippingMethodTessmann();

        if (empty($data)) {
            return false;
        }

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