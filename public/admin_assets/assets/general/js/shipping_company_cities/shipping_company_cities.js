function  declare_select2() {
    $("#m_select_city_form").select2({
        placeholder: "اختار المدينة",
        closeOnSelect: false,
        allowClear:true,
        multiple:true,
        scrollAfterSelect:true,
    });
}
function get_cities_as_array(cities) {
    var city_ids = [];
    city_ids.push(cities.id);
    return city_ids;
}

function set_shipping_company_prices(shipping_company_prices) {
    var prices = [];
    vm.shipping_prices = [];
    shipping_company_prices.forEach(function (t) {
        prices.push({
            name_en : t.name_en ,name_ar : t.name_ar ,from: t.from, to: t.to, price: t.price, type: t.type
        });
    });
    vm.shipping_prices = prices;
}

function set_shipping_company_piece(shipping_company_prices) {
    var prices = [];
    vm.shipping_prices_piece = [];
    shipping_company_prices.forEach(function (t) {
        prices.push({
            name_en : t.name_en ,name_ar : t.name_ar ,from: t.from, to: t.to, price: t.price, type: t.type
        });
    });
    vm.shipping_prices_piece = prices;
}
function set_shipping_company_cash_prices(shipping_company_cash_prices) {
    var prices = [];
    vm.shipping_cash_prices = [];
    shipping_company_cash_prices.forEach(function (t) {
        prices.push({
            from: t.from, to: t.to, price: t.price, type: t.type
        });
    });
    vm.shipping_cash_prices = prices;
}


var vm = new Vue({
    el: '#app',
    data: {
        shipping_city_ids : [],

        cities : cities ,
        city_ids_not_in_shipping_company : city_ids_not_in_shipping_company ,

        shipping_prices: [
            {name_en : '' ,name_ar : '' ,from: '', to: '', price: '', type: 'fixed'}
        ],
        shipping_prices_piece: [{name_en : '' ,name_ar : '' ,from: '1', to: '1', price: '', type: 'perpiece'}],
        shipping_cash_prices: [
            {from: '', to: '', price: '', type: 'fixed'}
        ],
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
                cash_value: '',
            };

            this.shipping_company = empty_shipping_company;
        },
        edit_shipping_company: function (data) {
            this.add = false;
            this.edit_id = data.id;



        },
        reset_validation: function () {
            vm.$validator.reset();
        },

        add_shipping_company: function () {

            var formData = new FormData();

            this.loading = true;
            var shipping_prices = this.shipping_prices;
            var  shipping_prices_piece = this.shipping_prices_piece;

            var shipping_cash_prices = this.shipping_cash_prices;

            var calculation_type  = $("input[name='calculation_type']:checked").val();

            console.log(calculation_type);
            vm.shipping_company.shipping_company_type_id = $('#select_type_form').val();
            formData.append('shipping_company_country_id', $("#get_shipping_company_country_id").val());

            formData.append('shipping_city', $("input[name='shipping_city']:checked").val());
            formData.append('shipping_cities', $("#m_select_city_form").val());

            formData.append('cash', $("input[name='cash']:checked").val());
            formData.append('calculation_type', calculation_type);

            if (calculation_type == 'piece'){
                formData.append('prices', JSON.stringify(shipping_prices_piece));
            }else {
                formData.append('prices', JSON.stringify(shipping_prices));
            }

            formData.append('cash_prices', JSON.stringify(shipping_cash_prices));

            axios.post(get_url + "/admin/shipping-company-cities/add", formData).then(function (res) {
                vm.loading = false;
                var get_res = handle_response(res.data);

                scroll_to_div('.m-dropdown__wrapper');
                if (get_res) {


                    vm.city_ids_not_in_shipping_company = res.data['data']['city_ids_not_in_shipping_company'];
                    setTimeout(function () {
                        $('.add_form').addClass('hidden');
                        $('.show_data').removeClass('hidden');
                    }, 1200);
                    table.ajax.reload();
                    vm.$validator.reset();
                    vm.$nextTick(function () {
                        declare_select2();
                    });
                }

            }).catch(function (err) {
                vm.loading = false;
            });


        },
        update_shipping_company: function () {
            var formData = new FormData();

            var shipping_prices = this.shipping_prices;
            var  shipping_prices_piece = this.shipping_prices_piece;
            var shipping_cash_prices = this.shipping_cash_prices;
            var calculation_type  = $("input[name='calculation_type']:checked").val();

            this.loading = true;
            formData.append('cash', $("input[name='cash']:checked").val());
            formData.append('calculation_type', calculation_type);

            if (calculation_type == 'piece'){
                formData.append('prices', JSON.stringify(shipping_prices_piece));
            }else {
                formData.append('prices', JSON.stringify(shipping_prices));
            }
            formData.append('cash_prices', JSON.stringify(shipping_cash_prices));


            formData.append('id', this.edit_id);

            axios.post(get_url + "/admin/shipping-company-cities/update", formData).then(function (res) {
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

            axios.post(get_url + "/admin/shipping-company-cities/delete",
                {
                    id: category.id
                }
            ).then(function (res) {

                var get_res = handle_response(res.data);
                if (get_res) {
                    vm.city_ids_not_in_shipping_company = res.data['data']['city_ids_not_in_shipping_company'];
                    swal(translations['success_delete'], translations['done_delete'], "success");
                    table.ajax.reload();

                    vm.$nextTick(function () {
                        declare_select2();
                    });

                }else {
                    swal("خطأ", res.data['error_msg'], "error");
                    return false;
                }

            }).catch(function (err) {
                vm.loading = false;
            });

        },
        get_file: function (event, selector) {
            var file = event.target.files[0];
            if (file) {
                this.shipping_company['image'] = file;
                read_url(event.target, selector);
            } else {
                this.shipping_company['image'] = '';
            }

        },

        // shipping price
        add_new_row: function () {
            this.shipping_prices.push(
                {from: '', to: '', price: '', type: 'fixed'}
            );

        },
        add_new_shipping_cash_price_row: function () {
            this.shipping_cash_prices.push(
                {from: '', to: '', price: '', type: 'fixed'}
            );
        },
        remove_row: function (index) {
            this.shipping_prices.splice(index, 1);
        },
        remove_shipping_cash_price_row: function (index) {
            this.shipping_cash_prices.splice(index, 1);
        },

        // execute_option
        execute_option : function () {

            let shipping_city_ids = this.shipping_city_ids;
            let option = $('#select_order_option').val();

            var formData = new FormData();
            formData.append('shipping_city_ids' , JSON.stringify(shipping_city_ids));
            formData.append('option' , option);

            this.loading = true;
            axios.post(get_url+"/admin/update-shipping-company-cities/execute-option" ,formData).then(function (res) {

                vm.loading = false;
                if(res.data['status']) {
                    vm.shipping_city_ids = [];
                    $('#check_all').prop('checked', false);
                    table.ajax.reload(null, false);
                    swal(res.data['data']['title'], res.data['success_msg'], "success");
                }else {
                    swal(res.data['data']['title'], res.data['error_msg'], "error");
                }



            }).catch(function (err) {
                vm.loading = false;
            });
        }

    },
    watch: {}
});

