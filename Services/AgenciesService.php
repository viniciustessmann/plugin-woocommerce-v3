<?php

namespace Tessmann\Services;

class AgenciesService
{
    const JADLOG_ID = 2;

    const ROUTE_GET_AGENCIES = '/shipment/agencies';

    /**
     * @return array
     */
    public function getAgenciesJadlog()
    {

        $sellerData = (new SellerDataService())->get();

        $route = urldecode(sprintf(
            "%s?company=%s&state=%s",
            self::ROUTE_GET_AGENCIES,
            self::JADLOG_ID,
            $sellerData->state
        ));

        $agencies = (new RequestService())->request($route, 'GET', []);

        if (empty($agencies)) {
            $route = urldecode(sprintf(
                "%s?company=%s",
                self::ROUTE_GET_AGENCIES,
                self::JADLOG_ID
            ));
    
            $agencies = (new RequestService())->request($route, 'GET', []);
        }

        $response = [];

        if (!empty($agencies)) {
            foreach ($agencies as $agency) {
                $response[$agency->id] = $agency->name;
            }
        }

        return $response;
    }
}