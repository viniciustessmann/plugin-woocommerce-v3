<?php

namespace Tessmann\Services;

use Tessmann\Models\Order;

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
                    echo '<p><button  class="add-cart-me" data-id="' . $post->ID . '">Adicionar</button></p>';
                    echo '<div class="receive-protocol-'. $post->ID .' "></div>';

                } else {

                    $protocol = $order->getProtocol();

                    print_r($urlPrint);

                    if (!empty($protocol)) {
                        echo '<p>Protocolo: <b>' . $protocol . '</b></p>';
                    }

                    $order_id = $order->getOrderId();

                    if (!empty($order_id)) {

                        $detail = (new OrdersService())->get($post->ID, $order_id);

                        self::showServiceName($detail);

                        self::showVolumes($detail);

                        self::showStatus($detail);

                        self::showTracking($detail);

                        self::removeCart($detail, $post->ID);

                        self::showButtonPrint($detail, $post->ID);
                    }
                }

                $imagePicPay = plugin_dir_url( dirname( __FILE__ ) ) . 'src/img/picpay.jpeg';
                echo '<p>Gostou do plugin? Me pague um café ;)</p>';
                echo '<img style="width:80%; margin-left:10%;" src="'. $imagePicPay .'" />';


            }, 'shop_order', 'side', 'high' );
        });
    }

    public static function showServiceName($detail)
    {
        if (is_object($detail) && $detail->service) {
            echo '<p>Serviço: <b>' .$detail->service->name . ' (' .$detail->service->company->name . ')</b></p>';
        }
    }

    public static function showStatus($detail)
    {
        if (is_object($detail) && !empty($detail->status)) {
            echo '<p>Status: <b>' .$detail->status . '</b></p>';
        }
    }

    public static function showVolumes($detail)
    {
        if (is_object($detail) && isset($detail->volumes)) {
            echo '<p><b>Volumes:</b></p>';
            foreach ($detail->volumes as $volume) {
                echo '<p><b>Largura:</b>' . $volume->width . 'cm</p>';
                echo '<p><b>Altura:</b>' . $volume->height . 'cm</p>';
                echo '<p><b>Comprimento:</b>' . $volume->length . 'cm</p>';
                echo '<p><b>Peso:</b>' . $volume->weight . 'kg</p>';
            }
        }
    }

    public static function showTracking($detail)
    {
        if (is_object($detail) && !empty($detail->tracking)) {
            $tracking =$detail->tracking;
            echo 'Rastreio: <a target="_blank" href="https://www.melhorrastreio.com.br/rastreio/' . $tracking . '">' . $tracking . '</a>';
        }
    }

    public static function showButtonPrint($detail, $post_id)
    {
        if (!is_object($detail)) {
            return false;
        }

        if (!isset($detail->status)) {
            return false;
        }

        $status = $detail->status;
        
        if (in_array($status, ['released'])) {
            echo '<p><button class="print-ticket-me" data-id="' . $post_id . '">Imprimir</button></p>';
        }
    }

    public static function removeCart($detail, $post_id)
    {
        if (isset($detail->status) && $detail->status === 'pending') {
            echo '<p><button  class="remove-cart-me" data-id="' . $post_id . '">Remover do carrinho</button></p>';
        }
    }

}