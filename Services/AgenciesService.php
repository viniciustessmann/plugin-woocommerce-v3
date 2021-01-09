<?php

namespace V3\Services;

class AgenciesService
{
    const JADLOG_ID = 2;

    const ROUTE_GET_AGENCIES = '/shipment/agencies';

    /**
     * @return array
     */
    public function getAgenciesJadlog()
    {
        $route = urldecode(sprintf(
            "%s?company=%s",
            self::ROUTE_GET_AGENCIES,
            self::JADLOG_ID
        ));

        $agencies = (new RequestService())->request($route, 'GET', []);

        $response = [];

        if (!empty($agencies)) {
            foreach ($agencies as $agency) {
                $response[$agency->code] = $agency->name;
            }
        }
        return $response;
    }
}