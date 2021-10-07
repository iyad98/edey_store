function get_countries_as_array(countries) {
    var country_ids = [];
    countries.forEach(function (t) {
        country_ids.push(t.id);
    });
    return country_ids;
}


var vm = new Vue({
    el: '#app',
    data: {

        shipping_company: {
            name_ar: '',
            name_en: '',
            image: '',
            image_web: '',
            cash_value: '',
            phone: '',
            tracking_url: '',
            accept_user_shipping_address: '',
            note:'',
        },
        select_countries : [] ,
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
                        vm.add_shipping_company();
                    } else {

                        vm.update_shipping_company();
                    }

                }
            });
        },

        empty_shipping_company: function () {
            this.add = true;
            var empty_shipping_company = {
                name_ar: '',
                name_en: '',
                image: '',
                image_web:'',
                cash_value: '',
            };

            this.shipping_company = empty_shipping_company;
        },
        edit_shipping_company: function (data) {
            this.add = false;
            this.edit_id = data.id;
            this.shipping_company.name_ar = data.name_ar;
            this.shipping_company.name_en = data.name_en;
            this.shipping_company.cash_value = data.cash_value;
            this.shipping_company.phone = data.phone;
            this.shipping_company.tracking_url = data.tracking_url;
            this.shipping_company.accept_user_shipping_address = data.accept_user_shipping_address;
            this.shipping_company.note = data.note;

            this.shipping_company.image = data.image;
            this.shipping_company.image_web = data.image_web;



        },
        reset_validation: function () {
            vm.$validator.reset();
        },

        add_shipping_company: function () {

            var formData = new FormData();

            this.loading = true;


            vm.shipping_company.shipping_company_type_id = $('#select_type_form').val();
            Object.keys(this.shipping_company).forEach(function (key) {
                formData.append(key, vm.shipping_company[key]);
            });
            formData.append('shipping_countries', $("#m_select_country_form").val());

            formData.append('billing_national_address', $('#billing_national_address').is(':checked') ? 1 : 0);
            formData.append('billing_building_number', $('#billing_building_number').is(':checked') ? 1 : 0);
            formData.append('billing_postalcode_number', $('#billing_postalcode_number').is(':checked') ? 1 : 0);
            formData.append('billing_unit_number', $('#billing_unit_number').is(':checked') ? 1 : 0);
            formData.append('billing_extra_number', $('#billing_extra_number').is(':checked') ? 1 : 0);


            axios.post(get_url + "/admin/shipping-companies/add", formData).then(function (res) {
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
        update_shipping_company: function () {
            var formData = new FormData();

            var shipping_prices = this.shipping_prices;
            var shipping_cash_prices = this.shipping_cash_prices;
console.log(this.shipping_company);
            this.loading = true;
            vm.shipping_company.shipping_company_type_id = $('#select_type_form').val();
            Object.keys(this.shipping_company).forEach(function (key) {
                formData.append(key, vm.shipping_company[key]);
            });

            formData.append('id', this.edit_id);
            formData.append('shipping_countries', $("#m_select_country_form").val());

            formData.append('billing_national_address', $('#billing_national_address').is(':checked') ? 1 : 0);
            formData.append('billing_building_number', $('#billing_building_number').is(':checked') ? 1 : 0);
            formData.append('billing_postalcode_number', $('#billing_postalcode_number').is(':checked') ? 1 : 0);
            formData.append('billing_unit_number', $('#billing_unit_number').is(':checked') ? 1 : 0);
            formData.append('billing_extra_number', $('#billing_extra_number').is(':checked') ? 1 : 0);


            axios.post(get_url + "/admin/shipping-companies/update", formData).then(function (res) {
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
        delete_shipping_company: function (category) {
            axios.post(get_url + "/admin/shipping-companies/delete",
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
                    return false;
                }

            }).catch(function (err) {
                vm.loading = false;
            });

        },
        change_status_for_user: function (shipping) {

            axios.post(get_url + "/admin/shipping-companies/change-status-for-user",
                {
                    id: shipping.id
                }
            ).then(function (res) {
                table.ajax.reload();
            }).catch(function (err) {
                vm.loading = false;
            });

        },
        get_file: function (event, selector) {
            var file = event.target.files[0];
            if (file) {
                this.shipping_company[selector] = file;

                read_url(event.target, '#'+selector);
            } else {
                this.shipping_company[selector] = '';
            }

        },

        // shipping price


    },
    watch: {}
});

$(document).ready(function () {

    ///////////////////////// init ////////////////////////////////

    $("#m_select_country_form").select2({placeholder: "اختار الدولة"});
    $("#m_select_country_form2").select2({placeholder: "اختار الدولة"});

    ///////////////////////////////////////////////////////////////

    $('#add_new_shipping_company').click(function () {
        $('.add_form').removeClass('hidden');
        $('.show_data').addClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_shipping_company();
        vm.reset_validation();

        $("#m_select_country_form").val([]).trigger('change');
        $('#billing_national_address').prop('checked' , false);
        $('#billing_building_number').prop('checked' , false);
        $('#billing_postalcode_number').prop('checked' , false);
        $('#billing_unit_number').prop('checked' , false);
        $('#billing_extra_number').prop('checked' , false);

    });
    $('#cancel').click(function () {
        $('.add_form').addClass('hidden');
        $('.show_data').removeClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_shipping_company();
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
        vm.edit_shipping_company(row_data);

        var get_countries = get_countries_as_array(row_data.countries);
        $("#m_select_country_form").val(get_countries).trigger('change');
        /////////////////////////

        $('#billing_national_address').prop('checked' , row_data.billing_national_address == 1);
        $('#billing_building_number').prop('checked' , row_data.billing_building_number == 1);
        $('#billing_postalcode_number').prop('checked' , row_data.billing_postalcode_number == 1);
        $('#billing_unit_number').prop('checked' , row_data.billing_unit_number == 1);
        $('#billing_extra_number').prop('checked' , row_data.billing_extra_number == 1);

        //
        //
    });
    table.on('click', '.show_countries', function () {

        var row = $(this).closest('tr');
        if (row.attr('role') == undefined) {
            row = $(this).parent('tr'['role=row']);
        }

        var row_data = table.row(row).data();
        vm.shipping_company.name_ar = row_data.name_ar;
        vm.select_countries = row_data.countries;
        $('#m_modal_1').modal('show');
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
                vm.delete_shipping_company(table.row(row).data());
            } else {
                e.dismiss && swal(translations['cancelled_delete'], translations['didnt_delete'], "error")
            }

        });
    });


    table.on('change', '.change_status', function () {
        var row = $(this).closest('tr');
        if(row.attr('role') == undefined) {
            row = $(this).parent('tr'['role=row']);
        }

        vm.edit_row = row;
        row.find('.loading').removeClass('hidden');
        row.find('.get_status').addClass('hidden');
        vm.change_status_for_user(table.row(row).data());
    });
});

