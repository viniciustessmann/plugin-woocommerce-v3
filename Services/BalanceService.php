<?php

namespace Tessmann\Services;

use Tessmann\Services\RequestService;

class BalanceService
{
    const ROUTE_BALANCE = '/balance';

    public function get()
    {
        $request_service = new RequestService();

        return $request_service->request(self::ROUTE_BALANCE, 'GET', [])->balance;
    }
}
