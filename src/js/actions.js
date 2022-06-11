jQuery('document').ready(function() {

    jQuery('.receive-template-order').on('click', '.add-cart-me', function(event){

        event.preventDefault();

        let post_id = jQuery(this).data('id');

        jQuery(this).hide();

        jQuery('.add-cart-me-loader-' + post_id).show();

        addCart(post_id).then(function (_resp) {
            getTemplate(post_id);
        });
    })

    jQuery('.add-cart-me-list').click(function(event){

        event.preventDefault();

        let post_id = jQuery(this).data('id');

        jQuery(this).hide();

        jQuery('.add-cart-me-list-loader-' + post_id).show();

        addCart(post_id).then(function (resp) {
            jQuery('.add-cart-me-list-loader-' + post_id).hide();
            jQuery('.receive-protocol-' + post_id).html('<p class="order-id-me-'+ post_id +'" style="font-size:10px; margin-top: 10px;">Protocolo: <b>' + resp.protocol + '</b></p>');
        });
    })

    jQuery('.receive-template-order').on('click', '.print-ticket-me', function(event){

        event.preventDefault();

        jQuery(this).prop("disabled",true);

        let post_id = jQuery(this).data('id');

        jQuery.ajax({
            type: "POST",
            url:  ajaxurl + '?action=print_ticket',
            data: {'post_id': post_id}
        }).done((response) => {
            jQuery(this).hide();
            window.open(response.url, '_blank').focus();
        }).fail((xhr, status, error) => {
            jQuery(this).display;
            alert(xhr.responseJSON.message);
        });
    })

    jQuery('.receive-template-order').on('click', '.remove-cart-me', function(event){

        event.preventDefault();

        jQuery(this).hide();

        let post_id = jQuery(this).data('id');

        jQuery('.remove-cart-me-loader-' + post_id).show();

        var result = confirm("Você tem certeza que deseja remover o item " + post_id +  " do carrinho do Melhor Envio?");

        if (!result) {
            jQuery(this).prop("disabled",false);
            jQuery('.remove-cart-me-loader-' + post_id).hide();
            return
        } 

        removeCart(post_id).then(function (resp) {
            getTemplate(post_id);
        });
    })

    jQuery('.receive-template-order').on('click', '.pay-cart-me', function(event){

        event.preventDefault();

        let post_id = jQuery(this).data('id');

        let protocol = jQuery(this).data('protocol');

        let price = jQuery(this).data('price');

        jQuery('.pay-cart-me-loader-' + post_id).show();

        var result = confirm("Você tem certeza que deseja pagar o item de protocolo " + protocol +  " do carrinho do Melhor Envio no valor de R$" + price + "?");

        if (!result) {
            jQuery(this).prop("disabled",false);
            jQuery('.pay-cart-me-loader-' + post_id).hide();
            return
        } 

        jQuery(this).hide();

        payTicket(post_id).then(function (_resp) {
            getTemplate(post_id);
        });
    })

    jQuery('.receive-template-order').on('click', '.add-balance-me', function(event){

        event.preventDefault();

        jQuery(this).hide();

        jQuery('.box-add-balance').show();
    });

    jQuery('.receive-template-order').on('click', '.form-add-balance', function(event){

        event.preventDefault();

        let post_id = jQuery(this).data('id');

        let value = jQuery('.balance-me-input').val();

        let gateway = jQuery('.gateway-me-input').val();

        jQuery(this).hide();

        jQuery('.add-balance-me-loader-' + post_id).show();

        jQuery.ajax({
            type: "POST",
            url:  ajaxurl + '?action=add_balance',
            data: {'value': value, 'gateway': gateway}
        }).done((response) => {
            jQuery('.add-balance-me-loader-' + post_id).hide();
            jQuery('.box-add-balance').hide();
            jQuery('.add-balance-me').show();
            jQuery('.form-add-balance').show();
            window.open(response.redirect).focus();
        }).fail(() => {
            alert('Ocorreu um erro ao inserir saldo');
        });
        
    });

    function addCart(post_id)
    {
        return new Promise((resolve, reject) => {
            jQuery.ajax({
                type: "POST",
                url:  ajaxurl + '?action=add_cart',
                data: {'post_id': post_id}
            }).done((response) => {
                resolve(response)
            }).fail(() => {
                reject('Ocorreu um erro ao enviar o pedido para o carrinho de compras do Melhor Envio');
            });
        });
    }

    function removeCart(post_id)
    {
        return new Promise((resolve, reject) => {
            jQuery.ajax({
                type: "POST",
                url:  ajaxurl + '?action=remove_cart',
                data: {'post_id': post_id}
            }).done((response) => {
                resolve(response)
            }).fail(() => {
                reject('Ocorreu um erro ao remover o item do carrinho de compras do Melhor Envio');
            });
        });
    }

    function payTicket(post_id)
    {
        return new Promise((resolve, reject) => {
            jQuery.ajax({
                type: "POST",
                url:  ajaxurl + '?action=pay_ticket',
                data: {'post_id': post_id}
            }).done((response) => {
                resolve(response)
            }).fail(() => {
                reject('Ocorreu um erro ao pagar a etiqueta');
            });
        });
    }

    function getTemplate(post_id)
    {
        jQuery.ajax({
            type: "POST",
            url:  ajaxurl + '?action=get_template_order',
            data: {'post_id': post_id}
        }).done((response) => {
            jQuery('.receive-template-order').html(response.template);
        }).fail((_xhr, _status, _error) => {
            alert('Ocorreu um erro ao obter dados do pedido');
        });
    }

})