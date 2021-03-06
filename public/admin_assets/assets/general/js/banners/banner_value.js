var vm = new Vue({
    el: '#app',
    data: {
        default_images : {
            image_ar : '',
            image_en : '',
            image_website_ar : '',
            image_website_en : '',
        },


        banner_value: {
            name_ar: '',
            name_en: '',
            image_ar : '' ,
            image_en : '' ,
            image_website_ar : '' ,
            image_website_en : '' ,
            parent_id : parent_id,

        },
        attr_name : 'image_ar',
        selector_id_image : 'image_ar',
        shock_event : '',
        default_image: JSON.parse(JSON.stringify(default_image)),
// parent_banner_values : parent_banner_values,
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

        setData: function (add, data) {
            this.default_images.image_ar = add ? JSON.parse(JSON.stringify(default_image)) : data.image_ar;
            this.default_images.image_en = add ? JSON.parse(JSON.stringify(default_image)) : data.image_en;
            this.default_images.image_website_ar = add ? JSON.parse(JSON.stringify(default_image)) : data.image_website_ar;
            this.default_images.image_website_en = add ? JSON.parse(JSON.stringify(default_image)) : data.image_website_en;

            this.shock_event = makeid(32);
        },

        validateForm: function (event) {
            vm.$validator.validateAll().then(function (valid) {
                if (valid) {
                    if (vm.add) {
                        vm.add_banner_value();
                    } else {

                        vm.update_banner_value();
                    }

                }
            });
        },

        empty_banner_value: function () {
            this.add = true;
            var empty_banner_value = {
                name_ar: '',
                name_en: '',
                image_ar : '' ,
                image_en : '' ,
                image_website_ar : '' ,
                image_website_en : '' ,
                parent_id : parent_id,

            };

            this.banner_value = empty_banner_value;
        },
        edit_banner_value: function (data) {
            this.add = false;
            this.edit_id = data.id;
            this.banner_value.name_ar = data.name_ar;
            this.banner_value.name_en = data.name_en;
            this.banner_value.image_ar = data.image_ar;
            this.banner_value.image_en = data.image_en;
            this.banner_value.image_website_ar = data.image_website_ar;
            this.banner_value.image_website_en = data.image_website_en;


        },
        reset_validation: function () {
            vm.$validator.reset();
        },

        add_banner_value: function () {
            var formData = new FormData();
            this.banner_value.category_id = $('#m_select_category_form').val();
            this.banner_value.product_id = $('#m_select_remote_marketing_products').val();

            this.loading = true;
            Object.keys(this.banner_value).forEach(function (key) {
                formData.append(key, vm.banner_value[key]);
            });
            formData.append('select_pointer', $('.select_pointer').val());

            axios.post(get_url + "/admin/banner-values/add", formData).then(function (res) {
                vm.loading = false;
                var get_res = handle_response(res.data);

                scroll_to_div('.m-dropdown__wrapper');
                if (get_res) {
                    vm.parent_banner_values = res.data['data']['banner_values'];

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
        update_banner_value: function () {
            var formData = new FormData();
            this.banner_value.category_id = $('#m_select_category_form').val();
            this.banner_value.product_id = $('#m_select_remote_marketing_products').val();

            this.loading = true;
            Object.keys(this.banner_value).forEach(function (key) {
                formData.append(key, vm.banner_value[key]);
            });
            formData.append('id', this.edit_id);
            formData.append('select_pointer', $('.select_pointer').val());

            axios.post(get_url + "/admin/banner-values/update", formData).then(function (res) {
                vm.loading = false;
                var get_res = handle_response(res.data);
                scroll_to_div('.m-dropdown__wrapper');
                if (get_res) {

                    vm.parent_banner_values = res.data['data']['banner_values'];
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
        delete_banner_value: function (category) {

            axios.post(get_url + "/admin/banner-values/delete",
                {
                    id: category.id
                }
            ).then(function (res) {
                var get_res = handle_response(res.data);
                if (get_res) {
                    vm.parent_banner_values = res.data['data']['banner_values'];
                    swal(translations['success_delete'], translations['done_delete'], "success");
                    table.ajax.reload();
                }

            }).catch(function (err) {
                vm.loading = false;
            });

        },
        get_file: function (event, selector , attribute) {
            var file = event.target.files[0];
            if (file) {
                this.banner_value[attribute] = file;
                read_url(event.target, selector);
            } else {
                this.banner_value[attribute] = '';
            }

        },

        change_status: function (banner) {

            axios.post(get_url + "/admin/banners/change-status",
                {
                    id: banner.id
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

    $("#m_select_category_form").select2({placeholder: "?????????? ??????????"});
    $("#m_select_category_form2").select2({placeholder: "?????????? ??????????"});
    $("#m_select_category_form").change(function () {
        vm.banner_value.city_id = $(this).val();
    });
    $("#m_select_banner_value_form").select2({placeholder: "?????????? ???????????????? ??????????????"});
    $("#m_select_banner_value_form2").select2({placeholder: "?????????? ???????????????? ??????????????"});

    $("#m_select_remote_marketing_products").select2({
        placeholder: "???????? ???? ????????????????",
        allowClear: !0,
        ajax: {
            // url: "https://api.github.com/search/repositories",
            url: get_url + "/admin/get-remote-ajax-products",
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
                return '???????????? ?????????? 3 ???????? ???? ????????';
            }
        },
        templateResult: function (e) {
            if (e.loading) return "... ?????? ??????????";
            return e.name || e.text;
        },
        templateSelection: function (e) {
            return e.name || e.text;
        },
    });


    $('#m_select_banner_value_form').change(function () {
        let value = $(this).val();
        if(value == -1) {
            $('.select_pointer').val(-1);
            $('.show_select_pointer').addClass('hidden');

        }else {
            $('.show_select_pointer').removeClass('hidden');
        }
        $('.select_pointer').change();
    });
    $('.select_pointer').change(function () {
        let value = $(this).val();
        if(value == -1) {
            $('.show_select_category').addClass('hidden');
            $('.show_select_product').addClass('hidden');
        }else if(value == 1) {
            $('.show_select_category').removeClass('hidden');
            $('.show_select_product').addClass('hidden');
        }else {
            $('.show_select_category').addClass('hidden');
            $('.show_select_product').removeClass('hidden');
        }
    });
/////
    $('#add_new_banner_value').click(function () {
        $('.add_form').removeClass('hidden');
        $('.show_data').addClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        $('#m_select_banner_value_form').val($('#m_select_banner_value_form2').val()).trigger('change');

        $('.select_pointer').val(-1);
        $('.select_pointer').change();

        vm.empty_banner_value();
        vm.reset_validation();
        vm.setData(true, '');
    });
    $('#cancel').click(function () {
        $('.add_form').addClass('hidden');
        $('.show_data').removeClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_banner_value();
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
        vm.edit_banner_value(row_data);

        if(row_data.category_id) {
            $('.select_pointer').val(1);
        }else if(row_data.product_id) {
            $('#m_select_remote_marketing_products').append(new Option(row_data.product_name , row_data.product_id , true , true));
            $('.select_pointer').val(2);
        }else {
            $('.select_pointer').val(-1);
        }
        $('.select_pointer').change();

        $('#m_select_slider_form').val(row_data.parent_id ?row_data.parent_id : -1).trigger('change');
        $('#m_select_category_form').val(row_data.category_id ? row_data.category_id : -1).trigger('change');
        vm.setData(false, row_data);
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
                vm.delete_banner_value(table.row(row).data());
            } else {
                e.dismiss && swal(translations['cancelled_delete'], translations['didnt_delete'], "error")
            }

        });
    });
    table.on('change', '.change_status', function () {
        var row = $(this).closest('tr');
        if (row.attr('role') == undefined) {
            row = $(this).parent('tr'['role=row']);
        }

        vm.edit_row = row;
        row.find('.loading').removeClass('hidden');
        row.find('.get_status').addClass('hidden');
        vm.change_status(table.row(row).data());
    });
    table.on('click', '.show_children_banner_values', function () {
        var id = $(this).find('.banner_value_id_hidden').val();
        $('#m_select_banner_value_form2').val(id).trigger('change');
    });


});

