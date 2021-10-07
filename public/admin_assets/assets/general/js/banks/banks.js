var vm = new Vue({
    el: '#app',
    data: {

        bank: {
            name_ar: '',
            name_en: '',
            account_number : '',
            iban:'',
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
                    if (vm.add) {
                        vm.add_bank();
                    } else {

                        vm.update_bank();
                    }

                }
            });
        },

        empty_bank: function () {
            this.add = true;
            var empty_bank = {
                name_ar: '',
                name_en: '',
                image: '' ,
                account_number : '',
                iban : '',
            };

            this.bank = empty_bank;
        },
        edit_bank: function (data) {
            this.add = false;
            this.edit_id = data.id;
            this.bank.name_ar = data.name_ar;
            this.bank.name_en = data.name_en;
            this.bank.image = data.image;
            this.bank.iban = data.iban;
            this.bank.account_number = data.account_number;

        },
        reset_validation: function () {
            vm.$validator.reset();
        },

        add_bank: function () {
            var formData = new FormData();

            this.loading = true;
            
            Object.keys(this.bank).forEach(function (key) {
                formData.append(key, vm.bank[key]);
            });
            
            axios.post(get_url + "/admin/banks/add", formData).then(function (res) {
                vm.loading = false;
                var get_res = handle_response(res.data);

                scroll_to_div('.m-dropdown__wrapper');
                if (get_res) {

                    setTimeout(function () {
                        $('.add_form').addClass('hidden');
                        $('.show_data').removeClass('hidden');
                    }, 1200);
                    table.ajax.reload();
                    vm.$validator.reset();
                }
            }).catch(function (err) {
                vm.loading = false;
            });


        },
        update_bank: function () {
            var formData = new FormData();

            this.loading = true;


            Object.keys(this.bank).forEach(function (key) {
                formData.append(key, vm.bank[key]);
            });
            formData.append('id', this.edit_id);

            axios.post(get_url + "/admin/banks/update", formData).then(function (res) {
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
        delete_bank: function (category) {
            axios.post(get_url + "/admin/banks/delete",
                {
                    id: category.id
                }
            ).then(function (res) {

                var get_res = handle_response(res.data);
                if (get_res) {
                    swal(translations['success_delete'], translations['done_delete'], "success");
                    table.ajax.reload();
                }

            }).catch(function (err) {
                vm.loading = false;
            });

        },
        get_file: function (event, selector) {
            var file = event.target.files[0];
            if (file) {
                this.bank['image'] = file;
                read_url(event.target, selector);
            } else {
                this.bank['image'] = '';
            }

        }


    },
    watch: {}
});

$(document).ready(function () {

    // init


    /////
    $('#add_new_bank').click(function () {
        $('.add_form').removeClass('hidden');
        $('.show_data').addClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_bank();
        vm.reset_validation();
    });
    $('#cancel').click(function () {
        $('.add_form').addClass('hidden');
        $('.show_data').removeClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_bank();
        vm.reset_validation();
    });

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
        vm.edit_bank(row_data);
    });
    table.on('click', '.delete', function () {
        var row = $(this).closest('tr');
        if (row.attr('role') == undefined) {
            row = $(this).parent('tr'['role=row']);
        }
        vm.edit_row = row;
        swal({
            title: translations['sure_delete'],
            text: "",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: translations['yes_delete'],
            cancelButtonText: translations['no_delete'],
            reverseButtons: !0
        }).then(function (e) {
            if (e.value) {
                vm.delete_bank(table.row(row).data());
            } else {
                e.dismiss && swal(translations['cancelled_delete'], translations['didnt_delete'], "error")
            }

        });
    });


});

