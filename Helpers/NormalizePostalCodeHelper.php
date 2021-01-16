<?php

namespace Tessmann\Helpers;

class NormalizePostalCodeHelper
{
    /**
     * @param $postalcode
     * @return string
     */
    public static function get($postalcode)
    {
        $postalcode = floatval(preg_replace('/\D/', '', $postalcode));

        return str_pad(
            $postalcode,
            8,
            '0',
            STR_PAD_LEFT
        );
    }
}
