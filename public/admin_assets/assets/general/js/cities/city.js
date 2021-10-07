var vm = new Vue({
    el: '#app',
    data: {
        city_ids : [],

        city: {
            name_ar: '',
            name_en: '',
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
                        vm.add_city();
                    } else {

                        vm.update_city();
                    }

                }
            });
        },

        empty_city: function () {
            this.add = true;
            var empty_city = {
                name_ar: '',
                name_en: '',
            };

            this.city = empty_city;
        },
        edit_city: function (data) {
            this.add = false;
            this.edit_id = data.id;
            this.city.name_ar = data.name_ar;
            this.city.name_en = data.name_en;


        },
        reset_validation: function () {
            vm.$validator.reset();
        },

        add_city: function () {
            var formData = new FormData();

            this.loading = true;
            Object.keys(this.city).forEach(function (key) {
                formData.append(key, vm.city[key]);
            });
            formData.append('country_id' ,$("#m_select_country_form").val() );

            axios.post(get_url + "/admin/cities/add", formData).then(function (res) {
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
        update_city: function () {
            var formData = new FormData();

            this.loading = true;
            Object.keys(this.city).forEach(function (key) {
                formData.append(key, vm.city[key]);
            });
            formData.append('id', this.edit_id);
            formData.append('country_id' ,$("#m_select_country_form").val() );

            axios.post(get_url + "/admin/cities/update", formData).then(function (res) {
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
        delete_city : function (category) {
            axios.post(get_url + "/admin/cities/delete",
                {
                    id: category.id
                }
            ).then(function (res) {

                var get_res = handle_response(res.data);
                if (get_res) {
                    swal(translations['success_delete'], translations['done_delete'], "success");
                    table.ajax.reload();
                }else {
                    swal("خطأ", res.data['error_msg'], "error");
                }

            }).catch(function (err) {
                vm.loading = false;
            });

        },
        get_file: function (event, selector) {
            var file = event.target.files[0];
            if (file) {
                this.city['image'] = file;
                read_url(event.target, selector);
            } else {
                this.city['image'] = '';
            }

        },
        execute_option : function () {

            let city_ids = this.city_ids;
            let option = $('#select_order_option').val();

            var formData = new FormData();
            formData.append('city_ids' , JSON.stringify(city_ids));
            formData.append('option' , option);

            this.loading = true;
            axios.post(get_url+"/admin/cities/execute-option" ,formData).then(function (res) {

                vm.loading = false;
                if(res.data['status']) {
                    vm.city_ids = [];
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

    /* $("#m_select_country_form").select2({placeholder: "Select a state"});
     $("#m_select_country_form").change(function () {
         vm.city.country_id = $(this).val();

     });
     $("#m_select_country_form2").select2({placeholder: "Select a state"});
     */
    /////
    $('#add_new_city').click(function () {
        $('.add_form').removeClass('hidden');
        $('.show_data').addClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_city();
        vm.reset_validation();
    });
    $('#cancel').click(function () {
        $('.add_form').addClass('hidden');
        $('.show_data').removeClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_city();
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

        vm.edit_city(row_data);
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
                vm.delete_city(table.row(row).data());
            } else {
                e.dismiss && swal(translations['cancelled_delete'], translations['didnt_delete'], "error")
            }

        });
    });



});

