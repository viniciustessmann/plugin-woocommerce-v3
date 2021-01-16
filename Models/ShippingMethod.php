<?php

namespace Tessmann\Models;

class ShippingMethod
{
    const CORREIOS_PAC = 'Correios PAC';

    const CORREIOS_PAC_ID = 1;

    const CORREIOS_SEDEX = 'Correios Sedex';

    const CORREIOS_SEDEX_ID = 2;

    const JADLOG_PACKAGE = 'Jadlog .Package';

    const JADLOG_PACKAGE_ID = 3;

    const JADLOG_COM = 'Jadlog .Com';

    const JADLOG_COM_ID = 4;

    const CORREIOS_MINI = 'Correios Mini Envios';

    const CORREIOS_MINI_ID = 17;

    /**
     * @param $method
     * @return int
     */
    public function getCode($method)
    {
        switch ($method) {
            case self::CORREIOS_PAC:
                return self::CORREIOS_PAC_ID;
            case self::CORREIOS_SEDEX:
                return self::CORREIOS_SEDEX_ID;
            case self::JADLOG_PACKAGE:
                return self::JADLOG_PACKAGE_ID;
            case self::JADLOG_COM:
                return self::JADLOG_COM_ID;
            case Self::CORREIOS_MINI:
                return self::CORREIOS_MINI_ID;
            default:
                return self::CORREIOS_SEDEX_ID;
        }

    }

    /**
     * @param $method_id
     * @return bool
     */
    public static function isJadlog($method_id)
    {
        return in_array($method_id, [self::JADLOG_PACKAGE_ID, self::JADLOG_COM_ID]);
    }
}