<?php

namespace V3\Services;

use V3\Models\Order;
use V3\Models\ShippingMethod;
use V3\Services\SellerDataService;

class OrdersService
{
    const PLATAFORM = 'Tessmann shipping V1';

    const ROUTE_MELHOR_ENVIO_ADD_CART = '/cart';

    const ROUTE_MELHOR_ENVIO_DETAIL_ORDER = '/orders/search?q=';

    /**
     * @param $post_id
     * @return false|object
     */
    public function addCart($post_id)
    {
        $order = wc_get_order($post_id);

        $products = (new OrderProductsService())->getProductByOrder($order);

        $seller = (new SellerDataService())->get();

        $buyer = (new BuyerService())->getBuyerByOrder($order);

        $methodTitle = end($order->get_items( 'shipping' ))->get_name();

        $method_selected = (new ShippingMethod())
            ->getCode($methodTitle);

        $quotations = (new CalculateService())->calculateByProducts(
            $products,
            $seller->postal_code,
            $buyer->postal_code);

        if(empty($quotations[$method_selected]['packages'])) {
            return false;
        }

        $body = array(
            'from' => $seller,
            'to' => $buyer,
            //'agency' => $this->getAgencyToInsertCart($shippingMethodId),
            'service' => $method_selected,
            'products' => $products,
            'volumes' => $quotations[$method_selected]['packages'],
            'options' => array(
                "insurance_value" => $order->get_subtotal(),
                "receipt" => false,
                "own_hand" => false,
                "collect" => false,
                "non_commercial" => true,
                'platform' => self::PLATAFORM
            )
        );

        $data = (new RequestService())->request(
            Self::ROUTE_MELHOR_ENVIO_ADD_CART,
            'POST',
            $body
        );

        if(empty($data->id)) {
            return false;
        }

        $orderEntity = (new Order($post_id));
        $orderEntity->setOrderId($data->id);
        $orderEntity->setProtocol($data->protocol);

        return $data;
    }

    public function get($order_id)
    {
        return (new RequestService())->request(
            Self::ROUTE_MELHOR_ENVIO_DETAIL_ORDER . $order_id,
            'GET',
            []
        );
    }

}
