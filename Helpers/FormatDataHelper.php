<?php

namespace Tessmann\Helpers;

class FormatDataHelper
{
    /**
     * @param $value
     * @return string
     */
    public static function toBr($value)
    {
       $data = explode(" ", $value);

       $date = explode("-", $data[0]);

       $date = $date[2] . '/' . $date[1] . '/' . $date[0];

       $hour = explode(':', $data[1]);

       $hour = $hour[0] . ':' . $hour[1]; 

       return $date . ' ' . $hour;
    }
}
