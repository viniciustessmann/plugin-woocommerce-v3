<?php

namespace V3\Services;

class CalculateService
{
    public function calculate($package)
    {
        $weight = 0;

        foreach ($package['contents'] as $values) {
            //$_product = $values['data'];
            //$weight = $weight + $_product->get_weight() * $values['quantity'];
        }

        //$weight = wc_get_weight($weight, 'kg');

        return [
            [
                'id' => 1,
                'label' => 'Correios Pac (Melhor Envio)',
                'cost' => rand(0, 100)
            ],
            [
                'id' => 2,
                'label' => 'Correios Sedex (Melhor Envio)',
                'cost' => rand(0, 100)
            ],
            [
                'id' => 3,
                'label' => 'Jadlog .Com (Melhor Envio)',
                'cost' => rand(0, 100)
            ],
        ];
    }
}
