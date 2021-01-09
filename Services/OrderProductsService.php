<?php

namespace V3\Services;

class OrderProductsService
{
    /**
     * @param $order
     * @return array
     */
    public function getProductByOrder($order)
    {
        $products = [];
        foreach ( $order->get_items() as $item_id => $_product ) {

            $product = $_product->get_product();

            $products[] = [
                'name' => $_product->get_name(),
                'unitary_value' => floatval($product->get_price()),
                'width' => wc_get_dimension(floatval($product->get_width()), 'cm'),
                'length' => wc_get_dimension(floatval($product->get_length()), 'cm'),
                'height' => wc_get_dimension(floatval($product->get_height()), 'cm'),
                'weight' => wc_get_weight(floatval($product->get_weight()), 'kg'),
                'quantity' => intval($_product->get_quantity())
            ];
        }
        return $products;
    }

    public function getVolumeByOrder($order)
    {

    }


}
