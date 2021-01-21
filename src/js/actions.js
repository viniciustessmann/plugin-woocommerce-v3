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
            jQuery('.receive-protocol-' + post_id).append( '<p style="font-size:10px; margin-top: 10px;">Protocolo: <b>' + response.protocol + '</b></p>' );
        }).fail((xhr, status, error) => {
            jQuery(this).display;
            alert(xhr.responseJSON.message);
        });
    })
})