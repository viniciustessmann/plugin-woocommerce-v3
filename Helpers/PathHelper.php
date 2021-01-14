<?php

namespace V3\Helpers;

class PathHelper
{
    const PLUGIN_DIR_NAME = '/tessmann-cotacoes';

    public  static function getPathRootPlugin()
    {
        $path = explode(self::PLUGIN_DIR_NAME  , __FILE__);

        return $path[0] . self::PLUGIN_DIR_NAME;
    }
}
