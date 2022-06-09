<?php

namespace Tessmann\Models;

class ShippingMethod
{
    const COMPANY_CORREIOS = 1;

    const COMPANY_JADLOG = 2;

    const COMPANY_LATAM_CARGO = 6;

    const COMPANY_BUSLOG = 12;

    const CORREIOS_PAC = 'Correios PAC';

    const CORREIOS_PAC_ID = 1;

    const CORREIOS_SEDEX = 'Correios Sedex';

    const CORREIOS_SEDEX_ID = 2;

    const JADLOG_PACKAGE = 'Jadlog .Package';

    const JADLOG_PACKAGE_ID = 3;

    const JADLOG_COM = 'Jadlog .Com';

    const JADLOG_COM_ID = 4;

    const LATAM_CARGO_EFACIL = 'LATAM Cargo éFácil';

    const LATAM_CARGO_EFACIL_ID = 12;

    const CORREIOS_MINI = 'Correios Mini Envios';

    const CORREIOS_MINI_ID = 17;

    const BUSLOG_RODOVIARIO = 'Buslog Rodoviário';

    const BUSLOG_RODOVIARIO_ID = 22;

    const CORREIOS_PAC_GD = 'Correios PAC GF';

    const CORREIOS_PAC_GD_ID = 23;

    const CORREIOS_SEDEX_GD = 'Correios Sedex GF';

    const CORREIOS_SEDEX_GD_ID = 24;


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
            case self::LATAM_CARGO_EFACIL:
                return self::LATAM_CARGO_EFACIL_ID;
            case self::CORREIOS_MINI:
                return self::CORREIOS_MINI_ID;
            case self::BUSLOG_RODOVIARIO:
                return self::BUSLOG_RODOVIARIO_ID;
            case self::CORREIOS_PAC_GD:
                return self::CORREIOS_PAC_GD_ID;
            case self::CORREIOS_SEDEX_GD:
                return self::CORREIOS_SEDEX_GD_ID;
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

    /**
     * @param $method_id
     * @return bool
     */
    public static function isLatamCargo($method_id)
    {
        return in_array($method_id, [self::LATAM_CARGO_EFACIL_ID]);
    }

    /**
     * @param $method_id
     * @return int
     */
    public static function howCompanyByMethod($method_id)
    {
        if (in_array(
            $method_id, [
                self::CORREIOS_PAC_ID,
                self::CORREIOS_SEDEX_ID,
                self::CORREIOS_MINI_ID,
                self::CORREIOS_PAC_GD_ID,
                self::CORREIOS_SEDEX_GD_ID
            ])) {
            return self::COMPANY_CORREIOS;
        }

        if (in_array($method_id, [self::JADLOG_PACKAGE_ID, self::JADLOG_COM_ID])) {
            return self::COMPANY_JADLOG;
        }

        if (in_array($method_id, [self::LATAM_CARGO_EFACIL_ID])) {
            return self::COMPANY_LATAM_CARGO;
        }

        if (in_array($method_id, [self::BUSLOG_RODOVIARIO_ID])) {
            return self::COMPANY_BUSLOG;
        }
    }
}