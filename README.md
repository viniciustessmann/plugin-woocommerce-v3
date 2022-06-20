=== Cotações Tessmann ===
Contributors: Vinícius Schlee Tessmann
Requires at least: 5.1
Tested up to: 6.0
Requires PHP: 5.6
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Esse plugin foi desenvolvido para realizar cotações com a API pública do [Melhor Envio](https://melhorenvio.com.br/) e também para inserir os pedidos do WooCommerce no carrinho de compras do Melhor Envio. Esse plugin é um desenvolvimento independente do Melhor Envio, qualquer dúvida ou sugestão deve ser realizada na página do Github desse projeto pelo seguinte [Link](https://github.com/viniciustessmann/plugin-woocommerce-v3).
A proposta do plugin é realizar as cotações e inserções do carrinho de compras de forma rápida e simples, caso você deseje mais funcionandades como por exemplo, classes de entregas, calculadora na tela do produto, areas de entregas, configuração independente para cada serviço de envio, sugiro utilizar o [Plugin ofical do Melhor Envio](https://wordpress.org/plugins/melhor-envio-cotacao/)

![image info](https://raw.githubusercontent.com/viniciustessmann/plugin-woocommerce-v3/develop/src/img/cotacao.png)

# Transportadoras e serviços disponíveis 
  - Correios Pac
  - Correios Sedex
  - Correios Mini Envios
  - Correios PAC grandes formatos
  - Correios Sedex grandes formatos
  - Jadlog Package
  - Jadlog .Com
  - LATAM Cargo éFácil
  - Buslog Rodoviário

### Instalação
Clone do repositório dentro do diretório /wp-content/plugins
```sh
$ git clone https://github.com/viniciustessmann/plugin-woocommerce-v3.git
```
```sh
$ composer install
```

### Como usar?
O plugin cria uma metodo de envio que extende as funcionalidades de cotação do plugin do WooCommerce, você precisa preencher algumas informações para funcionamento do plugin. No menu, acesse WooCommerce -> Configurações -> Entrega e clique na aba Cotações Tessmann:
![image info](https://raw.githubusercontent.com/viniciustessmann/plugin-woocommerce-v3/master/src/img/configuracao.png)

Para enviar um pedido para o carrinho de compras basta acessar a lista de pedidos do WooCommerce, e clicar no botão adicionar, assim o pedido será enviado para o seu carrinho de compras do Melhor Envio, o fluxo posterior de comprar e impressão até o momento precisa ser realizado na plataforma do Melhor Envio.
![image info](https://raw.githubusercontent.com/viniciustessmann/plugin-woocommerce-v3/master/src/img/pedidos.png).

E você  pode acessar os dados como Protocolo, status e código de rastreio diretamente na página de detalhes do pedido do WooCommerce através de um Box Meta customizado.
![image info](https://raw.githubusercontent.com/viniciustessmann/plugin-woocommerce-v3/develop/src/img/detalhes.png)

== Changelog ==
= 1.8.0 =
* Adição de aviso de token inválido ou vencido 

= 1.7.1 =
* Correção na atualização do token 

= 1.7.0 =
* Adição do link de rastreio na aba de "Minhas compras".

= 1.6.0 =
* Adição da funcionalidade de inserir créditos na carteira do Melhor Envio.

= 1.5.0 =
* Adição da funcionalidade de pagar etiqueta por dentro da tela de detalhes do pedido.

= 1.4.2 =
* Melhorias na exibição de dados do pedido.

= 1.4.1 =
* Melhorias na estrutura do código fonte.

= 1.4.0 =
* Adição de opcionais de mãos própria e aviso de recebimento.

= 1.3.1 =
* Adição da imagem da transportdora no detalhe do envio.
* Adição de loader durante as requests para a API do Melhor Envio.
* Estilização de botões de ações.

= 1.3.0 =
* Adição da função de remover um item do carrinho do Melhor Envio.

= 1.2.0 =
* Adição de campo CNAE nos dados do vendedor.
* Adição do serviço LATAM CARGO éFácil
* Adição do serviço Buslog Rodoviário
* Adição do serviço Correios PAC Grandes volumes
* Adição do serviço Correios SEDEX Grandes volumes

= 1.1.0 =
* Adicionando fucionalidade de imprimir etiquetas

= 1.0.18 =
* Adição de informações sobre o serviço selecionado