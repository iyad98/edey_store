var get_url = $('#get_url').val();
var get_lang = $('#get_lang').val();
var get_source_url = $('#get_source_url').val();


function show_pop_up_message(message) {
    $('#yith-wcwl-message').text(message);
    $('#yith-wcwl-popup-message').show();
    setTimeout(function () {
        $('#yith-wcwl-popup-message').hide();
    } , 2500);
}
/**
 * Scroll To #
 */
jQuery( '#go-to-top' ).on('click', function(){

    jQuery('html,body').stop().animate({scrollTop:0}, 500, 'swing');
    return false;
});

/**
 * Go to top button
 */
var $window = jQuery(window);
var $topButton = jQuery('#go-to-top');
$window.scroll(function(){
    if ( $window.scrollTop() > 100 ){
        $topButton.addClass('show-top-button')
    }
    else {
        $topButton.removeClass('show-top-button')
    }
});



function add_to_wishlist(product_id  ,in_favorite) {


    var wishlist_comp = ".wishlist_comp_"+product_id;
    if($(wishlist_comp).hasClass('btn_added_fav')) {
        remove_from_wishlist(product_id)
        return;
    }



    axios.get(get_url+"/add-to-wishlist" , {
        params : {
            product_id : product_id
        }
    }).then(function (res) {

        if(res.data['status']) {
            $('.wishlist_comp_'+product_id).addClass('btn_added_fav');

            $('.suc_alert').removeClass('hidden');
            $('.suc_alert').text(res.data['success_msg']);
            $("html, body").animate({ scrollTop: 0 }, "slow");


        }else {
            $('.dan_alert').removeClass('hidden');
            $('.dan_alert').text(res.data['error_msg']);
            $("html, body").animate({ scrollTop: 0 }, "slow");
            return;

            // $.notify(res.data['error_msg'], "error");
        }


    }).catch(function (err) {
    });
}

function remove_from_wishlist(product_id ) {

    axios.get(get_url+"/remove-from-wishlist" , {
        params : {
            product_id : product_id
        }
    }).then(function (res) {


        if(res.data['status']) {

            $('.wishlist_comp_'+product_id).removeClass('btn_added_fav');
            $('.suc_alert').removeClass('hidden');
            $('.suc_alert').text(res.data['success_msg']);
            $("html, body").animate({ scrollTop: 0 }, "slow");


        }else {
            $('.dan_alert').removeClass('hidden');
            $('.dan_alert').text(res.data['error_msg']);
            $("html, body").animate({ scrollTop: 0 }, "slow");
            return;

            // $.notify(res.data['error_msg'], "error");
        }

    }).catch(function (err) {
        $('.remove_to_wishlist_loading').addClass('hidden');
    });
}
/*
var get_mobile_cart_data_vue = new Vue({
    el : '#get-mobile-cart-data' ,
    data : {
        count_products : 0,
        total_price : 0,
        currency : '',
    },

});
*/
var get_cart_simple_data = new Vue({
    el: '#get-cart-simple-data',
    data : {
        count_quantity: 0,
    },
    methods :{
        show_cart_data : function () {
            $('.jas-mini-cart').css('left' , 0);
            $('.mask-overlay').removeClass('hidden');
        }
    }
});
var get_cart_data_vue = new Vue({
    el: '#get-cart-data',
    data: {
        count_products: "",
        total_price: "",
        count_favorites : "",
        count_quantity : "",
        currency: '',
        cart_data : []
    },
    created: function () {
        this.get_cart_data();
    },
    methods: {
        get_cart_data: function () {

            axios.get(get_url + "/get-cart-data").then(function (res) {
                get_cart_data_vue.count_favorites = res.data['count_favorites'];
                get_cart_data_vue.count_quantity = res.data['count_quantity'];
                get_cart_data_vue.count_products = res.data['count_products'];
                get_cart_data_vue.total_price = res.data['total_price'];
                get_cart_data_vue.currency = res.data['currency'];
                get_cart_data_vue.cart_data = res.data['cart_data'];

            }).catch(function (err) {

            });
        },
        hide_cart_data : function () {
            $('.jas-mini-cart').css('left' , "-320px");
            $('.mask-overlay').addClass('hidden');
        }
    },
    watch: {
        count_quantity : function () {
             get_cart_simple_data.count_quantity = this.count_quantity;
         },
        /* total_price : function () {
             get_mobile_cart_data_vue.total_price = this.total_price;
         },
         currency : function () {
             get_mobile_cart_data_vue.currency = this.currency;
         }*/
    }
});

var subscribe = new Vue({
    el : '#sec_block_subscribe' ,
    data : {
        email : ''
    },
    created : function () {

    },
    methods : {
        store_mailing_list: function () {

            axios.post(get_url + "/mailing_list",{email: subscribe.email}).then(function (res) {

                if(res.data['status'] === true) {

                    $('.suc_alert_mailing_list').removeClass('hidden');
                    $('.suc_alert_mailing_list').text(res.data['message']);
                    $('.dan_alert_mailing_list').addClass('hidden');

                    subscribe.email = '';


                }else {
                    $('.dan_alert_mailing_list').removeClass('hidden');
                    $('.suc_alert_mailing_list').addClass('hidden');
                    $('.dan_alert_mailing_list').text(res.data['message']);
                }


            }).catch(function (err) {
                $('.dan_alert_mailing_list').removeClass('hidden');
                $('.suc_alert_mailing_list').addClass('hidden');
                $('.dan_alert_mailing_list').text(res.data['message']);
            });
        }
    }
});

