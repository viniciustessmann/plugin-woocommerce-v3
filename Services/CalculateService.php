<?php

namespace V3\Services;
use V3\Helpers\NormalizePostalCodeHelper;

/**
 * Class CalculateService
 * @package V3\Services
 */
class CalculateService
{
    const ROUTE_CALCULATE = '/shipment/calculate';

    /**
     * @param $package
     * @param $from
     * @param $token
     * @return array
     */
    public function calculate($package, $from, $token)
    {
        $products = $this->getProducts($package);

        if(empty($package['destination']['postcode'])) {
            return false;
        }

        $payload = $this->createPayload(
            $products,
            $from,
            NormalizePostalCodeHelper::get($package['destination']['postcode'])
        );

        $quotations = (new RequestService($token))->request(
            self::ROUTE_CALCULATE,
            'POST',
            $payload);

        return $this->filterToRate($quotations);
    }

    /**
     * @param $package
     * @return array
     */
    public function getProducts($package)
    {
        $products = [];
        foreach ($package['contents'] as $values) {
            $_product = $values['data'];
            $products[] = [
                'name' => $_product->get_name(),
                'unitary_value' => floatval($_product->get_price()),
                'width' => wc_get_dimension(floatval($_product->get_width()), 'cm'),
                'length' => wc_get_dimension(floatval($_product->get_length()), 'cm'),
                'height' => wc_get_dimension(floatval($_product->get_height()), 'cm'),
                'weight' => wc_get_weight(floatval($_product->get_weight()), 'kg'),
                'quantity' => intval($values['quantity'])
            ];
        }

        return $products;
    }

    /**
     * @param $products
     * @param $from
     * @param $to
     * @return object
     */
    public function createPayload($products, $from, $to)
    {
        return (object) [
            'from' => (object) [
                'postal_code' => $from,
            ],
            'to' => (object) [
                'postal_code' => $to
            ],
            'products' => (object) $products
        ];
    }

    /**
     * @param $quotations
     * @return array
     */
    public function filterToRate($quotations)
    {
        if (empty($quotations)) {
            return [];
        }

        $rates = [];
        foreach ($quotations as $quotation) {
            $rates[] = [
                'id' => $quotation->id,
                'method_id' => $quotation->id,
                'label' => sprintf('%s, %s', $quotation->company->name, $quotation->name),
                'cost' => (isset($quotation->price))
                    ? $quotation->price
                    : 0
            ];
        }

        return $rates;
    }

}
