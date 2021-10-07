var vm = new Vue({
    el: '#app',
    data: {

        medicine_type: {
            name_en: '',
            name_ar: '',
            is_stripe : ''

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
                        vm.add_medicine_type();
                    } else {

                        vm.update_medicine_type();
                    }

                }
            });
        },

        empty_medicine_type: function () {
            this.add = true;
            var empty_medicine_type = {
                name_en: '',
                name_ar: '',
                is_stripe : ''


            };

            this.medicine_type = empty_medicine_type;
        },
        edit_medicine_type: function (medicine_type) {
            this.add = false;
            this.edit_id = medicine_type.id;
            this.medicine_type.name_en = medicine_type.name_en;
            this.medicine_type.name_ar = medicine_type.name_ar;
            this.medicine_type.type = medicine_type.type;


        },
        reset_validation: function () {
            vm.$validator.reset();
        },

        add_medicine_type: function () {
            var formData = new FormData();

            this.loading = true;
            Object.keys(this.medicine_type).forEach(function (key) {
                formData.append(key, vm.medicine_type[key]);
            });


            axios.post(get_url + "/admin/medicine-types/add", formData).then(function (res) {
                vm.loading = false;
                var get_res = handle_response(res.data);

                scroll_to_div('.m-dropdown__wrapper');
                if (get_res) {

                    setTimeout(function () {
                        $('.add_form').addClass('hidden');
                        $('.show_data').removeClass('hidden');
                    }, 1200);
                    table_medicine_type.ajax.reload();
                    vm.$validator.reset();
                }
            }).catch(function (err) {
                vm.loading = false;
            });


        },
        update_medicine_type: function () {
            var formData = new FormData();

            this.loading = true;
            Object.keys(this.medicine_type).forEach(function (key) {
                formData.append(key, vm.medicine_type[key]);
            });
            formData.append('id', this.edit_id);

            axios.post(get_url + "/admin/medicine-types/update", formData).then(function (res) {
                vm.loading = false;
                var get_res = handle_response(res.data);
                scroll_to_div('.m-dropdown__wrapper');
                if (get_res) {

                    setTimeout(function () {
                        $('.add_form').addClass('hidden');
                        $('.show_data').removeClass('hidden');
                    }, time_to_hide_success_msg);

                    table_medicine_type.ajax.reload();
                }
            }).catch(function (err) {
                vm.loading = false;
            });


        },
        delete_medicine_type: function (company) {
            axios.post(get_url + "/admin/medicine-types/delete",
                {
                    id: company.id
                }
            ).then(function (res) {

                var get_res = handle_response(res.data);
                if (get_res) {
                    swal(translations['success_delete'], translations['done_delete'], "success");
                    table_medicine_type.ajax.reload();
                }

            }).catch(function (err) {
                vm.loading = false;
            });

        },



    },
    watch: {

    }
});

$(document).ready(function () {

    // init

    $('#add_new_offer').click(function () {
        $('.add_form').removeClass('hidden');
        $('.show_data').addClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_medicine_type();
        vm.reset_validation();
        vm.medicine_type.is_stripe = $('#select_is_stripe').val();
    });
    $('#cancel').click(function () {
        $('.add_form').addClass('hidden');
        $('.show_data').removeClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_medicine_type();
        vm.reset_validation();
        $('#select_is_stripe').val('');
    });

    table_medicine_type.on('click', '.edit', function () {
        var row = $(this).closest('tr');
        if (row.attr('role') == undefined) {
            row = $(this).parent('tr'['role=row']);
        }

        var row_data = table_medicine_type.row(row).data();
        $('.add_form').removeClass('hidden');
        $('.show_data').addClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');

        vm.edit_medicine_type(row_data);
        $('#select_is_stripe').val(row_data.is_stripe).trigger('change');
    });
    table_medicine_type.on('click', '.delete', function () {
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
                vm.delete_medicine_type(table_medicine_type.row(row).data());
            } else {
                e.dismiss && swal(translations['cancelled_delete'], translations['didnt_delete'], "error")
            }

        });
    });




    $('#select_is_stripe').change(function () {
        vm.medicine_type.is_stripe = $(this).val();
    });
});

