function set_prodcuts(products) {

    products.forEach(function (t) {
        $('#m_select_remote_product_name').append(new Option(t.name, t.id, true, true));

    });

}

function set_excluded_producs(products) {
    products.forEach(function (t) {
        $('#m_select_remote_excluded_product_name').append(new Option(t.name, t.id, true, true));

    });
}

function set_categoires(categoires) {
    categoires.forEach(function (t) {
        $('#m_select_remote_category_name').append(new Option(t.name, t.id, true, true));

    });
}

function set_excluded_categoires(categoires) {
    categoires.forEach(function (t) {
        $('#m_select_remote_excluded_category_name').append(new Option(t.name, t.id, true, true));

    });
}

var vm = new Vue({
    el: '#app',
    data: {

        coupon_types: coupon_types,
        coupon: {
            coupon: '',
            value: '',
            min_price: 0,
            max_used: 1000000,
            start_at: '',
            end_at: '',
            user_famous_rate : '',

        },
        free_shipping_coupon : true,
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
                        vm.add_coupon();
                    } else {

                        vm.update_coupon();
                    }

                }
            });
        },

        empty_coupon: function () {
            this.add = true;
            var empty_coupon = {
                coupon: '',
                value: '',
                min_price: 0,
                max_used: 1000000,
                start_at: '',
                end_at: '' ,
                user_famous_rate : '',

            };

            this.coupon = empty_coupon;
        },
        edit_coupon: function (coupon) {
            this.add = false;
            this.edit_id = coupon.id;
            this.coupon.coupon = coupon.coupon;
            this.coupon.value = coupon.value
            this.coupon.max_used = coupon.max_used;
            this.coupon.min_price = coupon.min_price
            this.coupon.start_at = coupon.start_at_edit;
            this.coupon.end_at = coupon.end_at_edit;
            this.coupon.user_famous_rate = coupon.user_famous_rate;
        },
        reset_validation: function () {
            vm.$validator.reset();
        },

        add_coupon: function () {
            var formData = new FormData();

            this.loading = true;
            Object.keys(this.coupon).forEach(function (key) {
                formData.append(key, vm.coupon[key]);
            });

            var is_automatic = 0;
            if ($('#is_automatic').is(':checked')) {
                is_automatic = 1;
            }

            var show_in_home = 0;
            if ($('#show_in_home').is(':checked')) {
                show_in_home = 1;
            }
            var apply_for_discount_product = 0;
            if ($('#apply_for_discount_product').is(':checked')) {
                apply_for_discount_product = 1;
            }

            formData.append('type', $('#select_type_form').val());
            formData.append('products', $("#m_select_remote_product_name").val());
            formData.append('excluded_products', $("#m_select_remote_excluded_product_name").val());
            formData.append('categories', $("#m_select_remote_category_name").val());
            formData.append('excluded_categories', $("#m_select_remote_excluded_category_name").val());
            formData.append('is_automatic', is_automatic);
            formData.append('show_in_home', show_in_home);
            formData.append('apply_for_discount_product', apply_for_discount_product);

            formData.append('user_famous_id', $("#m_select_remote_user_name").val() == null ? "" : $("#m_select_remote_user_name").val());

            axios.post(get_url + "/admin/coupons/add", formData).then(function (res) {
                // console.log(res.data);
                vm.loading = false;
                var get_res = handle_response(res.data);

                scroll_to_div('.m-dropdown__wrapper');
                if (get_res) {

                    setTimeout(function () {
                        $('.add_form').addClass('hidden');
                        $('.show_data').removeClass('hidden');
                    }, 1200);
                    table_coupon.ajax.reload();
                    vm.$validator.reset();
                }
            }).catch(function (err) {
                vm.loading = false;
            });


        },
        update_coupon: function () {
            var formData = new FormData();

            this.loading = true;
            Object.keys(this.coupon).forEach(function (key) {
                formData.append(key, vm.coupon[key]);
            });
            var is_automatic = 0;
            if ($('#is_automatic').is(':checked')) {
                is_automatic = 1;
            }

            var show_in_home = 0;
            if ($('#show_in_home').is(':checked')) {
                show_in_home = 1;
            }
            var apply_for_discount_product = 0;
            if ($('#apply_for_discount_product').is(':checked')) {
                apply_for_discount_product = 1;
            }

            formData.append('id', this.edit_id);
            formData.append('type', $('#select_type_form').val());
            formData.append('products', $("#m_select_remote_product_name").val());
            formData.append('excluded_products', $("#m_select_remote_excluded_product_name").val());
            formData.append('categories', $("#m_select_remote_category_name").val());
            formData.append('excluded_categories', $("#m_select_remote_excluded_category_name").val());
            formData.append('is_automatic', is_automatic);
            formData.append('show_in_home', show_in_home);
            formData.append('apply_for_discount_product', apply_for_discount_product);

            formData.append('user_famous_id', $("#m_select_remote_user_name").val() == null ? "" : $("#m_select_remote_user_name").val());
            axios.post(get_url + "/admin/coupons/update", formData).then(function (res) {

                vm.loading = false;
                var get_res = handle_response(res.data);
                scroll_to_div('.m-dropdown__wrapper');
                if (get_res) {

                    setTimeout(function () {
                        $('.add_form').addClass('hidden');
                        $('.show_data').removeClass('hidden');
                    }, time_to_hide_success_msg);

                    table_coupon.ajax.reload();
                }
            }).catch(function (err) {
                vm.loading = false;
            });


        },
        delete_coupon: function (category) {
            axios.post(get_url + "/admin/coupons/delete",
                {
                    id: category.id
                }
            ).then(function (res) {

                var get_res = handle_response(res.data);
                if (get_res) {
                    swal(translations['success_delete'], translations['done_delete'], "success");
                    table_coupon.ajax.reload();
                }

            }).catch(function (err) {
                vm.loading = false;
            });

        },
        change_status: function (user) {

            axios.post(get_url + "/admin/coupons/changeStatus",
                {
                    id: user.id
                }
            ).then(function (res) {
                table_coupon.ajax.reload();
            }).catch(function (err) {
                vm.loading = false;
            });

        },


    },
    watch: {}
});

