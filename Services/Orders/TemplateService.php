<?php

namespace Tessmann\Services\Orders;

use Tessmann\Helpers\LoaderComponentHelper;
use Tessmann\Models\Order;
use Tessmann\Services\Orders\GetDataService;

class TemplateService
{
    public static function get($post)
    {
        $order = new Order($post->ID);

        $detail = (new GetDataService())->get($post->ID);

        $html = '';

        $html .= '<div class="receive-template-order">';

        if (empty($order->getOrderId())) {
            $html .= '<p>Pedido não encontrado no Melhor Envio, você precisa enviar o pedido para o carrinho do Melhor Envio</p>';
            $html .= '<p><button  class="add-cart-me button refund-items" data-id="' . $post->ID . '">Adicionar</button></p>';
            $html .= LoaderComponentHelper::add('add-cart-me', $post->ID, 50);
            $html .= '<div class="receive-protocol-'. $post->ID .' "></div>';
            $html .= '</div>';
            return $html;

        } 

        $protocol = $order->getProtocol();

        if (!empty($protocol)) {
            $html .= '<p>Protocolo: <b>' . $protocol . '</b></p>';
            $html .= '<hr>';
        }

        $order_id = $order->getOrderId();

        if (!empty($order_id)) {

            $html .= self::showServiceName($detail);

            $html .= self::showVolumes($detail);
            
            $html .= self::showOptionals($detail);

            $html .= self::showDeliveryTime($detail);

            $html .= self::showStatus($detail);

            $html .= self::showTracking($detail);

            $html .= self::removeCart($detail, $post->ID);

            $html .= self::showButtonPrint($detail, $post->ID);
        }

        $imagePicPay = plugin_dir_url( dirname( __FILE__ ) ) . '../src/img/picpay.jpeg';
        $html .= '<p>Gostou do plugin? Me pague um café ;)</p>';
        $html .= '<img style="width:80%; margin-left:10%;" src="'. $imagePicPay .'" />';

        $html .= '</div>';

        return $html;

    }

    public static function showServiceName($detail)
    {
        $html = '';
        if (is_object($detail) && $detail->service) {
            $html .= self::getPathImageCompany($detail);
            $html .= '<p>Serviço: <b>' .$detail->service->name .'</b></p>';
            $html .= '<hr>';
        }

        return $html;
    }

    public static function getPathImageCompany($detail)
    {
        $html = '';
        $company = str_replace(' ', '_', strtolower($detail->service->company->name));
        $imageService = plugin_dir_url( dirname( __FILE__ ) ) . '../src/img/' . $company . '.png';
        $html .= '<img style="width:100px;" src="' . $imageService . '">';
        return $html;
    }

    public static function showStatus($detail)
    {
        $html = '';
        if (is_object($detail) && !empty($detail->status)) {
            $html .= '<p>Status: <b>' .$detail->status . '</b></p>';
            $html .= '<hr>';
        }
        return $html;
    }

    public static function showVolumes($detail)
    {
        $html = '';
        if (is_object($detail) && isset($detail->volumes)) {
            $html .= '<p><b>Volumes:</b></p>';
            foreach ($detail->volumes as $key => $volume) {
                $html .= sprintf("<p>%scm x A %scm x C %scm - %sKg</p>", $volume->width,  $volume->height,  $volume->length,  $volume->weight);
            }
            $html .= '<hr>';
        }
        return $html;
    }

    public static function showOptionals($detail)
    {
        $html = '';
        if (is_object($detail)) {
            $html .= '<p><b>Opcionais:</b></p>';

            $receipt = ($detail->receipt) ? 'sim' : 'não' ;
            $own_hand = ($detail->own_hand) ? 'sim' : 'não' ;

            $html .= '<p><b>Aviso de recebimento:</b> ' . $receipt . '</p>';
            $html .= '<p><b>Mãos própria:</b> ' . $own_hand . '</p>';
            $html .= '<hr>';
        }

        return $html;
    }

    public static function showDeliveryTime($detail)
    {
        $html = '';
        if (!empty($detail->delivery_min) && !empty($detail->delivery_max)) {

            $min = ($detail->delivery_min > 1) ? $detail->delivery_min . ' dias' : $detail->delivery_min . ' dia';

            $max = ($detail->delivery_max > 1) ? $detail->delivery_max . ' dias' : $detail->delivery_max . ' dia';

            if ($min == $max) {
                $delivery = $min;
            }

            if ($max > $min) {
                $delivery = sprintf('Entre %s e %s', $min, $max);
            }

            $html .= '<p><b>Prazo de entrega:</b> ' . $delivery . '</p>';
            $html .= '<hr>';
        }

        return $html;
    }

    public static function showTracking($detail)
    {
        $html = '';
        if (is_object($detail) && !empty($detail->tracking)) {
            $tracking =$detail->tracking;
            $html .= 'Rastreio: <a target="_blank" href="https://www.melhorrastreio.com.br/rastreio/' . $tracking . '">' . $tracking . '</a>';
            $html .= '<hr>';
        }
        return $html;
    }

    public static function showButtonPrint($detail, $post_id)
    {
        $html = '';
        if (!is_object($detail)) {
            return $html;
        }

        if (!isset($detail->status)) {
            return $html;
        }

        $status = $detail->status;
        
        if (in_array($status, ['released'])) {
            $html .= '<p><button class="print-ticket-me button refund-items" data-id="' . $post_id . '">Imprimir</button></p>';
            $html .= '<hr>';
        }

        return $html;
    }

    public static function removeCart($detail, $post_id)
    {
        $html = '';
        if (isset($detail->status) && $detail->status === 'pending') {
            $html .= '<p><button class="remove-cart-me button refund-items" data-id="' . $post_id . '">Remover do carrinho</button></p>';
            $html .= LoaderComponentHelper::add('remove-cart-me', $post_id, 50);
        }
        return $html;
    }
}
