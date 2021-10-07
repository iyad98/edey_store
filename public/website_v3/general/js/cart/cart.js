var cart_data_vue = new Vue({
    el : '#cart-details-data' ,
    data : {
        cart_data : '' ,
        coupon_code : coupon_code,
    },
    created : function () {
        this.get_cart_data();
    },
    methods : {
        get_cart_data : function (coupon = -1) {

            this.show_loading();
            var get_coupon_code= this.coupon_code;
            axios.get(get_url+'/get-cart-details-data?coupon_code='+get_coupon_code).then(function (res) {

                cart_data_vue.cart_data  = res.data;
                console.log(res.data)
                get_cart_data_vue.count_products = res.data['count_products'];
                get_cart_data_vue.count_quantity = res.data['count_quantity'];
                get_cart_data_vue.total_price = res.data['price_with_tax'];

                if(res.data['count_products'] <= 0) {
                    $('.show_empty_cart').removeClass('hidden');
                    $('#cart-details-data').addClass('hidden');
                }
                cart_data_vue.hide_loading();

            }).catch(function (err) {
                cart_data_vue.hide_loading();
            });
        } ,



        update_quantity : function ( cart_product_id , quantity) {

            $('.quantity div').addClass('disabled');

            var get_data = [];
            // this.cart_data.products.forEach(function (t) {
            //     get_data.push({cart_product_id : t.cart_product_id , quantity : t.quantity});
            // });
            get_data.push({cart_product_id : cart_product_id , quantity : quantity});


            var form_data = new FormData();
            form_data.append('get_data' , JSON.stringify(get_data));

            this.show_loading();
            axios.post(get_url+"/update-cart-quantity" , form_data).then(function (res) {

                cart_data_vue.cart_data  = res.data;

                get_cart_data_vue.count_products = res.data['count_products'];
                get_cart_data_vue.count_quantity = res.data['count_quantity'];
                get_cart_data_vue.total_price = res.data['total_price'];
                get_cart_data_vue.cart_data = res.data;

                if(res.data['count_products'] <= 0) {
                    $('.show_empty_cart').removeClass('hidden');
                    $('#cart-details-data').addClass('hidden');
                }
                $('.quantity div').removeClass('disabled');

                $('.blockOverlay').addClass('hidden');
                $('.blockMsg').addClass('hidden');
            }).catch(function (err) {
                $('.blockOverlay').addClass('hidden');
                $('.blockMsg').addClass('hidden');
            });
        },
        remove_product_from_cart : function (cart_product_id) {

            this.show_loading();
            axios.get(get_url+"/remove-product-from-cart/"+cart_product_id).then(function (res) {


                cart_data_vue.cart_data  = res.data.cart_data;
                get_cart_data_vue.count_products = res.data.cart_data['count_products'];
                get_cart_data_vue.count_quantity = res.data.cart_data['count_quantity'];
                get_cart_data_vue.total_price = res.data.cart_data['total_price'];
                get_cart_data_vue.cart_data = res.data.cart_data;

                if(res.data.cart_data['count_products'] <= 0) {
                    $('.show_empty_cart').removeClass('hidden');
                    $('#cart-details-data').addClass('hidden');
                }
                cart_data_vue.hide_loading();

               $.notify(res.data['message'], "success");


            }).catch(function (err) {
                cart_data_vue.hide_loading();
            });
        },

        apply_coupon : function () {

            let coupon_code = this.coupon_code;

            this.show_loading();
            axios.get(get_url+'/apply-coupon' , {
                params : {
                    coupon_code : coupon_code
                }
            }).then(function (res) {

                if(res.data['status']) {
                    if(cart_data_vue.coupon_code != "") {
                        $(".discount-code").notify(res.data['message'], "success");
                    }

                }else {
                    $(".discount-code").notify(res.data['message'], "error");

                }
                cart_data_vue.cart_data  = res.data['data'];
                get_cart_data_vue.count_products = res.data['data']['count_products'];
                get_cart_data_vue.total_price = res.data['data']['total_price'];
                get_cart_data_vue.cart_data = res.data['data'];

            }).catch(function (err) {

            });
        },
        get_attribute_values_name : function (attribute_values) {
            let attribute_value_name = pluck_('name');
            let attribute_values_name = attribute_value_name(attribute_values);

            return attribute_values_name.join(' - ');
        } ,


        show_loading : function () {
            $('.blockOverlay').removeClass('hidden');
            $('.blockMsg').removeClass('hidden');
            $('.show_empty_cart').addClass('hidden');

        },
        hide_loading : function () {
            $('.blockOverlay').addClass('hidden');
            $('.blockMsg').addClass('hidden');
        },
        get_round_number :function (price) {
            return get_round_number(price);
        },
        get_price_after_discount : function (product) {
            return get_round_number(product.price - product.discount_price);
        },
        get_total_price_after_discount : function (product) {
            return get_round_number(product.quantity * (product.price - product.discount_price));
        },
        get_total_price_after_coupon : function (cart_data) {
            return get_round_number(cart_data.price_after - cart_data.coupon_price - cart_data.coupon_automatic_price );
        }
    }
});

$(document).ready(function () {
    $('.show_cart_data').removeClass('hidden');
});