$(document).ready(function () {


    ///////////////////////// init ////////////////////////////////
    declare_select2();
    $("#m_select_city_form2").select2({placeholder: "اختار المدينة"});

    ///////////////////////////////////////////////////////////////

    $('#add_new_shipping_company').click(function () {
        $('.add_form').removeClass('hidden');
        $('.show_data').addClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_shipping_company();
        vm.reset_validation();

        vm.shipping_prices = [{from: '', to: '', price: '', type: 'fixed'}];
        vm.shipping_cash_prices = [{from: '', to: '', price: '', type: 'fixed'}];

        $("input[name=shipping_city][value=" + 1 + "]").prop('checked', true);
        $("input[name=cash][value=" + 1 + "]").prop('checked', true);
        $("#m_select_city_form").val(null).trigger('change');
        $('.select_shipping_company_cities').addClass('hidden');
        $('.shipping_cash_value').removeClass('hidden');

        $('#m_select_city_form').prop('disabled' , false);


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

        var get_cities = get_cities_as_array(row_data.city);

        set_shipping_company_cash_prices(row_data.shipping_company_cash_prices);
        $('#m_select_city_form').val(get_cities).trigger('change');

        if (row_data.cash == 1) {
            $("input[name=cash][value=" + 1 + "]").prop('checked', true);
            $('.shipping_cash_value').removeClass('hidden');
        } else {
            $("input[name=cash][value=" + 2 + "]").prop('checked', true);
            $('.shipping_cash_value').addClass('hidden');
        }

        if (row_data.calculation_type == 'piece') {
            set_shipping_company_piece(row_data.shipping_company_prices);

            $("input[name=calculation_type][value=" + 'piece' + "]").prop('checked', true);
            $('.shipping_price_value').addClass('hidden');
            $('.add_new_row').addClass('hidden');

        } else {
            set_shipping_company_prices(row_data.shipping_company_prices);

            $("input[name=calculation_type][value=" + 'price' + "]").prop('checked', true);
            $('.shipping_piece_value').addClass('hidden');
            $('.add_new_row').removeClass('hidden');

        }

        $('#m_select_city_form').prop('disabled' , true);
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
                e.dismiss && swal(translations['cancelled_delete'], translations['didnt_delete'], "info")
            }

        });
    });


    /*********** actions ****************/
    $("input[name='shipping_city']").change(function () {

        var value = $(this).val();
        if (value == 1) {
            $("#m_select_city_form").val(null).trigger('change');
            $('.select_shipping_company_cities').addClass('hidden');
        } else {
            $('.select_shipping_company_cities').removeClass('hidden');
        }

    });
    $("input[name='cash']").change(function () {
        var value = $(this).val();
        if (value == 1) {
            $('.shipping_cash_value').removeClass('hidden');
        } else {
            $('.shipping_cash_value').addClass('hidden');
        }

    });
    $('.shipping_piece_value').removeClass('hidden');
    $('.shipping_price_value').addClass('hidden');
    $('.add_new_row').addClass('hidden');
    $("input[name='calculation_type']").change(function () {
        var value = $(this).val();
        if (value == 'piece') {
            $('.shipping_piece_value').removeClass('hidden');
            $('.shipping_price_value').addClass('hidden');
            $('.add_new_row').addClass('hidden');


        } else {
            $('.shipping_piece_value').addClass('hidden');
            $('.shipping_price_value').removeClass('hidden');
            $('.add_new_row').removeClass('hidden');


        }

    });
});

