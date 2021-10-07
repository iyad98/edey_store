var vm = new Vue({
    el: '#app',
    data: {

        package: {
            name_ar: '',
            name_en: '',
            price_from : '',
            price_to:'',
            discount_rate : '',
            replace_hours : '',
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
                        vm.add_package();
                    } else {

                        vm.update_package();
                    }

                }
            });
        },

        empty_package: function () {
            this.add = true;
            var empty_package = {
                name_ar: '',
                name_en: '',
                price_from : '',
                price_to:'',
                discount_rate : '',
                replace_hours : '',
                image: ''
            };

            this.package = empty_package;
        },
        edit_package: function (data) {
            this.add = false;
            this.edit_id = data.id;
            this.package.name_ar = data.name_ar;
            this.package.name_en = data.name_en;
            this.package.image = data.image;
            this.package.price_from = data.price_from;
            this.package.price_to = data.price_to;
            this.package.discount_rate = data.discount_rate;
            this.package.replace_hours = data.replace_hours;

        },
        reset_validation: function () {
            vm.$validator.reset();
        },

        add_package: function () {
            var formData = new FormData();

            this.loading = true;
            var free_shipping = 0;
            if ($('#free_shipping').is(':checked')) {
                free_shipping = 1;
            }
            Object.keys(this.package).forEach(function (key) {
                formData.append(key, vm.package[key]);
            });

            formData.append('free_shipping', free_shipping);
            axios.post(get_url + "/admin/packages", formData).then(function (res) {
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
        update_package: function () {
            var formData = new FormData();

            this.loading = true;
            var free_shipping = 0;
            if ($('#free_shipping').is(':checked')) {
                free_shipping = 1;
            }

            Object.keys(this.package).forEach(function (key) {
                formData.append(key, vm.package[key]);
            });
            formData.append('id', this.edit_id);
            formData.append('_method', "PUT");
            formData.append('free_shipping', free_shipping);

            axios.post(get_url + "/admin/packages/"+this.edit_id, formData).then(function (res) {

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
        delete_package: function (category) {
            axios.delete(get_url + "/admin/packages/"+category.id).then(function (res) {

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
                this.package['image'] = file;
                read_url(event.target, selector);
            } else {
                this.package['image'] = '';
            }

        }


    },
    watch: {}
});

$(document).ready(function () {

    // init


    /////
    $('#add_new_package').click(function () {
        $('.add_form').removeClass('hidden');
        $('.show_data').addClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_package();
        vm.reset_validation();
    });
    $('#cancel').click(function () {
        $('.add_form').addClass('hidden');
        $('.show_data').removeClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_package();
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
        vm.edit_package(row_data);
        if (row_data.free_shipping) {
            $('#free_shipping').prop('checked', true);
        } else {
            $('#free_shipping').prop('checked', false);
        }
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
                vm.delete_package(table.row(row).data());
            } else {
                e.dismiss && swal(translations['cancelled_delete'], translations['didnt_delete'], "error")
            }

        });
    });


});

