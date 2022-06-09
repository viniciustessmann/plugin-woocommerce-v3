jQuery('document').ready(function() {
    jQuery('.add-cart-me').click(function(event){
        event.preventDefault();
        let post_id = jQuery(this).data('id');
        jQuery(this).hide();
        jQuery('.add-cart-me-loader-' + post_id).show();
        jQuery.ajax({
            type: "POST",
            url:  ajaxurl + '?action=add_cart',
            data: {'post_id': post_id}
        }).done((response) => {
            jQuery(this).hide();
            jQuery('.add-cart-me-loader-' + post_id).hide();
            jQuery('.receive-protocol-' + post_id).append( '<p style="font-size:10px; margin-top: 10px;">Protocolo: <b>' + response.protocol + '</b></p>' );
        }).fail((xhr, status, error) => {
            jQuery(this).display;
            alert(xhr.responseJSON.message);
            jQuery('.add-cart-me-loader-' + post_id).hide();
        });
    })

    jQuery('.print-ticket-me').click(function(event){
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

    jQuery('.remove-cart-me').click(function(event){
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
        jQuery.ajax({
            type: "POST",
            url:  ajaxurl + '?action=remove_cart',
            data: {'post_id': post_id}
        }).done((response) => {
            jQuery(this).hide();
            jQuery('.remove-cart-me-loader-' + post_id).hide();
        }).fail((xhr, status, error) => {
            jQuery(this).display;
            jQuery('.remove-cart-me-loader-' + post_id).hide();
            alert(xhr.responseJSON.message);
        });
    })

})