<?php

namespace Tessmann\Models;

/**
 * Class Order
 * @package Tessmann\Models
 */
class Order
{
    /**
     * key post meta to save order id by Melhor Envio.
     */
    const POST_META_ORDER_ID_MELHOR_ENVIO = 'order_id_melhor_envio';

    const POST_META_ORDER_PROTOCOL_MELHOR_ENVIO = 'protocol_melhor_envio';

    const POST_META_ORDER_URL_PRINT_MELHOR_ENVIO = 'url_print_melhor_envio';

    protected $post_id;

    public function __construct($post_id)
    {
        $this->post_id = $post_id;
    }

    /**
     * @param $orderId
     * @return false|mixed
     */
    public function setOrderId($orderId)
    {
        delete_post_meta($this->post_id, self::POST_META_ORDER_ID_MELHOR_ENVIO);
        return (add_post_meta($this->post_id, self::POST_META_ORDER_ID_MELHOR_ENVIO, $orderId, true))
            ? $orderId
            : false;
    }

    /**
     * @param $protocol
     * @return false|mixed
     */
    public function setProtocol($protocol)
    {
        delete_post_meta($this->post_id, self::POST_META_ORDER_PROTOCOL_MELHOR_ENVIO);
        return (add_post_meta($this->post_id, self::POST_META_ORDER_PROTOCOL_MELHOR_ENVIO, $protocol, true))
            ? $protocol
            : false;
    }

    /**
     * @param $url
     * @return false|mixed
     */
    public function setUrlPrint($url)
    {
        delete_post_meta($this->post_id, self::POST_META_ORDER_URL_PRINT_MELHOR_ENVIO);
        return (add_post_meta($this->post_id, self::POST_META_ORDER_URL_PRINT_MELHOR_ENVIO, $url, true))
            ? $url
            : false;
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return get_post_meta($this->post_id, self::POST_META_ORDER_ID_MELHOR_ENVIO, true);
    }

    /**
     * @return mixed
     */
    public function getProtocol()
    {
        return get_post_meta($this->post_id, self::POST_META_ORDER_PROTOCOL_MELHOR_ENVIO, true);
    }

    /**
     * @return mixed
     */
    public function getUrlPrint()
    {
        return get_post_meta($this->post_id, self::POST_META_ORDER_URL_PRINT_MELHOR_ENVIO, true);
    }

    /**
     * @return mixed
     */
    public function destroy()
    {
        delete_post_meta($this->post_id, self::POST_META_ORDER_ID_MELHOR_ENVIO);
        delete_post_meta($this->post_id, self::POST_META_ORDER_PROTOCOL_MELHOR_ENVIO);
        delete_post_meta($this->post_id, self::POST_META_ORDER_URL_PRINT_MELHOR_ENVIO);

        return true;
    }

}