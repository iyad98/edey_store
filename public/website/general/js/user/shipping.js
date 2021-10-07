var shipping = new Vue({
    el: '#shipping',
    data: {

        user_shipping: user_shipping,
        country_code : country_code,

        loading: false,
        success_msg: '',
        error_msg: '',

        shipping_companies : [],
        cities : [],

        billing_national_address : false ,
        billing_building_number : false ,
        billing_postalcode_number : false ,
        billing_unit_number : false ,
        billing_extra_number : false ,

    },
    created: function () {
    },
    methods: {
        update_shipping: function (address_id) {

            user_shipping.billing_shipping_type = $('.select_shipping_company').val();

            var data = this.user_shipping;
            data['phone'] =  convertNumber($('#phone_number').val()),

            this.loading = true;
            axios.post(get_url + "/update-shipping/"+address_id, data).then(function (res) {

                if (res.data['status']) {

                    var is_verified =  res.data['data'].is_verified;

                    if (is_verified == 1) {
                        $('.suc_alert').removeClass('hidden');
                        $('.dan_alert').addClass('hidden');
                        $('.suc_alert').text(res.data['message']);
                        scroll_to_div('#shipping');
                        shipping.loading = false;
                    }else {
                        $('.code_number').html( ' <span>'+res.data['data']['phone_code']+'</span>' +'-'+ res.data['data']['phone'])
                        $('#order_dt').modal('show');
                    }



                } else {

                    $('.dan_alert').removeClass('hidden');
                    $('.suc_alert').addClass('hidden');
                    $('.dan_alert').text(res.data['message']);


                }
                scroll_to_div('#shipping');
                shipping.loading = false;

            }).catch(function (err) {

            });
        },

        get_shipping_companies: function () {
            var city_id = $('.select_city').val();
            if (city_id == "") return;
            $('.select_shipping_company').empty();
            $('.select_shipping_company').prop('disabled', true);

            axios.get(get_source_url + "/api/shipping-companies/" + city_id, {
                headers: {
                    'Accept-Language': get_lang
                }
            }).then(function (res) {

                var shipping_companies = res.data['data'];

                shipping.shipping_companies = shipping_companies;



                shipping_companies.forEach(function (t) {
                    let selected = false;
                    if (shipping.user_shipping.billing_shipping_type == t.id) {
                        selected = true;
                        shipping.check_extra_shipping(t.id);
                    }
                    var newOption = new Option(t.name, t.id, selected, selected);
                    $('.select_shipping_company').append(newOption);
                });
                $('.select_shipping_company').prop('disabled', false);

            }).catch(function (err) {

            });
        },

        get_cities: function () {


            var country_id = $('.select_country').val();


            $('.select_city').empty();
            $('.select_city').prop('disabled', true);

            if (country_id == '-1'){
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

                shipping.payment_method_for_city = payment_method_for_city;

                // const defoult_payment_method = ['bank_transfer', 'cash', 'visa'];
                //
                // for ( const pay_method of  this.payment_method_for_city) {
                //     $('.'+pay_method.key).css('display' , 'inherit');
                // }

                shipping.cities = cities;

                cities.forEach(function (t) {
                    let selected = false;
                    var newOption = new Option(t.name, t.id, selected, selected);
                    $('.select_city').append(newOption);
                });

                let first_city_if_exists = cities.length > 0 ? cities[0].id : -1;
                let get_if_selected = cities.find(el => el.id == shipping.user_shipping.city);
                if(get_if_selected) {
                    $('.select_city').val(shipping.user_shipping.city).trigger('change');
                }else {
                    $('.select_city').val(first_city_if_exists).trigger('change');
                }

                // shipping.get_shipping_companies();

            }).catch(function (err) {
                console.log(err);
            });
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

        delete_address:function (address_id) {

            axios.post(get_url + "/delete-shipping", {address_id:address_id}).then(function (res) {

                if (res.data['status']) {

                    $('.suc_alert').removeClass('hidden');
                    $('.dan_alert').addClass('hidden');
                    $('.suc_alert').text(res.data['message']);

                    $('.shipping_class_'+address_id).addClass('hidden')


                } else {

                    $('.dan_alert').removeClass('hidden');
                    $('.suc_alert').addClass('hidden');
                    $('.dan_alert').text(res.data['message']);


                }
                scroll_to_div('#shipping');
                shipping.loading = false;

            }).catch(function (err) {

            });

        },
        confirm_shipping_address_code:function (address_id) {
            let data = {
                code :  convertNumber($('#confirm_code').val()),
                address_id :  address_id,
            };
            axios.post(get_url + "/confirm-shipping-address-code", data).then(function (res) {

                if(res.data['status']) {

                    $('#order_dt').modal('hide');
                    $('.btn_verify').text('تم التحقق');
                    $('.btn_verify').attr('disabled', true);
                }else {

                    $('#error_code').removeClass('hidden')
                    $('#error_code').text(res.data['message'])

                }
            }).catch(function (err) {
                $('#error_code').removeClass('hidden')
                $('#error_code').text('الكود خاطئ')

            });
        }
    }
});


$(document).ready(function () {




    $('.select_country').change(function () {
        let country_code = $(this).val();
        if (country_code){
            // let country = countries.find(el => el.iso2 == country_code);
            shipping.get_cities();
            // shipping.phone_code = country.phone_code;
        }

    });


    $('.select_city').change(function () {
        shipping.user_shipping.city = $(this).val();
        shipping.get_shipping_companies();
    });
    $('.select_country').val('KW').trigger('change');


});