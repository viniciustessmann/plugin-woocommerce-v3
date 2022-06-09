<?php

namespace Tessmann\Services;

use Tessmann\Helpers\LoaderComponentHelper;
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
                    echo '<p><button  class="add-cart-me button refund-items" data-id="' . $post->ID . '">Adicionar</button></p>';
                    LoaderComponentHelper::add('add-cart-me', $post->ID, 50);
                    echo '<div class="receive-protocol-'. $post->ID .' "></div>';

                } else {

                    $protocol = $order->getProtocol();

                    print_r($urlPrint);

                    if (!empty($protocol)) {
                        echo '<p>Protocolo: <b>' . $protocol . '</b></p>';
                        echo '<hr>';
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
            self::getPathImageCompany($detail);
            echo '<p>Serviço: <b>' .$detail->service->name .'</b></p>';
            echo '<hr>';
        }
    }

    public static function getPathImageCompany($detail)
    {
        $company = str_replace(' ', '_', strtolower($detail->service->company->name));
        $imageService = plugin_dir_url( dirname( __FILE__ ) ) . 'src/img/' . $company . '.png';
        echo '<img style="width:100px;" src="' . $imageService . '">';
    }

    public static function showStatus($detail)
    {
        if (is_object($detail) && !empty($detail->status)) {
            echo '<p>Status: <b>' .$detail->status . '</b></p>';
            echo '<hr>';
        }
    }

    public static function showVolumes($detail)
    {
        if (is_object($detail) && isset($detail->volumes)) {
            echo '<p><b>Volumes:</b></p>';
            foreach ($detail->volumes as $key => $volume) {
                echo sprintf("<p>%scm x A %scm x C %scm - %sKg</p>", $volume->width,  $volume->height,  $volume->length,  $volume->weight);
            }
            echo '<hr>';
        }
    }

    public static function showTracking($detail)
    {
        if (is_object($detail) && !empty($detail->tracking)) {
            $tracking =$detail->tracking;
            echo 'Rastreio: <a target="_blank" href="https://www.melhorrastreio.com.br/rastreio/' . $tracking . '">' . $tracking . '</a>';
            echo '<hr>';
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
            echo '<p><button class="print-ticket-me button refund-items" data-id="' . $post_id . '">Imprimir</button></p>';
            echo '<hr>';
        }
    }

    public static function removeCart($detail, $post_id)
    {
        if (isset($detail->status) && $detail->status === 'pending') {
            echo '<p><button class="remove-cart-me button refund-items" data-id="' . $post_id . '">Remover do carrinho</button></p>';
            LoaderComponentHelper::add('remove-cart-me', $post_id, 50);
        }
    }

}