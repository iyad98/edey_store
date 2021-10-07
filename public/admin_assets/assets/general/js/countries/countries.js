var vm = new Vue({
    el: '#app',
    data: {
        country_ids : [],
        country: {
            name_ar: '',
            name_en: '',
            flag : ''
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
                        vm.add_country();
                    } else {

                        vm.update_country();
                    }

                }
            });
        },

        empty_country: function () {
            this.add = true;
            var empty_country = {
                name_ar: '',
                name_en: '',
                flag : '',
            };

            this.country = empty_country;
        },
        edit_country: function (data) {
            this.add = false;
            this.edit_id = data.id;
            this.country.name_ar = data.name_ar;
            this.country.name_en = data.name_en;
            this.country.flag = data.flag;


        },
        reset_validation: function () {
            vm.$validator.reset();
        },

        add_country: function () {
            var formData = new FormData();

            this.loading = true;
            Object.keys(this.country).forEach(function (key) {
                formData.append(key, vm.country[key]);
            });
            formData.append('country_id' ,$("#m_select_country_form").val() );

            axios.post(get_url + "/admin/countries/add", formData).then(function (res) {
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
        update_country: function () {
            var formData = new FormData();

            this.loading = true;
            Object.keys(this.country).forEach(function (key) {
                formData.append(key, vm.country[key]);
            });
            formData.append('id', this.edit_id);
            formData.append('country_id' ,$("#m_select_country_form").val() );
            formData.append('payment_methods', $("#m_select_payment_method_form").val());

            axios.post(get_url + "/admin/countries/update", formData).then(function (res) {
                vm.loading = false;
                var get_res = handle_response(res.data);
                scroll_to_div('.m-dropdown__wrapper');
                if (get_res) {

                    setTimeout(function () {
                        $('.add_form').addClass('hidden');
                        $('.show_data').removeClass('hidden');
                    }, time_to_hide_success_msg);

                    table.ajax.reload(null , false);
                }
            }).catch(function (err) {
                vm.loading = false;
            });


        },
        delete_country : function (category) {
            axios.post(get_url + "/admin/countries/delete",
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
                this.country['flag'] = file;
                read_url(event.target, selector);
            } else {
                this.country['flag'] = '';
            }

        },
        execute_option : function () {

            let country_ids = this.country_ids;
            let option = $('#select_order_option').val();

            var formData = new FormData();
            formData.append('country_ids' , JSON.stringify(country_ids));
            formData.append('option' , option);

            this.loading = true;
            axios.post(get_url+"/admin/countries/execute-option" ,formData).then(function (res) {

                vm.loading = false;
                if(res.data['status']) {
                    vm.country_ids = [];
                    swal(res.data['data']['title'], res.data['success_msg'], "success");
                }else {
                    swal(res.data['data']['title'], res.data['error_msg'], "error");
                }
                table.ajax.reload(null , false);
                $('#check_all').prop('checked', false);
            }).catch(function (err) {
                vm.loading = false;
            });
        }

    },
    watch: {

    }
});

$(document).ready(function () {

    // init
    $("#m_select_country_form").select2({placeholder: "اختار الدولة"});
    $("#m_select_payment_method_form").select2({placeholder: "اختار طرق الدفع"});

    /* $("#m_select_country_form").select2({placeholder: "Select a state"});
     $("#m_select_country_form").change(function () {
         vm.country.country_id = $(this).val();

     });
     $("#m_select_country_form2").select2({placeholder: "Select a state"});
     */
    /////
    $('#add_new_country').click(function () {
        $('.add_form').removeClass('hidden');
        $('.show_data').addClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_country();
        vm.reset_validation();
    });
    $('#cancel').click(function () {
        $('.add_form').addClass('hidden');
        $('.show_data').removeClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_country();
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

        vm.edit_country(row_data);
        let payment_method_ids = pluck_('id');
        let get_payment_method_ids = payment_method_ids(row_data.payment_methods);

        $("#m_select_payment_method_form").val(get_payment_method_ids).trigger('change');
        $("#m_select_country_form").val(row_data.country_id).trigger('change');
        //   $('#m_select_country_form').val(row_data.country_id).trigger('change');
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
                vm.delete_country(table.row(row).data());
            } else {
                e.dismiss && swal(translations['cancelled_delete'], translations['didnt_delete'], "error")
            }

        });
    });



});

