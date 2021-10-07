var vm = new Vue({
    el: '#app',
    data: {

        settings: {
            tax: tax.value,
            shipping: shipping.value ,
            first_order_discount : first_order_discount.value ,
            cancel_order_time : cancel_order_time.value,

            phone : phone.value ,
            email : email.value ,

            place_ar : place.value_ar,
            place_en : place.value_en,


            policy_ar : policy.value_ar,
            about_ar : about.value_ar,
            privacy_policy_ar : privacy_policy.value_ar,
            terms_ar : terms.value_ar,
            shipping_and_delivery_ar : shipping_and_delivery.value_ar ,

            policy_en : policy.value_en,
            about_en : about.value_en,
            privacy_policy_en : privacy_policy.value_en,
            terms_en : terms.value_en,
            shipping_and_delivery_en : shipping_and_delivery.value_en ,

            facebook : facebook.value ,
            twitter : twitter.value ,
            snapchat : snapchat.value ,
            instagram : instagram.value ,
            youtube : youtube.value ,
            telegram : telegram.value ,


            // cash_note_ar : cash_note.value_ar,
            // cash_note_en : cash_note.value_en,
            //
            // bank_note_ar : bank_note.value_ar,
            // bank_note_en : bank_note.value_en,
            //
            // visa_note_ar : visa_note.value_ar,
            // visa_note_en : visa_note.value_en,


            point_price : point_price.value ,
            package_discount_type : package_discount_type.value ,

            failed_order_bank_time : failed_order_bank_time.value ,

            price_tax_in_products : price_tax_in_products.value ,
            price_tax_in_cart : price_tax_in_cart.value ,

            product_details_note1 : product_details_note1.value ,
            product_details_note2 : product_details_note2.value ,
            product_details_note_image:product_details_note_image.value,

            close_app :close_app.status ,
            close_website :close_website.status ,
            close_website_text :close_website.value ,

            checkout_label_ar :checkout_label.value_ar ,
            checkout_label_en :checkout_label.value_en ,
            
            return_order_time : return_order_time.value ,

            note_discount_product_details : note_discount_product_details.value
        },

        msg: {
            success: '',
            error: ''
        },
        add: false,
        edit_id: '',
        loading: false,
        edit_row: '',


    },

    created: function () {

    },
    methods: {

        get_file: function (event, selector , attribute) {

            var file = event.target.files[0];

            if (file) {
                this.widget[attribute] = file;
                read_url(event.target, selector);
            } else {
                this.widget[attribute] = '';
            }

        },


        validateForm: function (event) {
            vm.$validator.validateAll().then(function (valid) {
                if (valid) {
                    vm.update_settings();

                }
            });
        },


        reset_validation: function () {
            vm.$validator.reset();
        },

        update_settings: function () {
            var formData = new FormData();

            this.settings.about_ar =  $('.about_ar').summernote('code');
            this.settings.policy_ar =  $('.policy_ar').summernote('code');
            this.settings.privacy_policy_ar =  $('.privacy_policy_ar').summernote('code');
            this.settings.terms_ar =  $('.terms_ar').summernote('code');
            this.settings.shipping_and_delivery_ar =  $('.shipping_and_delivery_ar').summernote('code');

            this.settings.about_en =  $('.about_en').summernote('code');
            this.settings.policy_en =  $('.policy_en').summernote('code');
            this.settings.privacy_policy_en =  $('.privacy_policy_en').summernote('code');
            this.settings.terms_en =  $('.terms_en').summernote('code');
            this.settings.shipping_and_delivery_en =  $('.shipping_and_delivery_en').summernote('code');

            this.loading = true;
            Object.keys(this.settings).forEach(function (key) {
                formData.append(key, vm.settings[key]);

            });

            formData.append('close_app', $('#close_app').is(":checked") ? 1 : 0);
            formData.append('close_website', $('#close_website').is(":checked") ? 1 : 0);

            formData.append('product_details_note_image', this.settings.product_details_note_image);

            axios.post(get_url + "/admin/settings/update", formData).then(function (res) {
                vm.loading = false;
                var get_res = handle_response(res.data);
                scroll_to_div('.m-dropdown__wrapper');
                if (get_res) {

                    setTimeout(function () {
                        $('.add_form').addClass('hidden');
                        $('.show_data').removeClass('hidden');
                    }, 1500);

                }

            }).catch(function (err) {
                vm.loading = false;
            });


        },


        get_file: function (event, selector , attribute) {

            var file = event.target.files[0];
            if (file) {
                this.settings[attribute] = file;
                read_url(event.target, selector);
            } else {
                this.settings[attribute] = '';
            }


        },


    },
    watch: {}
});

$(document).ready(function () {

    // init
    $('.about_ar').summernote('code',vm.settings.about_ar);
    $('.policy_ar').summernote('code',vm.settings.policy_ar);
    $('.privacy_policy_ar').summernote('code',vm.settings.privacy_policy_ar);
    $('.terms_ar').summernote('code',vm.settings.terms_ar);
    $('.shipping_and_delivery_ar').summernote('code',vm.settings.shipping_and_delivery_ar);

    $('.about_en').summernote('code',vm.settings.about_en);
    $('.policy_en').summernote('code',vm.settings.policy_en);
    $('.privacy_policy_en').summernote('code',vm.settings.privacy_policy_en);
    $('.terms_en').summernote('code',vm.settings.terms_en);
    $('.shipping_and_delivery_en').summernote('code',vm.settings.shipping_and_delivery_en);

    if(vm.settings.close_app == 1) {
        $('#close_app').prop('checked' , true);
    }else {
        $('#close_app').prop('checked' , false);
    }

    if(vm.settings.close_website == 1) {
        $('#close_website').prop('checked' , true);
    }else {
        $('#close_website').prop('checked' , false);
    }
});

