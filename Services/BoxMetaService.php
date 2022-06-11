<?php

namespace Tessmann\Services;

use Tessmann\Services\Orders\TemplateService;

class BoxMetaService
{
    public static function add()
    {
        add_action( 'add_meta_boxes', function() {

            add_meta_box( 'melhor-envio-box-id', 'Tessmann Envio', function() {

                global $post;

                echo TemplateService::get($post);

            }, 'shop_order', 'side', 'high' );
        });
    }
}