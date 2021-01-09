<?php

namespace V3\Services;

use V3\Helpers\NoticeHelper;

class HealthService
{
    const PLUGIN_CHECKOUT_NEED = 'woocommerce-extra-checkout-fields-for-brazil/woocommerce-extra-checkout-fields-for-brazil.php';

    /**
     * @return bool
     */
    public static function check()
    {
        $instaled = apply_filters(
            'network_admin_active_plugins',
            get_option('active_plugins')
        );

        if (!in_array( self::PLUGIN_CHECKOUT_NEED, $instaled)) {
            $notice = 'É necessário o plugin <a href="https://wordpress.org/plugins/woocommerce-extra-checkout-fields-for-brazil/">Brazilian Market on WooCommerce</a> para o funcionamente correto do plugin.';
            NoticeHelper::addNotice($notice, 'notice-error');
        }

        $sellerService = new SellerDataService();
        add_action('woocommerce_init', function() use ($sellerService){
            $seller = $sellerService->get();

            foreach($seller as $field => $value) {

                if ($field == 'complement') {
                    continue;
                }

                if (empty($value)) {
                    $linkConfigurations = '/wp-admin/admin.php?page=wc-settings&tab=shipping&section=tessmann-shipping';
                    $notice = sprintf("Você precisa definir o campo '%s' nas <a href='%s'>configurações</a> do plugin Tessmann Cotação para o funcionamento correto. ", $field, $linkConfigurations);
                    NoticeHelper::addNotice($notice, 'error-notice');
                }

            }
        });
    }
}