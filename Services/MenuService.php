<?php

namespace Tessmann\Services;

class MenuService
{
    /**
     * Function to create menu melhor envio in sidebar
     *
     * @param string $path
     * @return void
     */
    public static function create($path)
    {
        if (is_admin()) {
            add_action('admin_menu', function () use ($path) {
                add_menu_page(
                    'Melhor Envio Tessmann',
                    'Melhor Envio Tessmann',
                    'manage_options',
                    $path . 'admin/view.php',
                    null,
                    'dashicons-thumbs-up',
                    3
                );
            });
        }
    }
}
