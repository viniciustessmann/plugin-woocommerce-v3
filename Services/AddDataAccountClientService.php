<?php

namespace Tessmann\Services;

use Tessmann\Helpers\FormatDataHelper;
use Tessmann\Services\Orders\GetDataService;

class AddDataAccountClientService
{

    public static function createColumn($columns)
    {
        $columns['tracking_column'] = "Rastreio";
        unset($columns['order-actions']);
        $columns['order-actions'] = __('Ações');
        return $columns;
    }

    public static function insertDataColumn($order)
    {
       
        $getDataService = new GetDataService();

        $data = $getDataService->get($order->get_id());

        if (empty($data->status) || $data->status == 'pending') {
            echo '<p style="font-size:10px;">Aguardando envio</p>';
        }

        if (!empty($data->tracking)) {
            echo '<p style="font-size:10px;"><b>Rastreio:</b> </br><a target="_blank" href="https://melhorrastreio.com.br/rastreio/' . $data->tracking . '">' . $data->tracking . '</a></p>';
        }     
    }
}
