<?php

namespace V3\Services;


class RequestService
{
    const URL = 'https://api.melhorenvio.com/v2/me';

    const TIMEOUT = 600;

    protected $headers;

    private $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjExYTA2YTQyODA4NDk0N2IwNjVlZjdiOWI2OWJmYjNhODNkY2RkZWJmNzlkMTIzYzMwOGExOWJhYTMyODg5MjFiMDA2ZjIxOTg3NjRlMTEzIn0.eyJhdWQiOiIxIiwianRpIjoiMTFhMDZhNDI4MDg0OTQ3YjA2NWVmN2I5YjY5YmZiM2E4M2RjZGRlYmY3OWQxMjNjMzA4YTE5YmFhMzI4ODkyMWIwMDZmMjE5ODc2NGUxMTMiLCJpYXQiOjE2MTAxMzAyOTMsIm5iZiI6MTYxMDEzMDI5MywiZXhwIjoxNjQxNjY2MjkzLCJzdWIiOiI1MGNiZDViNi01OGY5LTQ5ODQtOTU0ZC1kY2E3MDg3MTc4MGMiLCJzY29wZXMiOlsiY2FydC1yZWFkIiwiY2FydC13cml0ZSIsImNvbXBhbmllcy1yZWFkIiwiY29tcGFuaWVzLXdyaXRlIiwiY291cG9ucy1yZWFkIiwiY291cG9ucy13cml0ZSIsIm5vdGlmaWNhdGlvbnMtcmVhZCIsIm9yZGVycy1yZWFkIiwicHJvZHVjdHMtcmVhZCIsInByb2R1Y3RzLWRlc3Ryb3kiLCJwcm9kdWN0cy13cml0ZSIsInB1cmNoYXNlcy1yZWFkIiwic2hpcHBpbmctY2FsY3VsYXRlIiwic2hpcHBpbmctY2FuY2VsIiwic2hpcHBpbmctY2hlY2tvdXQiLCJzaGlwcGluZy1jb21wYW5pZXMiLCJzaGlwcGluZy1nZW5lcmF0ZSIsInNoaXBwaW5nLXByZXZpZXciLCJzaGlwcGluZy1wcmludCIsInNoaXBwaW5nLXNoYXJlIiwic2hpcHBpbmctdHJhY2tpbmciLCJlY29tbWVyY2Utc2hpcHBpbmciLCJ0cmFuc2FjdGlvbnMtcmVhZCIsInVzZXJzLXJlYWQiLCJ1c2Vycy13cml0ZSIsIndlYmhvb2tzLXJlYWQiLCJ3ZWJob29rcy13cml0ZSJdfQ.YVLehA-8iuZJPk04mZTJyXX1kqzYRC7yFCP3AcPwLz7RkZxfRTLenuwxsI8e7YNKWjBPxTE5CJT3bneCOZyip3z1oELLn53IEJmP78hjUegkPqnvCR2XFxKI8mQIV1HXbYjwkZ4v79xrhaCcjpcwXeUEfoLIyUHZlWgKmejjui5hW0MJHD4QV18IN7wQw1WIY8jrIg_IrA7SoIXnBhi-uW-xNfiqoH1skA7zsXq83uLVtte50ljr3qi0KQdaKAc__DL_l0MzsUokQtN5W0qEWv9TLBMlg5YxZ7ehV8-z9ElD1bYMM1bPW_LxhuQlkAZY6k2ZC7RmjkqpCF44WdINVh2CCDh-y23ZeqSP23AYRBmOWA8DoEu_Fa6LW6GVT_bmJ68yStssK-bKOFuA24MIE8ydTcD5RsgvHMysfZRsWzO3Op0XbRbsDYY0r8CaS3A87a4V4TLMtLGoWUiOz0ftKPg0ScHFMvL8A_8jql6-xW9746fz6g6N9Ny2FKJnLQCbgPYONXbbP4atSn3YEFgkr1zX-FgCFKcADg1e5RGVYHMT_gLjrS6U27yDMPW_c85Dkp-dsuSnj3QJsLXCI5rfWeQN11RJP95cHL9ztBtviVp_Wc_xyIiM2pFRqhA9148zaSLjuQANGlYDmANnG4Zu341lUYf_IIv4zZc7885DwQQ';


    public function __construct()
    {
        $this->headers = array(
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
        );
    }

    /**
     * Function to make a request to API Melhor Envio.
     *
     * @param string $route
     * @param string $typeRequest
     * @param object $body
     * @return object $response
     */
    public function request($route, $typeRequest, $body)
    {
        $params = array(
            'headers' => $this->headers,
            'method'  => $typeRequest,
            'body'    => json_encode($body),
            'timeout ' => self::TIMEOUT
        );

        /**if ($route == '/cart') {
            echo '<pre>';
            var_dump(wp_remote_retrieve_body(
                wp_remote_post(self::URL . $route, $params)
            ));
            die;
        }*/

        return json_decode(
            wp_remote_retrieve_body(
                wp_remote_post(self::URL . $route, $params)
            )
        );
    }

}
