<?php

namespace Tessmann\Services\Orders;

use Tessmann\Models\Order;
use Tessmann\Services\RequestService;

class GetDataService
{
    const ROUTE_MELHOR_ENVIO_DETAIL_ORDER = '/orders/';

    /**
     * @param int $order_id
     * @return object
     */
    public function get($post_id)
    {
        $order_id = (new Order($post_id))->getOrderId();

        if (empty($order_id)) {
            return false;
        }

        $data =  (new RequestService())->request(
            Self::ROUTE_MELHOR_ENVIO_DETAIL_ORDER . $order_id,
            'GET',
            []
        );

        if (isset($data->message) && $data->message === 'No query results for model [App\Order].') {
            return (new Order($post_id))->destroy();
        }

        return $data;
    }
}
