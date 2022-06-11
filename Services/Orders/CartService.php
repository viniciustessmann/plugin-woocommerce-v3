<?php

namespace Tessmann\Services\Orders;

use Tessmann\Models\Order;
use Tessmann\Models\ShippingMethod;
use Tessmann\Services\OrderProductsService;
use Tessmann\Services\SellerDataService;
use Tessmann\Services\BuyerService;
use Tessmann\Services\CalculateService;
use Tessmann\Services\RequestService;
use Tessmann\Services\Orders\GetDataService;

class CartService
{
    const PLATAFORM = 'Tessmann shipping V1';

    const ROUTE_MELHOR_ENVIO_ADD_CART = '/cart';

    /**
     * @param $post_id
     * @return false|object
     */
    public function add($post_id)
    {
        $order = wc_get_order($post_id);

        $products = (new OrderProductsService())->getProductByOrder($order);

        $seller = (new SellerDataService())->get();

        $buyer = (new BuyerService())->getBuyerByOrder($order);

        $items_shipping = $order->get_items( 'shipping' );

        $methodTitle = end($items_shipping)->get_name();

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
                'receipt' => ($seller->receipt == 'yes') ? true : false,
                'own_hand' => ($seller->own_hand == 'yes') ? true : false,
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

    public function remove($post_id)
    {
        $order = new Order($post_id);

        $order_id = $order->getOrderId();

        if (!$order_id) {
            return false;
        }

        $detail = (new GetDataService())->get($post_id);

        if (!isset($detail->id)) {
            return false;
        }

        $response =  (new RequestService())->request(self::ROUTE_MELHOR_ENVIO_ADD_CART . '/' . $detail->id, 'DELETE', []);

        if (!empty($response)) {
            return false;
        }

        $order->destroy();

        return true;
    }
}
