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

    protected $package;

    protected $services_selecteds;

    /**
     * class constructor
     */
    public function __construct($package, $services)
    {
        $this->package = $package;

        $this->services_selecteds = $services;
    }

    /**
     * @return array
     */
    public function calculate()
    {
        if(empty($this->package['destination']['postcode'])) {
            return false;
        }

        $products = $this->getProducts($this->package);

        return $this->calculateByProducts(
            $products,
            NormalizePostalCodeHelper::get($this->package['destination']['postcode']),
            $services
        );
    }

    /**
     * @param array $products
     * @param string  $to
     * @return array
     */
    public function calculateByProducts($products, $to)
    {
        $payload = $this->createPayload(
            $products,
            NormalizePostalCodeHelper::get($to)
        );

        $quotations = (new RequestService())->request(
            self::ROUTE_CALCULATE,
            'POST',
            $payload
        );

        return $this->filterToRate($quotations);
    }


    /**
     * @param $package
     * @return array
     */
    public function getProducts()
    {
        $products = [];
        foreach ($this->package['contents'] as $values) {
            $product = $values['data'];
            $products[] = [
                'name' => $product->get_name(),
                'unitary_value' => floatval($product->get_price()),
                'insurance_value' => floatval($product->get_price()),
                'width' => wc_get_dimension(floatval($product->get_width()), 'cm'),
                'length' => wc_get_dimension(floatval($product->get_length()), 'cm'),
                'height' => wc_get_dimension(floatval($product->get_height()), 'cm'),
                'weight' => wc_get_weight(floatval($product->get_weight()), 'kg'),
                'quantity' => intval($values['quantity'])
            ];
        }

        return $products;
    }

    /**
     * @param array $products
     * @param string $to
     * @return object
     */
    public function createPayload($products, $to)
    {
        $dataSeller = (new SellerDataService())->get();

        $services = $this->getFilterServices();

        $total = $this->getInsuranceValueByProducts($products);

        return (object) [
            'from' => (object) [
                'postal_code' =>  NormalizePostalCodeHelper::get($dataSeller->postal_code),
            ],
            'to' => (object) [
                'postal_code' => $to
            ],
            'services' => $services,
            'products' => (object) $products,
            'options' => [
                "insurance_value" => ($total <= 1000) ? $total : floatval(1000),
                'receipt' => ($dataSeller->receipt == 'yes') ? true : false,
                'own_hand' => ($dataSeller->own_hand == 'yes') ? true : false,
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
        if (!is_array($quotations)) {
            return $this->handleRates($quotations);
        }

        if (empty($quotations)) {
            return [];
        }

        $rates = [];
        foreach ($quotations as $quotation) {
            $rates[$quotation->id] = $this->handleRates($quotation);

        }

        return $rates;
    }

    /**
     * 
     */
    private function handleRates($quotation)
    {
        $rate  = [];
        if (!empty($quotation->packages)) {
            foreach ($quotation->packages as $package) {
                $volumes[] = [
                    'width' => wc_get_dimension(floatval($package->dimensions->width), 'cm'),
                    'length' => wc_get_dimension(floatval($package->dimensions->length), 'cm'),
                    'height' => wc_get_dimension(floatval($package->dimensions->height), 'cm'),
                    'weight' => wc_get_weight(floatval($package->weight), 'kg'),
                ];
            }

            return [
                'id' => $quotation->id,
                'method_id' => $quotation->id,
                'label' => sprintf('%s %s', $quotation->company->name, $quotation->name),
                'packages' => $volumes,
                'cost' => (isset($quotation->price))
                    ? $quotation->price
                    : 0
            ];
        }

        return false;
    }

    /**
     * @param $products
     * @return float|int
     */
    public function getInsuranceValueByProducts($products)
    {
        $value = 0;
        foreach ($products as $product) {
            $value = $value + floatval($product['unitary_value'] * $product['quantity']);
        }
        return $value;
    }

    /**
     * @retrun string $services;
     */
    private function getFilterServices()
    {
        $services_id = self::SERVICES;

        if (!empty($this->services_selecteds) && is_array($this->services_selecteds)) {
            $services_id = [];
            foreach ((array) array_values($this->services_selecteds) as $key => $service_id) {
                $services_id[] = $this->services_selecteds[$key];
            }

            $services_id = implode(',', $services_id);
        }

        return $services_id;
    }

}
