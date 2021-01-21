<?php

namespace Tessmann\Services;

use Tessmann\Helpers\ExtractNumberHelper;

/**
 * Class BuyerService
 * @package Tessmann\Services
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
            "name" => sprintf("%s %s", $order->get_shipping_first_name(), $order->get_shipping_last_name()),
            'phone' => ExtractNumberHelper::extract(get_post_meta($order->get_id(), '_billing_phone', true)),
            "email" => $order->get_billing_email(),
            "document" => ExtractNumberHelper::extract(get_post_meta($order->get_id(), '_billing_cpf')),
            "address" => $order->get_shipping_address_1(),
            "complement" => $order->shipping_complement,
            "number" => get_post_meta($order->get_id(), '_shipping_number', true),
            "district" => get_post_meta($order->get_id(), '_shipping_neighborhood', true),
            "city" => $order->get_shipping_city(),
            "country_id" => "BR",
            "postal_code" => $order->get_shipping_postcode()
        ];
    }
}