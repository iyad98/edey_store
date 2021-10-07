var vm = new Vue({
    el: '#app',
    data: {

        payment: {
            name_ar: '',
            name_en: '',
            note_ar : '',
            note_en:'',
            image: ''

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
                    vm.update_payment();

                    // if (vm.add) {
                    //     vm.add_payment();
                    // } else {
                    //
                    //     vm.update_payment();
                    // }

                }
            });
        },
        empty_payment: function () {
            this.add = true;
            var empty_payment = {
                name_ar: '',
                name_en: '',
                image: '' ,
                account_number : '',
                iban : '',
            };

            this.payment = empty_payment;
        },
        edit_payment: function (data) {
            this.add = false;
            this.edit_id = data.id;
            this.payment.name_ar = data.name_ar;
            this.payment.name_en = data.name_en;
            this.payment.image = data.image;
            this.payment.note_ar = data.note_ar;
            this.payment.note_en = data.note_en;

        },
        reset_validation: function () {
            vm.$validator.reset();
        },

        update_payment: function () {
            var formData = new FormData();

            this.loading = true;
            Object.keys(this.payment).forEach(function (key) {
                formData.append(key, vm.payment[key]);
            });


            formData.append('id', this.edit_id);



            axios.post(get_url + "/admin/payment-methods/update", formData).then(function (res) {
                vm.loading = false;
                var get_res = handle_response(res.data);
                scroll_to_div('.m-dropdown__wrapper');
                if (get_res) {

                    setTimeout(function () {
                        $('.add_form').addClass('hidden');
                        $('.show_data').removeClass('hidden');
                    }, time_to_hide_success_msg);

                    table.ajax.reload(null, false);
                }
            }).catch(function (err) {
                vm.loading = false;
            });


        },

        get_file: function (event, selector ) {
            var file = event.target.files[0];
            if (file) {
                this.payment['image'] = file;
                read_url(event.target, selector);
            } else {
                this.payment['image'] = file;
            }
        },


        change_status: function (payment) {

            axios.post(get_url + "/admin/payment-methods/change-status",
                {
                    id: payment.id
                }
            ).then(function (res) {
                table.ajax.reload();
            }).catch(function (err) {
                vm.loading = false;
            });

        },


    },
    watch: {}
});

$(document).ready(function () {

    // init
    table.on('click', '.edit', function () {
        var row = $(this).closest('tr');
        if (row.attr('role') == undefined) {
            row = $(this).parent('tr'['role=row']);
        }

        var row_data = table.row(row).data();
        $('.add_form').removeClass('hidden');
        $('.show_data').addClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.edit_payment(row_data);
    });
    $('#cancel').click(function () {
        $('.add_form').addClass('hidden');
        $('.show_data').removeClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_payment();
        vm.reset_validation();
    });

    table.on('change', '.change_status', function () {
        var row = $(this).closest('tr');
        if(row.attr('role') == undefined) {
            row = $(this).parent('tr'['role=row']);
        }

        vm.edit_row = row;
        row.find('.loading').removeClass('hidden');
        row.find('.get_status').addClass('hidden');
        vm.change_status(table.row(row).data());
    });

});

