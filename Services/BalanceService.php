<?php

namespace Tessmann\Services;

use Tessmann\Services\RequestService;

class BalanceService
{
    const ROUTE_BALANCE = '/balance';

    public function get()
    {
        $request_service = new RequestService();

        $result = $request_service->request(self::ROUTE_BALANCE, 'GET', []);

        return (isset($result->balance)) ? $result->balance : 0;
    }

    public function add($value, $gateway)
    {
        $request_service = new RequestService();

        $payload = [
            'value' => $value,
            'gateway' => $gateway,
            'redirect' => $_SERVER['HTTP_REFERER']
        ];

        return $request_service->request(self::ROUTE_BALANCE, 'POST', $payload);
    }
}
