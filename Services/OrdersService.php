<?php

namespace Tessmann\Services;

use Tessmann\Models\Order;
use Tessmann\Models\ShippingMethod;

class OrdersService
{
    const PLATAFORM = 'Tessmann shipping V1';

    const ROUTE_MELHOR_ENVIO_ADD_CART = '/cart';

    const ROUTE_MELHOR_ENVIO_DETAIL_ORDER = '/orders/';

    /**
     * @param $post_id
     * @return false|object
     */
    public function addCart($post_id)
    {
        $order = wc_get_order($post_id);

        $products = (new OrderProductsService())->getProductByOrder($order);

        $seller = (new SellerDataService())->get();

        $buyer = (new BuyerService())->getBuyerByOrder($order);

        $methodTitle = end($order->get_items( 'shipping' ))->get_name();

        $method_selected = (new ShippingMethod())
            ->getCode($methodTitle);

        $quotations = (new CalculateService([], [$method_selected]))
            ->calculateByProducts($products, $buyer->postal_code);
        
        if (!empty($quotations['id']) && $quotations['id'] == $method_selected) {
            $quotation = $quotations;
            $quotations = [];
            $quotations[$method_selected] = $quotation;
        }

        if(is_array($quotations) && empty($quotations[$method_selected]['packages'])) {
            return (object) [
                'error' => true,
                'message' => 'Não foi possível obter a cotação do Melhor Envio, tente novamente mais tarde'
            ];
        }

        $total = $order->get_subtotal();

        $agency_id = null;

        $company_shipping = ShippingMethod::howCompanyByMethod($method_selected);

        if ($company_shipping == ShippingMethod::COMPANY_JADLOG) {
            $agency_id = $seller->agency_jadlog;
        }

        if ($company_shipping == ShippingMethod::COMPANY_LATAM_CARGO) {
            $agency_id = $seller->agency_latam;
        }

        $body = array(
            'from' => $seller,
            'to' => $buyer,
            'agency' => $agency_id,
            'service' => $method_selected,
            'products' => $products,
            'volumes' => $quotations[$method_selected]['packages'],
            'options' => array(
                "insurance_value" => ($total <= 1000) ? $total : floatval(1000),
                "receipt" => false,
                "own_hand" => false,
                "collect" => false,
                "non_commercial" => true,
                'platform' => self::PLATAFORM
            )
        );

        if (in_array($company_shipping, [ShippingMethod::COMPANY_JADLOG, ShippingMethod::COMPANY_LATAM_CARGO]) && empty($body['agency'])) {
            return (object) [
               'error' => true,
               'message' => 'você precisa infomrmr a agência Jadlog nas configurações do plugin'
            ];
        }


        $data = (new RequestService())->request(
            Self::ROUTE_MELHOR_ENVIO_ADD_CART,
            'POST',
            $body
        );

        if (!empty($data->error)) {
            return (object) [
                'error' => true,
                'message' => $data->error
            ];
        }

        if(empty($data->id)) {
            return (object) [
                'error' => true,
                'message' => 'Ocorreu um erro ao enviar o pedido para o carrinho de compras'
            ];
        }

        $orderEntity = (new Order($post_id));
        $orderEntity->setOrderId($data->id);
        $orderEntity->setProtocol($data->protocol);

        return $data;
    }

    /**
     * @param $order_id
     * @return object
     */
    public function get($post_id, $order_id)
    {
        $data =  (new RequestService())->request(
            Self::ROUTE_MELHOR_ENVIO_DETAIL_ORDER . $order_id,
            'GET',
            []
        );

        if(isset($data->error) && $data->error == "Not Found") {
            return (new Order($post_id))->destroy();
        }

        return $data;
    }

}
