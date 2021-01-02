jQuery('#register_form').on('submit', function (e) {
    jQuery('.feild_error').html('');

    jQuery('#submit_register').html('please wait...');
    jQuery('#submit_register').attr('disabled', true);

    jQuery.ajax({

        url: FRONT_SITE_PATH + 'login_register_suphpbmit',
        type: 'post',
        data: jQuery('#register_form').serialize(),
        success: function (result) {

            jQuery('#submit_register').html('Submit');
            jQuery('#submit_register').attr('disabled', false);
            var data = jQuery.parseJSON(result);
            if (data.status == 'error') {
                jQuery('#' + data.field).html(data.msg);
            }
            if (data.status == 'success') {
                jQuery('#' + data.field).html(data.msg);
                jQuery('#register_form')[0].reset();
            }
        }
    });
    e.preventDefault();
});
jQuery('#login_form').on('submit', function (e) {
    jQuery.ajax({
        url: FRONT_SITE_PATH + 'login_register_suphpbmit',
        type: 'post',
        data: jQuery('#login_form').serialize(),
        success: function (result) {
            var data = jQuery.parseJSON(result);
            if (data.status == 'error') {
                jQuery('#' + data.field).html(data.msg);
            }
            if (data.status == 'success') {
                if (data.msg == 'checkout_login') {
                    window.location.href = FRONT_SITE_PATH + 'checkout';
                } else {
                    window.location.href = FRONT_SITE_PATH;
                }

            }
        }
    });
    e.preventDefault();
});

jQuery('#forgot_password_form').on('submit', function (e) {
    jQuery('#forgot_error').html('');
    jQuery('#forgot_submit_button').html('please wait...');
    jQuery('#forgot_submit_button').attr('disabled', true);
    jQuery.ajax({
        url: FRONT_SITE_PATH + 'login_register_suphpbmit',
        type: 'post',
        data: jQuery('#forgot_password_form').serialize(),
        success: function (result) {
            jQuery('#forgot_submit_button').html('Submit');
            jQuery('#forgot_submit_button').attr('disabled', false);
            var data = jQuery.parseJSON(result);
            if (data.status == 'error') {
                jQuery('#' + data.field).html(data.msg);
            }
            if (data.status == 'success') {
                jQuery('#' + data.field).html(data.msg);
                jQuery('#forgot_password_form')[0].reset();
            }
        }
    });
    e.preventDefault();
});
function sent_cart(id, type) {
    var attr = jQuery('input[name ="radido_' + id + '"]:checked').val();
    var qty = jQuery('#qty_' + id).val();
    var is_type = '';
    if (typeof attr === 'undefined') {
        is_type = 'no';
    }

    if (qty > 0 && is_type != 'no') {
        jQuery.ajax({
            url: FRONT_SITE_PATH + 'sent_cart',
            type: 'post',
            data: 'attr=' + attr + '&qty=' + qty + '&type=' + type,
            success: function (result) {
                var data = jQuery.parseJSON(result);
                swal("Congratulations!", "You Successfully added!", "success");
                jQuery('#qtyadd_' + attr).html('recent-' + qty);
                jQuery('.count-style').html(data.totalcart);
                jQuery('.cart-digit-bold').html(data.totalamount);
                // var shop_total = data.totalamount;
                if (data.totalcart == 1) {
                    var html = '<div class="shopping-cart-content">\n\
                                     <ul id = "li_add"> <li class="single-shopping-cart" id = "attr_' + attr + '">\n\
                                      <div class="shopping-cart-img">\n\
                                        <a href="#"><img class="img-fluid" alt="" src=" ' + SITE_DISH_IMAGE + data.image + '"></a></div> \n\
                                        <div class="shopping-cart-title">  <h4>' + data.dish + '<a href="#"></a></h4> \n\
                                       <h6>Qty:' + qty + '</h6><span>' + data.price + ' Tk</span> </div> <div class="shopping-cart-delete"> <a href="javascript:void(0)" onclick=delete_cart("' + attr + '") ><i class="ion ion-close"></i></a>\n\
                                        </div>   </li></ul><div class="shopping-cart-total"><h4>Total : <span class="shop-total">' + data.totalamount + '</span></h4>\n\
                                       </div> <div class="shopping-cart-btn"> <a href="cart">view cart</a> \n\
                                       <a href="checkout">checkout</a>\n\
                                       </div> </div>';
                    jQuery('.header-cart').append(html);
                } else {
                    jQuery('#attr_' + attr).remove();
                    var html = '<li class="single-shopping-cart" id = "attr_' + attr + '">\n\
                                      <div class="shopping-cart-img">\n\
                                        <a href="#"><img class="img-fluid" alt="" src=" ' + SITE_DISH_IMAGE + data.image + '"></a></div> \n\
                                        <div class="shopping-cart-title">  <h4>' + data.dish + '<a href="#"></a></h4> \n\
                                       <h6>Qty:' + qty + '</h6><span>' + data.price + ' Tk</span> </div> <div class="shopping-cart-delete"> <a href="javascript:void(0)" onclick=delete_cart("' + attr + '")><i class="ion ion-close"></i></a>\n\
                                        </div></li>';
                    jQuery('#li_add').append(html);
                    jQuery('.shop-total').html(data.totalamount);

                }
            }
        });
    } else {
        swal("Error!", "Please select Qty and Dish", "error");

    }
}
function delete_cart(details_id, type) {
    jQuery.ajax({
        url: FRONT_SITE_PATH + 'sent_cart',
        type: 'post',
        data: 'attr=' + details_id + '&type=' + type,
        success: function (result) {
            var data = jQuery.parseJSON(result);
            if (data.totalamount == 0) {
                jQuery('.shopping-cart-content').remove();
                jQuery('#attr_' + details_id).remove();
            } else {
                jQuery('#attr_' + details_id).remove();
                jQuery('.shop-total').html(data.totalamount);

                // jQuery(''#qtyadd_'+data.dish_details_id').html(' ');

            }
            jQuery('#qtyadd_' + details_id).remove();
            jQuery('.count-style').html(data.totalcart);
            jQuery('.cart-digit-bold').html(data.totalamount);
        }
    });
}

