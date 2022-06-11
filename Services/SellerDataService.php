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
            "name" =>  (!empty($data['name'])) 
                ? $data['name'] 
                : null,
            "phone" => (!empty($data['phone'])) 
                ? ExtractNumberHelper::extract($data['phone'])
                : null,
            "email" => (!empty($data['email'])) 
                ? $data['email'] 
                : null,
            "document" => (!empty($data['document'])) 
                ? ExtractNumberHelper::extract($data['document']) 
                : null,
            "address" => $store_address,
            'receipt' => (isset($data['receipt'])) ? $data['receipt'] :  false,
            'own_hand' => (isset($data['own_hand'])) ? $data['own_hand'] :  false,
            "economic_activity_code" => (!empty($data['cnae'])) 
                ? $data['cnae'] 
                : null,
            "number" => $store_address_2,
            "city" => $store_city,
            "country_id" => $store_country,
            'state' => $store_state,
            "postal_code" => NormalizePostalCodeHelper::get(get_option( 'woocommerce_store_postcode' )),
            "agency_jadlog" => (!empty($data['agency_jadlog'])) 
                ? $data['agency_jadlog'] 
                : null,
            "agency_latam" => (!empty($data['agency_latam'])) 
                ? $data['agency_latam'] 
                : null
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