var vm = new Vue({
    el: '#app',
    data: {

        settings: {
            cash_text_ar: cash.text_ar,
            visa_text_ar : visa.text_ar ,
            bank_transfer_text_ar : bank_transfer.text_ar ,

            cash_text_en: cash.text_en,
            visa_text_en : visa.text_en ,
            bank_transfer_text_en : bank_transfer.text_en ,

            shipping_order_ar : shipping_order.value_ar ,
            cancel_order_ar : cancel_order.value_ar ,
            failed_order_ar : failed_order.value_ar ,
            finished_order_ar : finished_order.value_ar ,
            order_in_the_warehouse_ar : order_in_the_warehouse.value_ar,


            shipping_order_en : shipping_order.value_en ,
            cancel_order_en : cancel_order.value_en ,
            failed_order_en : failed_order.value_en ,
            finished_order_en : finished_order.value_en ,
            order_in_the_warehouse_en : order_in_the_warehouse.value_en,


            sms_user_account : sms_user_account.value ,
            sms_user_pass : sms_user_pass.value ,
            sms_sender : sms_sender.value ,

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

            this.loading = true;
            Object.keys(this.settings).forEach(function (key) {
                formData.append(key, vm.settings[key]);
            });

            axios.post(get_url + "/admin/settings/messages/update", formData).then(function (res) {
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
        get_file: function (event, selector) {
            var file = event.target.files[0];
            if (file) {
                this.offer['image'] = file;
                read_url(event.target, selector);
            } else {
                this.offer['image'] = '';
            }

        },


    },
    watch: {}
});

$(document).ready(function () {

    // init
    $('.about').summernote('code',vm.settings.about);
    $('.policy').summernote('code',vm.settings.policy);

});

