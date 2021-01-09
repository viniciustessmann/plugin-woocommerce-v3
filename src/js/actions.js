jQuery('document').ready(function() {
    jQuery('.add-cart-me').click(function(event){
        event.preventDefault();
        jQuery(this).prop("disabled",true);
        let post_id = jQuery(this).data('id');
        jQuery.ajax({
            type: "POST",
            url:  ajaxurl + '?action=add_cart',
            data: {'post_id': post_id}
        }).done((response) => {
            jQuery(this).hide();
            jQuery('.order-id-me-' + post_id).append( "<p>Protocolo: <b>" + response.protocol + "</b></p>" );
        }).fail(() => {
            jQuery(this).display;
            alert('Ocorreu um erro ao enviar o pedido ' + post_id + ' para o carrinho de compras do Melhor Envio');
        });
    })
})