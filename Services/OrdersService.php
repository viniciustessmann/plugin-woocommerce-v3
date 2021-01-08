<?php

namespace V3\Services;

use V3\Models\Order;

class OrdersService
{
    const PLATAFORM = 'Tessmann shipping V1';

    const ROUTE_MELHOR_ENVIO_ADD_CART = '/cart';

    /**
     * @param $post_id
     * @return false|mixed
     */
    public function addCart($post_id)
    {
        //todo: remover.
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjExYTA2YTQyODA4NDk0N2IwNjVlZjdiOWI2OWJmYjNhODNkY2RkZWJmNzlkMTIzYzMwOGExOWJhYTMyODg5MjFiMDA2ZjIxOTg3NjRlMTEzIn0.eyJhdWQiOiIxIiwianRpIjoiMTFhMDZhNDI4MDg0OTQ3YjA2NWVmN2I5YjY5YmZiM2E4M2RjZGRlYmY3OWQxMjNjMzA4YTE5YmFhMzI4ODkyMWIwMDZmMjE5ODc2NGUxMTMiLCJpYXQiOjE2MTAxMzAyOTMsIm5iZiI6MTYxMDEzMDI5MywiZXhwIjoxNjQxNjY2MjkzLCJzdWIiOiI1MGNiZDViNi01OGY5LTQ5ODQtOTU0ZC1kY2E3MDg3MTc4MGMiLCJzY29wZXMiOlsiY2FydC1yZWFkIiwiY2FydC13cml0ZSIsImNvbXBhbmllcy1yZWFkIiwiY29tcGFuaWVzLXdyaXRlIiwiY291cG9ucy1yZWFkIiwiY291cG9ucy13cml0ZSIsIm5vdGlmaWNhdGlvbnMtcmVhZCIsIm9yZGVycy1yZWFkIiwicHJvZHVjdHMtcmVhZCIsInByb2R1Y3RzLWRlc3Ryb3kiLCJwcm9kdWN0cy13cml0ZSIsInB1cmNoYXNlcy1yZWFkIiwic2hpcHBpbmctY2FsY3VsYXRlIiwic2hpcHBpbmctY2FuY2VsIiwic2hpcHBpbmctY2hlY2tvdXQiLCJzaGlwcGluZy1jb21wYW5pZXMiLCJzaGlwcGluZy1nZW5lcmF0ZSIsInNoaXBwaW5nLXByZXZpZXciLCJzaGlwcGluZy1wcmludCIsInNoaXBwaW5nLXNoYXJlIiwic2hpcHBpbmctdHJhY2tpbmciLCJlY29tbWVyY2Utc2hpcHBpbmciLCJ0cmFuc2FjdGlvbnMtcmVhZCIsInVzZXJzLXJlYWQiLCJ1c2Vycy13cml0ZSIsIndlYmhvb2tzLXJlYWQiLCJ3ZWJob29rcy13cml0ZSJdfQ.YVLehA-8iuZJPk04mZTJyXX1kqzYRC7yFCP3AcPwLz7RkZxfRTLenuwxsI8e7YNKWjBPxTE5CJT3bneCOZyip3z1oELLn53IEJmP78hjUegkPqnvCR2XFxKI8mQIV1HXbYjwkZ4v79xrhaCcjpcwXeUEfoLIyUHZlWgKmejjui5hW0MJHD4QV18IN7wQw1WIY8jrIg_IrA7SoIXnBhi-uW-xNfiqoH1skA7zsXq83uLVtte50ljr3qi0KQdaKAc__DL_l0MzsUokQtN5W0qEWv9TLBMlg5YxZ7ehV8-z9ElD1bYMM1bPW_LxhuQlkAZY6k2ZC7RmjkqpCF44WdINVh2CCDh-y23ZeqSP23AYRBmOWA8DoEu_Fa6LW6GVT_bmJ68yStssK-bKOFuA24MIE8ydTcD5RsgvHMysfZRsWzO3Op0XbRbsDYY0r8CaS3A87a4V4TLMtLGoWUiOz0ftKPg0ScHFMvL8A_8jql6-xW9746fz6g6N9Ny2FKJnLQCbgPYONXbbP4atSn3YEFgkr1zX-FgCFKcADg1e5RGVYHMT_gLjrS6U27yDMPW_c85Dkp-dsuSnj3QJsLXCI5rfWeQN11RJP95cHL9ztBtviVp_Wc_xyIiM2pFRqhA9148zaSLjuQANGlYDmANnG4Zu341lUYf_IIv4zZc7885DwQQ';

        $order = wc_get_order($post_id);

        $products = (new OrderProductsService())->getProductByOrder($order);

        //todo: fazer todos esses campos abaixo.
        $body = array(
            'from' => [
                "name" =>"Nome do remetente",
                "phone" =>"53984470102",
                "email" => "contato@melhorenvio.com.br",
                "document" => "02243682060",
                "address" => "Endereço do remetente",
                "complement" => "Complemento",
                "number" => "1",
                "district" => "Bairro",
                "city" => "São Paulo",
                "country_id" => "BR",
                "postal_code" => "01002001"
            ],
            'to' => [
                "name" =>"Nome do remetente",
                "phone" =>"53984470102",
                "email" => "contato@melhorenvio.com.br",
                "document" => "16571478358",
                "address" => "Endereço do remetente",
                "complement" => "Complemento",
                "number" => "1",
                "district" => "Bairro",
                "city" => "São Paulo",
                "country_id" => "BR",
                "postal_code" => "96020360"
            ],
            //'agency' => $this->getAgencyToInsertCart($shippingMethodId),
            'service' => 2,
            'products' => $products,
            //'volumes' => $this->getVolumes($quotation, $shippingMethodId),
            'options' => array(
                "insurance_value" => $order->get_subtotal(),
                "receipt" => false,
                "own_hand" => false,
                "collect" => false,
                "reverse" => false,
                "non_commercial" => true,
                'platform' => self::PLATAFORM
            )
        );

        $data = (new RequestService($token))->request(
            Self::ROUTE_MELHOR_ENVIO_ADD_CART,
            'POST',
            $body
        );

        $data->order_id = rand(10000,300000); //todo: remover após os testes;

        if(empty($data->order_id)) {
            return false;
        }

        return (new Order($post_id))->setOrderId($data->order_id);
    }
}
