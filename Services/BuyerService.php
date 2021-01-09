<?php

namespace V3\Services;

use V3\Helpers\ExtractNumberHelper;

/**
 * Class BuyerService
 * @package V3\Services
 */
class BuyerService
{
    /**
     * @param $order
     * @return object
     *
     */
    public function getBuyerByOrder($order)
    {
        return (object) [
            "name" => sprintf("%s %s", $order->shipping_first_name, $order->shipping_last_name),
            'phone' => ExtractNumberHelper::extract(get_post_meta($order->id, '_billing_phone', true)),
            "email" => $order->get_billing_email(),
            "document" => ExtractNumberHelper::extract(get_post_meta($order->id, '_billing_cpf')),
            "address" => $order->shipping_address_1,
            "complement" => $order->shipping_complement,
            "number" => get_post_meta($order->id, '_shipping_number', true),
            "district" => get_post_meta($order->id, '_shipping_neighborhood', true),
            "city" => $order->shipping_city,
            "country_id" => "BR",
            "postal_code" => $order->shipping_postcode
        ];
    }
}