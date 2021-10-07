var vm = new Vue({
    el: '#app',
    data: {

        company: {
            name_en: '',
            name_ar: '',
            type : ''

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
                        vm.add_company();
                    } else {

                        vm.update_company();
                    }

                }
            });
        },

        empty_company: function () {
            this.add = true;
            var empty_company = {
                name_en: '',
                name_ar: '',
                type : '',


            };

            this.company = empty_company;
        },
        edit_company: function (company) {
            this.add = false;
            this.edit_id = company.id;
            this.company.name_en = company.name_en;
            this.company.name_ar = company.name_ar;
            this.company.type = company.type;


        },
        reset_validation: function () {
            vm.$validator.reset();
        },

        add_company: function () {
            var formData = new FormData();

            this.loading = true;
            Object.keys(this.company).forEach(function (key) {
                formData.append(key, vm.company[key]);
            });


            axios.post(get_url + "/admin/companies/add", formData).then(function (res) {
                vm.loading = false;
                var get_res = handle_response(res.data);

                scroll_to_div('.m-dropdown__wrapper');
                if (get_res) {

                    setTimeout(function () {
                        $('.add_form').addClass('hidden');
                        $('.show_data').removeClass('hidden');
                    }, 1200);
                    table_company.ajax.reload();
                    vm.$validator.reset();
                }
            }).catch(function (err) {
                vm.loading = false;
            });


        },
        update_company: function () {
            var formData = new FormData();

            this.loading = true;
            Object.keys(this.company).forEach(function (key) {
                formData.append(key, vm.company[key]);
            });
            formData.append('id', this.edit_id);

            axios.post(get_url + "/admin/companies/update", formData).then(function (res) {
                vm.loading = false;
                var get_res = handle_response(res.data);
                scroll_to_div('.m-dropdown__wrapper');
                if (get_res) {

                    setTimeout(function () {
                        $('.add_form').addClass('hidden');
                        $('.show_data').removeClass('hidden');
                    }, time_to_hide_success_msg);

                    table_company.ajax.reload();
                }
            }).catch(function (err) {
                vm.loading = false;
            });


        },
        delete_company: function (company) {
            axios.post(get_url + "/admin/companies/delete",
                {
                    id: company.id
                }
            ).then(function (res) {

                var get_res = handle_response(res.data);
                if (get_res) {
                    swal(translations['success_delete'], translations['done_delete'], "success");
                    table_company.ajax.reload();
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
        vm.empty_company();
        vm.reset_validation();
        vm.company.type = $('#select_company_type').val();
    });
    $('#cancel').click(function () {
        $('.add_form').addClass('hidden');
        $('.show_data').removeClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_company();
        vm.reset_validation();
        $('#select_company_type').val('');
    });

    table_company.on('click', '.edit', function () {
        var row = $(this).closest('tr');
        if (row.attr('role') == undefined) {
            row = $(this).parent('tr'['role=row']);
        }

        var row_data = table_company.row(row).data();
        $('.add_form').removeClass('hidden');
        $('.show_data').addClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');

        vm.edit_company(row_data);
        $('#select_company_type').val(row_data.type).trigger('change');
    });
    table_company.on('click', '.delete', function () {
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
                vm.delete_company(table_company.row(row).data());
            } else {
                e.dismiss && swal(translations['cancelled_delete'], translations['didnt_delete'], "error")
            }

        });
    });




    $('#select_company_type').change(function () {
        vm.company.type = $(this).val();
    });
});

