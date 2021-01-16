<?php

namespace Tessmann\Services;

/**
 * Class ColumnsListOrdersService
 * @package Tessmann\Services
 */
class ColumnsListOrdersService
{
    /**
     *
     */
    public static function insertColumnCart()
    {
        add_filter( 'manage_edit-shop_order_columns', function($columns) {
            $reordered_columns = array();
            foreach( $columns as $key => $column){
                $reordered_columns[$key] = $column;
                if( $key ==  'order_status' ){
                    $reordered_columns['actions-me'] = 'Ações Melhor Envio';
                }
            }
            return $reordered_columns;
        }, 20 );
    }
}
