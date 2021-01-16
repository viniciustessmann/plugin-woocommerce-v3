<?php

namespace V3\Services;

use V3\Models\Order;

class BoxMetaService
{
    public static function add()
    {
        add_action( 'add_meta_boxes', function() {
            add_meta_box( 'melhor-envio-box-id', 'Tessmann Envio', function() {
                global $post;
                $order = new Order($post->ID);

                if(empty($order->getOrderId())) {
                    echo '<p>Pedido não encontrado no Melhor Envio, você precisa enviar o pedido para o carrinho do Melhor Envio</p>';
                } else {

                    $protocol = $order->getProtocol();
                    if (!empty($protocol)) {
                        echo '<p>Protocolo: <b>' . $protocol . '</b></p>';
                    }

                    $order_id = $order->getOrderId();
                    if (!empty($order_id)) {
                        $detail = (new OrdersService())->get($order_id);

                        if (!empty(end($detail)->status)) {
                            echo '<p>Status: <b>' . end($detail)->status . '</b></p>';
                        }

                        if (!empty(end($detail)->tracking)) {
                            $tracking = end($detail)->tracking;
                            echo 'Rastreio: <a target="_blank" href="https://www.melhorrastreio.com.br/rastreio/' . $tracking . '">' . $tracking . '</a>';
                        }
                    }
                }

                $imagePicPay = plugin_dir_url( dirname( __FILE__ ) ) . 'src/img/picpay.jpeg';
                echo '<p>Gostou do plugin? Me pague um café ;)</p>';
                echo '<img style="width:80%; margin-left:10%;" src="'. $imagePicPay .'" />';


            }, 'shop_order', 'side', 'high' );
        });
    }

}