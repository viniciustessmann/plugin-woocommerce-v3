<?php

namespace Tessmann\Services\Orders;

use Tessmann\Models\Order;
use Tessmann\Services\GenerateTicketService;
use Tessmann\Services\Orders\GetDataService;
use Tessmann\Services\RequestService;

class PrintTicketService
{
    const ROUTE_MELHOR_ENVIO_PRINT_TICKET = '/shipment/print';
    
    public function print($post_id)
    {
        $order_id = (new Order($post_id))->getOrderId();

        $data = $this->is_valid($post_id, $order_id);

        if (!$data) {
            return false;
        }

        if (empty($data->paid_at)) {
            return false;
        }

        if (empty($data->generated_at)) {

            $generate_service = new GenerateTicketService();

            $result = $generate_service->generate($order_id);
        }

        $request_service = new RequestService();

        $payload = [
            'mode' => 'public',
            'orders' => [$order_id]
        ];

        $result = $request_service->request(self::ROUTE_MELHOR_ENVIO_PRINT_TICKET, 'POST', $payload);

        if (!isset($result->url)) {
            return false;
        }

        (new Order($post_id))->setUrlPrint($result->url);

        return $result->url;
    }

    public function is_valid($post_id, $order_id)
    {
        if (empty($order_id)) {
            return false;
        }

        $data = (new GetDataService())->get($post_id);

        if (empty($data)) {
            return false;
        }

        if (!isset($data->id)) {
            return false;
        }

        return $data;
    }
}
