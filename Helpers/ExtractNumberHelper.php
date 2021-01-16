<?php

namespace Tessmann\Helpers;

class ExtractNumberHelper
{
    /**
     * @param $value
     * @return string
     */
    public static function extract($value)
    {
        $value = preg_replace('/\D/', '', $value);
        if (is_array($value)) {
            return end($value);
        }

        return $value;
    }
}
