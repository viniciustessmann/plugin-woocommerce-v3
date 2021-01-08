<?php

namespace V3\Services;

use V3\Controllers\AuthController;

class RouterService
{
    public static function init()
    {
        $authController = new AuthController();

        add_action('wp_ajax_get_code', [$authController, 'getCode']);
    }
}