jQuery('#profileAcount').on('submit', function (e) {
    jQuery.ajax({
        url: FRONT_SITE_PATH + 'sent_profile',
        type: 'post',
        data: jQuery('#profileAcount').serialize(),
        success: function (result) {
            var data = jQuery.parseJSON(result);
            if (data.status == 'success') {
                jQuery('#profile_name').html('Welcome ' + data.name);
                swal("success", data.msg, "success");
                // jQuery('#profileAcount')[0].reset();
            }
        }
    });
    e.preventDefault();
});

jQuery('#password_change').on('submit', function (e) {
    jQuery.ajax({
        url: FRONT_SITE_PATH + 'sent_profile',
        type: 'post',
        data: jQuery('#password_change').serialize(),
        success: function (result) {
            var data = jQuery.parseJSON(result);
            if (data.status == 'success') {
                swal("success", data.msg, "success");
                // jQuery('#profileAcount')[0].reset();
            }
            if (data.status == 'error') {
                swal("error", data.msg, "error");
                jQuery('#profileAcount')[0].reset();
            }
        }

    });
    e.preventDefault();
});
function coupon(total_amount) {
    var coupon_code = jQuery('#coupon_applay').val();
    if (coupon_code == '') {
        swal("Error", 'Please Enter Coupon Code', "error");
    } else {
        jQuery.ajax({
            url: 'coupon_apply',
            type: 'post',
            data: 'coupon_code=' + coupon_code + '&total_amount=' + total_amount,
            success: function (result) {
                var data = jQuery.parseJSON(result);
                if (data.status == 'error') {
                    swal("Error", data.msg, "error");
                }
                if (data.status == 'success') {
                    swal("Success", data.msg, "success");
                    jQuery('#coupon_applly').show();
                    jQuery('.discount_price').html(data.discount_price + ' Tk');
                    //jQuery('#coupon_applay').html('');
                }
            }
        });
    }

}

function check_cat_min_value(total_amount) {
    jQuery.ajax({
        url: 'get_setting',
        type: 'post',
        data: 'total_amount=' + total_amount,
        success: function (result) {
            var data = jQuery.parseJSON(result);
            if (data.status == 'error') {
                swal("Error", data.msg, "error");
            }
            if (data.status == 'success') {
                jQuery('#payment-2').addClass('show');

            }
        }
    });
}

function select_rank(dish_details_id, oid) {
    var rate = jQuery('#ranking'+dish_details_id).val();
    var rate_str = jQuery('#ranking'+dish_details_id+' option:selected').text();
    //alert(rate_str);
    if (rate != '') {
        jQuery.ajax({
            url: 'select_rank',
            type: 'post',
            data: 'rate=' + rate + '&dish_details_id=' + dish_details_id + '&order_id=' + oid,
            success: function (result) {
              jQuery('#ranking'+dish_details_id).html('<option value="">'+rate_str+'</option>');
            }
        });
    }
}