<?php

namespace Tessmann\Services;

use Tessmann\Models\Order;
use Tessmann\Services\OrdersService;
use Tessmann\Services\RequestService;

class RemoveCartService
{
    const ROUTE_MELHOR_ENVIO_REMOVE_ITEM_CART = '/cart';
    
    public function remove($post_id)
    {
        $order = new Order($post_id);

        $order_id = $order->getOrderId();

        if (!$order_id) {
            return false;
        }

        $detail = (new OrdersService())->get($post_id, $order_id);

        if (!isset($detail->id)) {
            return false;
        }

        $response =  (new RequestService())->request(self::ROUTE_MELHOR_ENVIO_REMOVE_ITEM_CART . '/' . $detail->id, 'DELETE', []);

        if (!empty($response)) {
            return false;
        }

        $order->destroy();

        return true;
    }
}
