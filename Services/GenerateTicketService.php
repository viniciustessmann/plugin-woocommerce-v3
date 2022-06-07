<?php

namespace Tessmann\Services;

use Tessmann\Models\Order;
use Tessmann\Services\RequestService;

class GenerateTicketService
{
    const ROUTE_MELHOR_ENVIO_GENERATE_TICKET = '/shipment/generate';

    public function generate($order_id)
    {
        $payload = [
            'mode' => 'public',
            'orders' => [$order_id]
        ];

        $request_service = new RequestService();

        return $request_service->request(self::ROUTE_MELHOR_ENVIO_GENERATE_TICKET, 'POST', $payload);
    }
}
