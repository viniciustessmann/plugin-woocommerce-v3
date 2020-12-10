<?php

use V3\Services\CalculateService;

if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {

    function melhorenvio_shipping_method()
    {
        if (!class_exists('melhorenvio_shipping_method')) {

            class MelhorEnvio_Shipping_Method extends WC_Shipping_Method
            {
                /**
                 * Constructor for your shipping class
                 *
                 * @access public
                 * @return void
                 */
                public function __construct()
                {
                    $this->id                 = 'melhorenvio-v3';
                    $this->method_title       = 'Melhor Envio';
                    $this->method_description = 'Métodos de entregas do Melhor Envio';

                    $this->init();

                    $this->enabled = isset($this->settings['enabled']) ? $this->settings['enabled'] : 'yes';
                    $this->title = isset($this->settings['title']) ? $this->settings['title'] : 'Melhor Envio';
                }

                /**
                 * Init your settings
                 *
                 * @access public
                 * @return void
                 */
                function init()
                {
                    $this->init_form_fields();
                    $this->init_settings();
                    add_action('woocommerce_update_options_shipping_' . $this->id, array($this, 'process_admin_options'));
                }

                /**
                 * Define settings field for this shipping
                 * @return void 
                 */
                function init_form_fields()
                {
                    $this->form_fields = array(
                        'enabled' => array(
                            'title' => 'Ativo',
                            'type' => 'checkbox',
                            'description' => 'Ativar esse serviço',
                            'default' => 'yes'
                        ),
                        'title' => array(
                            'title' => 'título',
                            'type' => 'text',
                            'description' => 'Nome de exibição',
                            'default' => 'Melhor Envio'
                        ),

                    );
                }

                /**
                 * This function is used to calculate the shipping cost.
                 * Within this function we can check for weights, dimensions and other parameters.
                 *
                 * @access public
                 * @param mixed $package
                 * @return void
                 */
                public function calculate_shipping($package = array())
                {

                    $rates = (new CalculateService())->calculate($package);

                    foreach ($rates as $rate) {
                        $this->add_rate($rate);
                    }
                }
            }
        }
    }

    add_action('woocommerce_shipping_init', 'melhorenvio_shipping_method');

    function add_melhorenvio_shipping_method($methods)
    {
        $methods['melhor-envio-v3'] = 'MelhorEnvio_Shipping_Method';
        return $methods;
    }

    add_filter('woocommerce_shipping_methods', 'add_melhorenvio_shipping_method');
}