function add_to_cart(product_id, quantity, attribute_values, show_msg = 1 , show_notify , from_website , ccc = 0) {

    if(from_website == 1) {
        quantity = '1';
    }


    let add_to_cart_id = '.add_to_cart_'+product_id;
    let spinner_cart_id = '.spinner_cart_'+product_id;

    if (ccc == 1){
        $(spinner_cart_id).removeClass('hidden');

    }


    axios.post(get_url + "/add-or-update-product-to-cart", {
        product_id: product_id,
        quantity: quantity,
        attribute_values: attribute_values ,
        from_website : from_website
    }).then(function (res) {


        res.data = res.data.original;
        if (res.data['status']) {

            if (ccc == 1){
                $(add_to_cart_id).text('في عربة التسوق');
                $(add_to_cart_id).addClass('cart_aded');
                $(spinner_cart_id).addClass('hidden');

            }
            get_cart_data_vue.count_products = res.data['count_products'];
            get_cart_data_vue.count_quantity = res.data['count_quantity'];
            get_cart_data_vue.total_price = res.data['total_price'];
            get_cart_data_vue.cart_data.products.push(res.data['data']);
            product_details.product.in_cart = true;




            if (show_msg == 1){
                $('.suc_alert').removeClass('hidden');
                $('.suc_alert').text(res.data['message']);
                $("html, body").animate({ scrollTop: 0 }, "slow");

                return;
            }

            // if (res.data['add']) {
            //     get_cart_data_vue.cart_data.products.push(res.data['data']);
            // } else {
            //     let get_cart_data_index = get_cart_data_vue.cart_data.products.findIndex(el => el.cart_product_id == res.data['data']['cart_product_id']);
            //     if (get_cart_data_index >= 0) {
            //         Vue.set(get_cart_data_vue.cart_data.products, get_cart_data_index, res.data['data']);
            //     }
            //     // else {
            //     //     get_cart_data_vue.cart_data.products.push(res.data['data']);
            //     // }
            // }



            if (show_notify) {
                $(add_to_cart_id).notify( res.data['message'], { position:"top",className:'success' })
            }

        } else {
            if (show_msg == 1){
            $('.dan_alert').removeClass('hidden');
            $('.dan_alert').text(res.data['message']);
            $("html, body").animate({ scrollTop: 0 }, "slow");
            return;
            }
            if (ccc == 1){
                $(add_to_cart_id).notify( res.data['message'], { position:"top",className:'error' })
                $(spinner_cart_id).addClass('hidden');

            }

            $(loader_id).addClass('hidden');

        }

    }).catch(function (err) {
    });
}


function get_round_number(price) {
    return Math.round(price * 100) / 100;
}

function convertNumber(number) {

    number = number.replace(/[٠-٩]/g, d => "٠١٢٣٤٥٦٧٨٩".indexOf(d)).replace(/[۰-۹]/g, d => "۰۱۲۳۴۵۶۷۸۹".indexOf(d));

    return number;
}
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};

function setValueInUrl(key, value) {


    var url = new URL(document.location.href);
    var query_string = url.search;
    var search_params = new URLSearchParams(query_string);
    search_params.set(key, value);
    url.search = search_params.toString();
    var new_url = url.toString();
    window.history.pushState({path: new_url}, '', new_url);
    return new_url;
}

function get_search_input() {
    let new_url = setValueInUrl('search', $('#search_product_input').val());
    window.location = get_url + "/shop/?search="+$('#search_product_input').val();

    // if(new_url.indexOf("/shop") > -1) {
    //     window.location = new_url;
    // }else {
    //     window.location = get_url + "/shop/?search="+$('#search_product_input').val();
    // }

}

$(document).ready(function () {

    $('.show_hidden').removeClass('hidden');
    $('.search_product_button').click(function () {
        get_search_input();
    });
    $('.btn_open_search').click(function () {
        $('#search').addClass('open');
    });
    $('.overlay-close').click(function () {
        $('#search').removeClass('open');
    });
    $("#search_product_input").keypress(function (event) {

        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            event.preventDefault();
            get_search_input();
        }
    });
    $('.auth-options').change(function () {
        let value = $(this).val();
        if (value == "logout") {
            window.location = get_url + "/website/logout";
        }else if(value == "orders") {
            window.location = get_url + "/my-account/orders";

        }else if(value == "coupons") {
            window.location = get_url + "/my-account/coupons";

        } else {
            window.location = get_url + "/my-account";
        }
    });

    $('.iconsTop4 .navImage').click(function () {
        window.location = get_url + "/my-account";

    });

    $('#lang').change(function () {
        window.location = $(this).val();
    });
});
