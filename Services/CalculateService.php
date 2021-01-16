<?php

namespace Tessmann\Services;
use Tessmann\Helpers\NormalizePostalCodeHelper;

/**
 * Class CalculateService
 * @package Tessmann\Services
 */
class CalculateService
{
    const ROUTE_CALCULATE = '/shipment/calculate';

    const SERVICES = '1,2,3,4,17';

    /**
     * @param $package
     * @param $from
     * @return array
     */
    public function calculate($package, $from)
    {
        if(empty($package['destination']['postcode'])) {
            return false;
        }

        $products = $this->getProducts($package);

        return $this->calculateByProducts(
            $products,
            $from,
            NormalizePostalCodeHelper::get($package['destination']['postcode'])
        );
    }

    /**
     * @param $products
     * @param $from
     * @param $to
     * @return array
     */
    public function calculateByProducts($products, $from, $to)
    {
        $payload = $this->createPayload(
            $products,
            $from,
            NormalizePostalCodeHelper::get($to)
        );

        $quotations = (new RequestService())->request(
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
                'insurance_value' => floatval($_product->get_price()) * intval($values['quantity']),
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
            'services' => self::SERVICES,
            'products' => (object) $products,
            'options' => [
                "insurance_value" => $this->getInsuranceValueByProducts($products),
                'receipt' => false,
                'own_hand' => false,
                'reverse' => false,
                'non_commercial' => true,
            ]
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
            $volumes = [];

            if (!empty($quotation->packages)) {
                foreach ($quotation->packages as $package) {
                    $volumes[] = [
                        'width' => wc_get_dimension(floatval($package->dimensions->width), 'cm'),
                        'length' => wc_get_dimension(floatval($package->dimensions->length), 'cm'),
                        'height' => wc_get_dimension(floatval($package->dimensions->height), 'cm'),
                        'weight' => wc_get_weight(floatval($package->weight), 'kg'),
                    ];
                }

                $rates[$quotation->id] = [
                    'id' => $quotation->id,
                    'method_id' => $quotation->id,
                    'label' => sprintf('%s %s', $quotation->company->name, $quotation->name),
                    'packages' => $volumes,
                    'cost' => (isset($quotation->price))
                        ? $quotation->price
                        : 0
                ];
            }
        }

        return $rates;
    }

    /**
     * @param $products
     * @return float|int
     */
    public function getInsuranceValueByProducts($products)
    {
        $value = 0;
        foreach ($products as $product) {
            $value += floatval($product['unitary_value'] * $product['quantity']);
        }
        return $value;
    }

}
