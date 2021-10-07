var cart_data_vue = new Vue({
    el: '#cart-details-data',
    data: {
        cart_data: '',
        coupon_code: '',
        country_code : country_code,
        phone_code : '',
        payment_method: '',

        payment_method_for_city : [],
        payment_methods:[],

        card_number:'',
        card_name:'',
        card_month:'',
        card_year:'',
        card_cvv:'',

        user_shipping: shipping_info,
        all_shipping_info : all_shipping_info,

        error_msg : '',
        success_msg : '' ,

        shipping_companies : [],
        cities : [],

        billing_national_address : false ,
        billing_building_number : false ,
        billing_postalcode_number : false ,
        billing_unit_number : false ,
        billing_extra_number : false ,

        confrim_phone : {
            phone_code : '',
            phone : '',
            steps : 1 ,
            loading : false,
            confirm_loading : false,
        },
        lat : '',
        lng : '',

        is_gift : false,

        phone_code_user:country_code,


    },
    created: function () {
        this.confrim_phone.phone_code = confirm_phone_data.phone_code;
        this.confrim_phone.phone = confirm_phone_data.phone;
        this.confrim_phone.steps = confirm_phone_data.steps;
        this.update_billing(false );
        // $('input[name=payment_method]:first').attr('checked', true);


        if (this.confrim_phone.steps === 3){
            $('.btn_verify').text('تم التحقق');
            $('.btn_verify').attr('disabled', true);
        }

    },
    methods: {
        get_cart_data: function (coupon = -1) {

            this.show_loading();
            axios.get(get_url + '/get-cart-details-data?coupon_code=' + coupon_code).then(function (res) {


                cart_data_vue.cart_data = res.data;
                console.log(res.data);
                if (res.data['count_products'] <= 0) {
                    $('.show_empty_cart').removeClass('hidden');
                }
                cart_data_vue.hide_loading();

            }).catch(function (err) {
                cart_data_vue.hide_loading();
            });
        },

        get_attribute_values_name: function (attribute_values) {
            let attribute_value_name = pluck_('name');
            let attribute_values_name = attribute_value_name(attribute_values);

            return attribute_values_name.join(' - ');
        },


        get_shipping_companies: function () {

            // var city_id = $('.select_city').val();
            // if(!city_id) {
            //     return;
            // }
            var city_id = -1;
            axios.get(get_source_url + "/api/shipping-companies/" + city_id, {
                headers: {
                    'Accept-Language': get_lang
                }
            }).then(function (res) {

                var shipping_companies = res.data['data'];
                cart_data_vue.shipping_companies = shipping_companies;

                $('.order-dis').addClass('hidden');
                // if (cart_data_vue.user_shipping.billing_shipping_type == null){
                //     $('input[name=shipping_company]:first').attr('checked', true);
                // }else {
                //     $('.shipping_company_'+cart_data_vue.user_shipping.billing_shipping_type).attr('checked', true);
                // }
                // if ( $("input[name='shipping_company']:checked"). val() == '1'){
                //     $('.order-dis').addClass('hidden');
                // }
                cart_data_vue.update_billing();

            }).catch(function (err) {

            });
        },
        get_cities: function () {

            // $('.cash').css('display','none');
            // $('.visa').css('display','none');
            // $('.bank_transfer').css('display','none');


            var country_id = $('.select_country').val();

            $('.select_city').empty();
            $('.select_city').prop('disabled', true);

            if(!country_id) {
                return;
            }
            axios.get(get_source_url + "/api/cities/" + country_id, {
                headers: {
                    'Accept-Language': get_lang
                }
            }).then(function (res) {

                $('.select_city').prop('disabled', false);

                var cities = res.data['data'];

                var payment_method_for_city =  res.data['payment_methods'];



                cart_data_vue.payment_method_for_city = payment_method_for_city;

                cart_data_vue.cities = cities;

                cities.forEach(function (t) {
                    let selected = false;
                    var newOption = new Option(t.name, t.id, selected, selected);
                    $('.select_city').append(newOption);
                });

                let first_city_if_exists = cities.length > 0 ? cities[0].id : -1;
                let get_if_selected = cities.find(el => el.id == cart_data_vue.user_shipping.city);
                if(get_if_selected) {
                    $('.select_city').val(cart_data_vue.user_shipping.city).trigger('change');
                }else {
                    $('.select_city').val(first_city_if_exists).trigger('change');
                }

                cart_data_vue.get_shipping_companies();

            }).catch(function (err) {
                console.log(err);
            });
        },

        update_billing: function (update_shipping = true , accept_user_shipping_address = true) {


            $("input[name='shipping_company']").change(function () {

                if ($("input[name='shipping_company']:checked"). val() == '1'){
                    $('.order-dis').addClass('hidden');
                }else {
                    $('.order-dis').removeClass('hidden')

                }
            });

            if (update_shipping) {
                let get_company_selected =  $("input[name='shipping_company']:checked").val();
                this.user_shipping.billing_shipping_type = get_company_selected;

                if (get_company_selected != "") {
                    var company_id = get_company_selected;
                    this.user_shipping.billing_shipping_type = get_company_selected;

                } else {
                    var company_id = -2;
                    this.user_shipping.billing_shipping_type = company_id;

                }

            }


            var user_shipping_id =  $("input[name='addresses']:checked"). val();

            let selected_user_shipping = all_shipping_info.find(el => el.id == user_shipping_id);
           if (selected_user_shipping == null || selected_user_shipping == ''){
               var city_id = $('.select_city').val();
               var payment_method =  $("input[name='payment_method']:checked"). val();
            }else {
               var city_id = selected_user_shipping['city'];
               var payment_method =  -1;
           }






            this.show_loading();
            axios.post(get_url + "/update-billing", {
                company_id: company_id,
                city_id: city_id,
                payment_method: payment_method,
                user_shipping_id : user_shipping_id,
                user_shipping :this.user_shipping

            }).then(function (res) {

                if (res.data['status']) {

                    cart_data_vue.cart_data = res.data['data'];
                    get_cart_data_vue.count_products = res.data['data']['count_products'];
                    get_cart_data_vue.total_price = res.data['data']['total_price'];

                } else {
                    $('input[name="payment_method"]').prop('checked', false);
                    $('.payment_box').addClass('hidden');
                    show_pop_up_message(res.data['message']);
                    //$.notify(res.data['message'], "error");
                }
                cart_data_vue.hide_loading();
            }).catch(function (err) {

            });
        },

        add_order: function () {



            // if (this.confrim_phone.steps != 3 ){
            //     $('#order_dt').modal('show');
            //     this.send_phone_code();
            //
            // }else {
            // }


                cart_data_vue.update_billing(true ,'dont_change' );

                $('#add_order_loader').removeClass('hidden')
                $('.add_order').prop('disabled' , true);



                var data = this.user_shipping;

                let country = countries.find(el => el.iso2 == $('#select_country').val());
                let payment_method =  $("input[name='payment_method']:checked"). val();


                data['payment_method'] = $("input[name='payment_method']:checked"). val();
                data['company_id'] = $("input[name='shipping_company']:checked"). val();
                data['user_shipping_id'] =  $("input[name='addresses']:checked"). val();
                data['city'] = $('.select_city').val();
                data['phone_code'] = this.phone_code_user;
                data['lat'] = this.lat;
                data['lng'] = this.lng;




                if ($("input[name='payment_method']:checked"). val() == 2)
                {
                    data['card_name'] = this.card_name;
                    data['card_number'] = convertNumber(this.card_number) ;
                    data['card_month'] = this.card_month;
                    data['card_year'] = this.card_year;
                    data['card_cvv'] = convertNumber(this.card_cvv);
                }




                axios.post(get_url+'/add-order' , data).then(function (res) {

                    if(res.data['status']) {

                        get_cart_data_vue.count_products =0;
                        get_cart_data_vue.total_price = 0;

                        if(res.data['payment_url']) {
                            window.location = res.data['payment_url'];
                        }else {
                            $('.suc_alert').removeClass('hidden');
                            $('.suc_alert').text(res.data['message']);
                            $("html, body").animate({ scrollTop: 0 }, "slow");

                            setTimeout(function () {
                                window.location = get_url+"/compleate_payment?order_id="+res.data['order_id'];
                            } , 800);
                        }


                    }else {

                        $('.dan_alert').removeClass('hidden');
                        $('.suc_alert').addClass('hidden');
                        $('.dan_alert').html(res.data['message']);
                    }
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    $('.loader_btn_icon').css('display','none');
                    $('.loader_btn').attr('disabled', false);

                    $('#add_order_loader').addClass('hidden')
                    $('.add_order').prop('disabled' , false);


                    cart_data_vue.hide_loading();
                }).catch(function (err) {
                    $('#add_order_loader').addClass('hidden')
                    $('.add_order').prop('disabled' , false);


                    cart_data_vue.hide_loading();
                });


        },

        get_payment_method_id : function () {
            var value = this.payment_method;
            if (value == "bank") {
                return 3;
            } else if (value == "cash") {
                return 1;
            } else if (value == "visa") {
                return 2;
            }
        },
        show_loading: function () {
            $('.blockOverlay').removeClass('hidden');
            $('.blockMsg').removeClass('hidden');
            $('.show_empty_cart').addClass('hidden');

        },
        hide_loading: function () {
            $('.blockOverlay').addClass('hidden');
            $('.blockMsg').addClass('hidden');
        } ,
        get_round_number :function (price) {
            return get_round_number(price);
        },
        get_price_after_discount : function (product) {
            return get_round_number(product.price - product.discount_price);
        },
        get_total_price_after_discount : function (product) {
            return get_round_number(product.quantity * (product.price - product.discount_price));
        },

        check_extra_shipping: function (id) {
            let shipping_company = this.shipping_companies.find(el => el.id == id);
            if(shipping_company) {
                this.billing_national_address = shipping_company.billing_national_address;
                this.billing_building_number = shipping_company.billing_building_number;
                this.billing_postalcode_number = shipping_company.billing_postalcode_number;
                this.billing_unit_number = shipping_company.billing_unit_number;
                this.billing_extra_number = shipping_company.billing_extra_number;
            }
        },

        check_change_phone : function () {

            let phone =convertNumber( $('#phone_number').val());
            if( (1*phone) != this.confrim_phone.phone) {
                this.confrim_phone.steps = 1;

                $('.btn_verify').text('تحقق');
                $('.btn_verify').attr('disabled', false);
            }else {
                this.confrim_phone.steps = confirm_phone_data.steps;
            }
        },
        send_phone_code : function () {
        let data = {
            country_code : 'KW',
            phone : convertNumber( $('#phone_number').val()) ,
        };
        axios.post(get_url + "/send-order-phone-code", data).then(function (res) {
            if(res.data['status']) {
                cart_data_vue.confrim_phone.steps = res.data['data']['steps'];


                $('.model_api_data').text(res.data['message'] )
                $('.code_number').html( ' <span>'+res.data['data']['phone_code']+'</span>' +'-'+ res.data['data']['phone'])

            }else {
                $('.model_api_data').text(res.data['message'])
            }
        }).catch(function (err) {
        });
        },
        confirm_phone_code : function () {



            let data = {
                country_code :'KW',
                phone : convertNumber( $('#phone_number').val()) ,
                code :  convertNumber($('#confirm_code').val()),
            };
            axios.post(get_url + "/confirm-order-phone", data).then(function (res) {

                if(res.data['status']) {
                    cart_data_vue.confrim_phone.steps = res.data['data']['steps'];

                    $('#order_dt').modal('hide');
                    $('.btn_verify').text('تم التحقق');
                    $('.btn_verify').attr('disabled', true);
                }else {

                    $('#error_code').removeClass('hidden')
                    $('#error_code').text(res.data['message'])

                }
            }).catch(function (err) {
                cart_data_vue.confrim_phone.confirm_loading = false;
            });
        },

        change_payment_method:function () {
           var value =  $("input[name='payment_method']:checked").val();
           if(value == 1){
               $('.pay-form').addClass('hidden');
           }else {
               $('.pay-form').addClass('hidden');

               // $('.pay-form').removeClass('hidden');
           }

        }



    }
});

$(document).ready(function () {
    $('.pay-form').addClass('hidden')

    $('.select_country').change(function () {
        let country_code = $(this).val();
        if (country_code){
            let country = countries.find(el => el.iso2 == country_code);
            cart_data_vue.get_cities();
            cart_data_vue.phone_code = country.phone_code;

        }
    });

    $('.select_city').change(function () {
        cart_data_vue.user_shipping.city = $(this).val();
       cart_data_vue.get_shipping_companies();

    });
    $('.select_country').val('KW').trigger('change');







});