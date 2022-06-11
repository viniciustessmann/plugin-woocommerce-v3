<?php

namespace Tessmann\Controllers;

use Tessmann\Services\Orders\TemplateService;

class OrderTemplateController
{
    public function get()
    {
        try {

            $post = get_post(sanitize_text_field($_POST['post_id']));

            $template = (new TemplateService)->get($post);

            return wp_send_json(['template' => $template], 200);


        } catch (\Exception $exception) {
             return wp_send_json([
                 'success' => false,
                 'message' => 'Ocorreu um erro ao obter as informacões do pedido'
             ], 500);
        }
    }
}
