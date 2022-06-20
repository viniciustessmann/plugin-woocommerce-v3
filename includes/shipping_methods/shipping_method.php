<?php

use Tessmann\Services\CalculateService;
use Tessmann\Helpers\NormalizePostalCodeHelper;
use Tessmann\Services\RequestService;
use Tessmann\Services\AgenciesService;
use Tessmann\Models\Token;

if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {

    function melhorenvio_shipping_method()
    {
        if (!class_exists('melhorenvio_shipping_method')) {

            /**
             * Class MelhorEnvio_Shipping_Method
             */
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
                    $this->id                 = 'tessmann-shipping';
                    $this->method_title       = 'Cotações Tessmann';
                    $this->method_description = 'Métodos de entregas do Melhor Envio';

                    $this->init();

                    $this->title = isset($this->settings['title']) ? $this->settings['title'] : 'Melhor Envio';
                    $this->token = isset($this->settings['token']) ? $this->settings['token'] : null;
                    $this->name = isset($this->settings['name']) ? $this->settings['name'] : null;
                    $this->phone = isset($this->settings['phone']) ? $this->settings['phone'] : null;
                    $this->email = isset($this->settings['email']) ? $this->settings['email'] : null;
                    $this->document = isset($this->settings['document']) ? $this->settings['document'] : null;
                    $this->cnae = isset($this->settings['cnae']) ? $this->settings['cnae'] : null;
                    $this->receipt = isset($this->settings['receipt']) ? $this->settings['receipt'] : 'no';
                    $this->own_hand = isset($this->settings['own_hand']) ? $this->settings['own_hand'] : 'no';
                    $this->agency_jadlog = isset($this->settings['agency_jadlog']) ? $this->settings['agency_jadlog'] : null;
                    $this->agency_latam = isset($this->settings['agency_latam']) ? $this->settings['agency_latam'] : null;
                    $this->enableds = isset($this->settings['enableds']) ? $this->settings['enableds'] : null;

                    (new Token())->set($this->token);
                }

                /**
                 * Init your settings
                 *
                 * @access public
                 * @return void
                 */
                function init()
                {
                    $this->init_settings();
                    $this->init_form_fields();
                    
                    add_action('woocommerce_update_options_shipping_' . $this->id, array($this, 'process_admin_options'));
                }

                public function process_admin_options()
                {
                    RequestService::setAsValid();
                    return parent::process_admin_options();
                }

                /**
                 * Define settings field for this shipping
                 * @return void 
                 */
                function init_form_fields()
                {
                    $this->form_fields = array(
                        'name' => array(
                          'title' => 'Nome do remente',
                          'type' => 'text',
                          'description' => 'Nome do remetente exibido na etiqueta'
                        ),
                        'phone' => array(
                            'title' => 'Telefone',
                            'type' => 'text',
                            'description' => 'Telefone exibido na etiqueta'
                        ),
                        'email' => array(
                            'title' => 'E-mail',
                            'type' => 'text',
                            'description' => 'E-mail do remente da etiqueta'
                        ),
                        'document' => array(
                            'title' => 'CPF',
                            'type' => 'text',
                            'description' => 'O documento deve ser informado para envios de transportadoras privadas'
                        ),
                        'cnae' => array(
                            'title' => 'CNAE',
                            'type' => 'text',
                            'description' => 'Classificação Nacional de Atividades Econômicas. É obrigatório para utilização de LATAM CARGO'
                        ),
                        'token' => array(
                            'title' => 'token',
                            'type' => 'textarea',
                            'description' => "token de acesso do Melhor Envio, você pode gerar seu token pelo seguinte <a target='_blank' href='https://melhorenvio.com.br/painel/gerenciar/tokens'>link</a>"
                        ),
                        'agency_jadlog' => array(
                            'title' => 'Agência Jadlog',
                            'type' => 'select',
                            'options' => (new AgenciesService())->getAgenciesJadlog(),
                            'description' => 'Agência Jadlog padrão do seu estado para realizar envios com Jadlog. Você pode encontra as agências pelo <a href="https://melhorenvio.com.br/mapa" target="_blank">mapa</a>'
                        ),
                        'agency_latam' => array(
                            'title' => 'Agência LATAM Cargo',
                            'type' => 'select',
                            'options' => (new AgenciesService())->getAgenciesLatam(),
                            'description' => 'Agência LATAM Cargo padrão do seu estado para realizar envios com LATAM Cargo. Você pode encontra as agências pelo <a href="https://melhorenvio.com.br/mapa" target="_blank">mapa</a>'
                        ),
                        'receipt' => array(
                            'title' => 'Aviso de recebimento',
                            'type' => 'checkbox',
                            'default' => 'no'
                        ),
                        'own_hand' => array(
                            'title' => 'Mãos própria',
                            'type' => 'checkbox',
                            'default' => 'no'
                        ),
                        'enableds' => array(
                            'title' => 'Serviços disponíveis para cotação',
                            'description' => 'Pressione Ctrl e clique nos serviços que deseja selecionar',
                            'type' => 'multiselect',
                            'options' => array(
                                1 => 'Correios PAC',
                                2 => 'Correios Sedex',
                                3 => 'Jadlog .Package',
                                4 => 'Jadlog .Com',
                                12 => 'LATAM Cargo éFácil',
                                17 => 'Correios MINI',
                                22 => 'Buslog Rodoviário',
                                23 => 'Correios PAC GF',
                                24 => 'Correios SEDEX GF'
                            )
                       )
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
                    if(empty($this->token)) {
                        return false;
                    }

                    $rates = (new CalculateService($package, $this->enableds))
                        ->calculate();

                    if (empty($rates)) {
                        return false;
                    }

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
        $methods['melhor-envio-Tessmann'] = 'MelhorEnvio_Shipping_Method';
        return $methods;
    }

    add_filter('woocommerce_shipping_methods', 'add_melhorenvio_shipping_method');
}
