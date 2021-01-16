<?php

namespace V3\Helpers;

class PathHelper
{
    const PLUGIN_DIR_NAME = '/tessmann-cotacoes';

    public  static function getPathRootPlugin($absolute)
    {
        if (empty($absolute)) {
            $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
            $hostName = $_SERVER['HTTP_HOST']; 
            $currentPath = $_SERVER['PHP_SELF']; 
            $pathInfo = pathinfo($currentPath); 
            return $protocol.'://'.$hostName. '/wp-content/plugins' . self::PLUGIN_DIR_NAME ;
        }

        $path = explode(self::PLUGIN_DIR_NAME  , __FILE__);
        return  $path[0] . self::PLUGIN_DIR_NAME;
    }
}
