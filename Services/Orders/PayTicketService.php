<?php

namespace Tessmann\Services\Orders;

use Tessmann\Models\Order;
use Tessmann\Services\RequestService;

class PayTicketService
{
    const ROUTE_MELHOR_ENVIO_CHECKOUT = '/shipment/checkout';
    
    public function pay($post_id)
    {
        $order_id = (new Order($post_id))->getOrderId();

        if (empty($order_id)) {
            return false;
        }

        $request_service = new RequestService();

        $payload = [
            'orders' => [$order_id]
        ];

        $response = $request_service->request(self::ROUTE_MELHOR_ENVIO_CHECKOUT, 'POST', $payload);

        if (!isset($response->purchase)) {
            return false;
        }

        return $response;
    }
}
