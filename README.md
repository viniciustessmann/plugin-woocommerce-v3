# Cotações Tessmann

Esse plugin foi desenvolvido para realizar cotações com a API pública do [Melhor Envio](https://melhorenvio.com.br/) e também para inserir os pedidos do WooCommerce no carrinho de compras do Melhor Envio. Esse plugin é um desenvolvimento independente do Melhor Envio, qualquer dúvida ou sugestão deve ser realizada na página do Github desse projeto pelo seguinte [Link](https://github.com/viniciustessmann/plugin-woocommerce-v3).
A proposta do plugin é realizar as cotações e inserções do carrinho de compras de forma rápida e simples, caso você deseje mais funcionandades como por exemplo, classes de entregas, calculadora na tela do produto, areas de entregas, configuração independente para cada serviço de envio, sugiro utilizar o [Plugin ofical do Melhor Envio](https://wordpress.org/plugins/melhor-envio-cotacao/)

# Transportadoras e serviços disponíveis 
  - Correios Pac
  - Correios Sedex
  - Correios Mini Envios
  - Jadlog Package
  - Jadlog .Com

### Instalação
Clone do repositório dentro do diretório /wp-content/plugins
```sh
$ git clone https://github.com/viniciustessmann/plugin-woocommerce-v3.git
```
```sh
$ composer install
```

### Como usar?
O plugin cria uma metodo de envio que extende as funcionalidades de cotação do plugin do WooCommerce, você precisa preencher algumas informações para funcionamento do plugin. No menu, acesse WooCommerce -> Configurações -> Entrega e clique na aba Cotações Tessmann.


Para enviar um pedido para o carrinho de compras basta acessar a lista de pedidos do WooCommerce, e clicar no botão adicionar, assim o pedido será enviado para o seu carrinho de compras do Melhor Envio, o fluxo posterior de comprar e impressão até o momento precisa ser realizado na plataforma do Melhor Envio.