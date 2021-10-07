var vm = new Vue({
    el: '#app',
    data: {

        attr_name : 'image',
        selector_id_image :'image',
        shock_event: '',
        obj : 'pop_up',

        pop_up: {
            image: '',
            status: '',
            default_image : '',
        },
        splash: {
            image: '',
            status: '',
            default_image : '',

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

        SelectImageFromGalleryV2 : function (attr_name , selector_id_image , obj) {
            this.attr_name = attr_name;
            this.selector_id_image = selector_id_image;
            this.obj = obj;
            $('#GalleryImages').modal('show');
        },


        validateForm: function () {

        },
        reset_validation: function () {
            vm.$validator.reset();
        },

        update_advertisement: function () {
            var formData = new FormData();

            var pop_up_category = $('#m_select_category_form').val();
            var pop_up_product = $('#m_select_remote_marketing_products').val();
            var pop_up_pointer = $('.select_pointer').val();

            var splash_category = $('#m_select_category_form_2').val();
            var splash_product = $('#m_select_remote_marketing_products_2').val();
            var splash_pointer = $('.select_pointer_2').val();

            formData.append('pop_up_category', pop_up_category);
            formData.append('pop_up_product', pop_up_product);
            formData.append('pop_up_pointer', pop_up_pointer);
            formData.append('pop_up_image', this.pop_up.image);
            formData.append('pop_up_status', $('#pop_up_status').is(":checked") ? 1 : 0);

            formData.append('splash_category', splash_category);
            formData.append('splash_product', splash_product);
            formData.append('splash_pointer', splash_pointer);
            formData.append('splash_image', this.splash.image);
            formData.append('splash_status', $('#splash_status').is(":checked") ? 1 : 0);

            formData.append('_method', "PUT");

            this.loading = true;
            axios.post(get_url + "/admin/advertisements/1", formData).then(function (res) {

                vm.loading = false;
                var get_res = handle_response(res.data);
                scroll_to_div('.m-dropdown__wrapper');

            }).catch(function (err) {
                vm.loading = false;
            });


        },

        get_file_pop_up: function (event, selector) {
            var file = event.target.files[0];
            if (file) {
                this.pop_up['image'] = file;
                read_url(event.target, selector);
            } else {
                this.pop_up['image'] = '';
            }

        },
        get_file_splash: function (event, selector) {
            var file = event.target.files[0];
            if (file) {
                this.splash['image'] = file;
                read_url(event.target, selector);
            } else {
                this.splash['image'] = '';
            }

        },
    },
    watch: {}
});

$(document).ready(function () {

// init

    $("#m_select_category_form").select2({placeholder: "اختار الصنف"});
    $("#m_select_remote_marketing_products").select2({
        placeholder: "ابحث عن المنتجات",
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
                return 'الرجاء إدخال 3 أحرف أو أكثر';
            }
        },
        templateResult: function (e) {
            if (e.loading) return "... جار البحث";
            return e.name || e.text;
        },
        templateSelection: function (e) {
            return e.name || e.text;
        },
    });
    $('.select_pointer').change(function () {
        let value = $(this).val();
        if (value == -1) {
            $('.show_select_category').addClass('hidden');
            $('.show_select_product').addClass('hidden');
        } else if (value == 1) {
            $('.show_select_category').removeClass('hidden');
            $('.show_select_product').addClass('hidden');
        } else {
            $('.show_select_category').addClass('hidden');
            $('.show_select_product').removeClass('hidden');
        }
    });

    $("#m_select_category_form_2").select2({placeholder: "اختار الصنف"});
    $("#m_select_remote_marketing_products_2").select2({
        placeholder: "ابحث عن المنتجات",
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
                return 'الرجاء إدخال 3 أحرف أو أكثر';
            }
        },
        templateResult: function (e) {
            if (e.loading) return "... جار البحث";
            return e.name || e.text;
        },
        templateSelection: function (e) {
            return e.name || e.text;
        },
    });
    $('.select_pointer_2').change(function () {
        let value = $(this).val();
        if (value == -1) {
            $('.show_select_category_2').addClass('hidden');
            $('.show_select_product_2').addClass('hidden');
        } else if (value == 1) {
            $('.show_select_category_2').removeClass('hidden');
            $('.show_select_product_2').addClass('hidden');
        } else {
            $('.show_select_category_2').addClass('hidden');
            $('.show_select_product_2').removeClass('hidden');
        }
    });


    $('.select_pointer').val(pop_up.point_type).trigger('change');
    $('.select_pointer_2').val(splash.point_type).trigger('change');

    vm.pop_up.image = pop_up.image;
    vm.pop_up.default_image = JSON.parse(JSON.stringify(pop_up.image));
    if(pop_up.status == 1) {
        $('#pop_up_status').prop('checked' , true);
    }else {
        $('#pop_up_status').prop('checked' , false);
    }

    vm.splash.image = splash.image;
    vm.splash.default_image = JSON.parse(JSON.stringify(splash.image));
    if(splash.status == 1) {
        $('#splash_status').prop('checked' , true);
    }else {
        $('#splash_status').prop('checked' , false);
    }
    if (pop_up.point_type == 1) {
        $("#m_select_category_form").val(pop_up.point_id).trigger('change');
        ;
    } else if (pop_up.point_type == 2) {
        if (pop_up.product) {
            $("#m_select_remote_marketing_products").append(new Option(pop_up.product.name, pop_up.product.id, true, true));

        }
    }

    if (splash.point_type == 1) {
        $("#m_select_category_form_2").val(splash.point_id).trigger('change');
    } else if (splash.point_type == 2) {
        if (splash.product) {
            $("#m_select_remote_marketing_products_2").append(new Option(splash.product.name, splash.product.id, true, true));

        }
    }


    $('.m_select_category_form').val(pop_up.point_type);
    $('.m_select_category_form_2').val(splash.point_type);

});