$(document).ready(function () {

    // init

    // daterangepicker
    $("#m_daterangepicker_coupon_date").daterangepicker({
        buttonClasses: "m-btn btn",
        applyClass: "btn-primary",
        cancelClass: "btn-secondary",
        timePicker: true,
        locale: {
            format: 'YYYY-MM-DD hh:mm A'
        }
    }, function (a, t, n) {

        $("#m_daterangepicker_coupon_date .form-control").val(a.format("YYYY-MM-DD hh:mm A") + " / " + t.format("YYYY-MM-DD hh:mm A"));
        vm.coupon.start_at = a.format("YYYY-MM-DD hh:mm A");
        vm.coupon.end_at = t.format("YYYY-MM-DD hh:mm A");
    });


    // select2 remote
    $("#m_select_remote_user_name").select2({
        placeholder: "ابحث عن مشهور",
        allowClear: !0,
        ajax: {
            // url: "https://api.github.com/search/repositories",
            url: "get-remote-ajax-users",
            dataType: "json",
            delay: 250,

            data: function (e) {
                return {q: e.term, page: e.page}
            },
            processResults: function (e, t) {
                return t.page = t.page || 1, {results: e.items, pagination: {more: e.incomplete_results}}
            },
            cache: !0
        },
        escapeMarkup: function (e) {
            return e
        },
        minimumInputLength: 3,
        language: {
            inputTooShort: function () {
                return 'الرجاء إدخال 3 أحرف أو أكثر';
            }
        },
        templateResult: function (e) {
            if (e.loading) return "... جار البحث";
            return (e.email  ? e.first_name + " "+e.last_name + " ( "+e.email +" ) "  : "") || e.text;
        },
        templateSelection: function (e) {
            return (e.email ? e.first_name + " "+e.last_name + " ( "+e.email +" ) " : "") || e.text;
        },
    });


    $("#m_select_remote_product_name").select2({
        placeholder: "ابحث عن المنتجات",
        allowClear: !0,
        ajax: {
            // url: "https://api.github.com/search/repositories",
            url: "get-remote-ajax-products",
            dataType: "json",
            delay: 250,

            data: function (e) {
                return {q: e.term, page: e.page}
            },
            processResults: function (e, t) {
                return t.page = t.page || 1, {results: e.items, pagination: {more: e.incomplete_results}}
            },
            cache: !0
        },
        escapeMarkup: function (e) {
            return e
        },
        minimumInputLength: 3,
        language: {
            inputTooShort: function () {
                return 'الرجاء إدخال 3 أحرف أو أكثر';
            }
        },
        templateResult: function (e) {
            if (e.loading) return e.name;
            return e.name || e.text;
        },
        templateSelection: function (e) {
            return e.name || e.text;
        },
    });
    $("#m_select_remote_excluded_product_name").select2({
        placeholder: "ابحث عن المنتجات",
        allowClear: !0,
        ajax: {
            // url: "https://api.github.com/search/repositories",
            url: "get-remote-ajax-products",
            dataType: "json",
            delay: 250,

            data: function (e) {
                return {q: e.term, page: e.page}
            },
            processResults: function (e, t) {
                return t.page = t.page || 1, {results: e.items, pagination: {more: e.incomplete_results}}
            },
            cache: !0
        },
        escapeMarkup: function (e) {
            return e
        },
        minimumInputLength: 3,
        language: {
            inputTooShort: function () {
                return 'الرجاء إدخال 3 أحرف أو أكثر';
            }
        },
        templateResult: function (e) {
            if (e.loading) return e.name;
            return e.name || e.text;
        },
        templateSelection: function (e) {
            return e.name || e.text;
        },
    });
    $("#m_select_remote_category_name").select2({
        placeholder: "ابحث عن التصنيفات",
        allowClear: !0,
        ajax: {
            // url: "https://api.github.com/search/repositories",
            url: "get-remote-ajax-leaf-categories",
            dataType: "json",
            delay: 250,

            data: function (e) {
                return {q: e.term, page: e.page}
            },
            processResults: function (e, t) {
                return t.page = t.page || 1, {results: e.items, pagination: {more: e.incomplete_results}}
            },
            cache: !0
        },
        escapeMarkup: function (e) {
            return e
        },
        minimumInputLength: 0,
        /* language: {
             inputTooShort: function() {
                 return 'الرجاء إدخال 3 أحرف أو أكثر';
             }
         },*/
        templateResult: function (e) {
            if (e.loading) return e.name;
            return e.name || e.text;
        },
        templateSelection: function (e) {
            return e.name || e.text;
        },
    });
    $("#m_select_remote_excluded_category_name").select2({
        placeholder: "ابحث عن التصنيفات",
        allowClear: !0,
        ajax: {
            // url: "https://api.github.com/search/repositories",
            url: "get-remote-ajax-leaf-categories",
            dataType: "json",
            delay: 250,

            data: function (e) {
                return {q: e.term, page: e.page}
            },
            processResults: function (e, t) {
                return t.page = t.page || 1, {results: e.items, pagination: {more: e.incomplete_results}}
            },
            cache: !0
        },
        escapeMarkup: function (e) {
            return e
        },
        minimumInputLength: 0,
        /*language: {
            inputTooShort: function() {
                return 'الرجاء إدخال 3 أحرف أو أكثر';
            }
        },*/
        templateResult: function (e) {
            if (e.loading) return e.name;
            return e.name || e.text;
        },
        templateSelection: function (e) {
            return e.name || e.text;
        },
    });


    $("#m_select_remote_excluded_product_name").change(function () {
        // console.log($("#m_select_remote_excluded_product_name").select2('data'));
    });

    $('#add_new_coupon').click(function () {
        $('.add_form').removeClass('hidden');
        $('.show_data').addClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_coupon();
        vm.reset_validation();
        $('#m_daterangepicker_coupon_date').data('daterangepicker').setStartDate(moment());
        $('#m_daterangepicker_coupon_date').data('daterangepicker').setEndDate(moment());

        $("#m_select_remote_product_name").empty();
        $("#m_select_remote_excluded_product_name").empty();
        $("#m_select_remote_category_name").empty();
        $("#m_select_remote_excluded_category_name").empty();

        $('#select_type_form').val(4).trigger('change');
        $('#is_automatic').prop('checked', false);
        $('#apply_for_discount_product').prop('checked', false);

    });
    $('#cancel').click(function () {
        $('.add_form').addClass('hidden');
        $('.show_data').removeClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_coupon();
        vm.reset_validation();
    });

    table_coupon.on('click', '.edit', function () {
        var row = $(this).closest('tr');
        if (row.attr('role') == undefined) {
            row = $(this).parent('tr'['role=row']);
        }

        var row_data = table_coupon.row(row).data();
        $('.add_form').removeClass('hidden');
        $('.show_data').addClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        //  $('#m_daterangepicker_coupon_date').datepicker('option', {minDate: vm.coupon.start_at, maxDate: vm.coupon.end_at});

        $("#m_select_remote_product_name").empty();
        $("#m_select_remote_excluded_product_name").empty();
        $("#m_select_remote_category_name").empty();
        $("#m_select_remote_excluded_category_name").empty();
        $("#m_select_remote_user_name").empty();

        set_prodcuts(row_data.available_products);
        set_excluded_producs(row_data.not_available_products);
        set_categoires(row_data.available_categories);
        set_excluded_categoires(row_data.not_available_categories);
        if(row_data.user_famous) {
            let user_famous = row_data.user_famous_data;
            $("#m_select_remote_user_name").append(new Option(user_famous.user_name ,user_famous.id , true , true ));

        }
        vm.edit_coupon(row_data);


        $('#select_type_form').val(row_data.coupon_type_id).trigger('change');
        $("#m_daterangepicker_coupon_date .form-control").val(row_data.start_at_edit + " / " + row_data.end_at_edit);

        $('#m_daterangepicker_coupon_date').data('daterangepicker').setStartDate(row_data.start_at_edit);
        $('#m_daterangepicker_coupon_date').data('daterangepicker').setEndDate(row_data.end_at_edit);


        if (row_data.is_automatic) {
            $('#is_automatic').prop('checked', true);
            $('.coupon_famous').addClass('hidden');
        } else {
            $('#is_automatic').prop('checked', false);
            $('.coupon_famous').removeClass('hidden');
        }

        if (row_data.show_in_home) {
            $('#show_in_home').prop('checked', true);
        } else {
            $('#show_in_home').prop('checked', false);
        }
        if (row_data.apply_for_discount_product) {
            $('#apply_for_discount_product').prop('checked', true);
        } else {
            $('#apply_for_discount_product').prop('checked', false);
        }
    });
    table_coupon.on('click', '.delete', function () {
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
                vm.delete_coupon(table_coupon.row(row).data());
            } else {
                e.dismiss && swal(translations['cancelled_delete'], translations['didnt_delete'], "error")
            }

        });
    });
    table_coupon.on('click', '.change_status', function () {
        var row = $(this).closest('tr');
        if (row.attr('role') == undefined) {
            row = $(this).parent('tr'['role=row']);
        }
        vm.edit_row = row;
        row.find('.loading').removeClass('hidden');
        row.find('.get_status').addClass('hidden');
        vm.change_status(table_coupon.row(row).data());

    });


    $('#select_type_form').change(function () {
        var value = $(this).val();
        if(value == 5) {
            vm.free_shipping_coupon = false;
        }else {
            vm.free_shipping_coupon = true;
        }
        if (value == 1 || value == 3) {
            $('.select_products').addClass('hidden');
            $('.select_categories').addClass('hidden');
            $('.show_apply_for_discount_product').addClass('hidden');
        } else {
            $('.select_products').removeClass('hidden');
            $('.select_categories').removeClass('hidden');
            $('.show_apply_for_discount_product').removeClass('hidden');
        }

    });

    $('#is_automatic').change(function () {
        if ($('#is_automatic').is(':checked')) {
            $('.coupon_famous').addClass('hidden');
        }else {
            $('.coupon_famous').removeClass('hidden');
        }
    });

    /*
    $("#m_select_remote_category_name").change(function () {
        if ($('#is_automatic').is(':checked')) {

            mApp.block(".m-form", {});

            let coupon_id = !vm.add ? vm.edit_id : -1;
            let category_id = $(this).val();
            axios.get(get_url + "/admin/check-automatic-coupon", {
                params: {
                    coupon_id: coupon_id,
                    category_id: category_id
                }
            }).then(function (res) {
                mApp.unblock(".m-form", {});
                let results = res.data;
                results.forEach(function (t) {
                    $('#m_select_remote_excluded_product_name').append(new Option(t.product.name, t.product.id, true, true));
                });

            }).catch(function (err) {

            });
        }
    });
    */

});

