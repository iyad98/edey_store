var vm = new Vue({
    el: '#app',
    data: {

        notification: {
            title: '',
            message: '',
            external_url: '' ,
            image : '' ,
            platform : 'all'
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

        validateForm: function () {

        },
        reset_validation: function () {
            vm.$validator.reset();
        },

        send_notifications: function () {
            var formData = new FormData();

            var notification_category = $('#m_select_category_form').val();
            var notification_product = $('#m_select_remote_marketing_products').val();
            var notification_pointer = $('.select_pointer').val();


            formData.append('title', this.notification.title);
            formData.append('message', this.notification.message);
            formData.append('image', this.notification.image);
            formData.append('category_id', notification_category);
            formData.append('product_id', notification_product);
            formData.append('pointer', notification_pointer);
            formData.append('external_url', this.notification.external_url);
            formData.append('user_ids', $("#m_select_remote_users").val());
            formData.append('country_ids', $("#m_select_remote_countries").val());
            formData.append('platform', this.notification.platform);

            this.loading = true;
            axios.post(get_url + "/admin/send-notifications-user", formData).then(function (res) {

                vm.loading = false;
                var get_res = handle_response(res.data);
                scroll_to_div('.m-subheader');
            }).catch(function (err) {
                vm.loading = false;
            });


        },

        get_file: function (event, selector) {
            var file = event.target.files[0];
            if (file) {
                this.notification['image'] = file;
                read_url(event.target, selector);
            } else {
                this.notification['image'] = '';
            }

        }
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
    $("#m_select_remote_users").select2({
        placeholder: "ابحث عن مستخدمين",
        allowClear: !0,
        ajax: {
            // url: "https://api.github.com/search/repositories",
            url: get_url + "/admin/get-remote-ajax-users",
            dataType: "json",
            delay: 250,

            data: function (e) {
                return {
                    q: e.term,
                    page: e.page ,
                    country_ids : $("#m_select_remote_countries").val(),
                    platform : $("#m_select_platform").val()
                }
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
            return e.email ? (e.first_name + "("+ e.email+")") || e.text : '';
        },
        templateSelection: function (e) {
            return e.email ?  (e.first_name + "("+ e.email+")") || e.text : '';
        },
    });
    $("#m_select_remote_countries").select2({placeholder: "اختار الدولة"});
    $('.select_pointer').change(function () {
        let value = $(this).val();
        if (value == 1) {
            $('.external_url').removeClass('hidden');
            $('.show_select_category').addClass('hidden');
            $('.show_select_product').addClass('hidden');
        } else if (value == 2) {
            $('.external_url').addClass('hidden');
            $('.show_select_category').removeClass('hidden');
            $('.show_select_product').addClass('hidden');
        } else if (value == 3) {
            $('.external_url').addClass('hidden');
            $('.show_select_category').addClass('hidden');
            $('.show_select_product').removeClass('hidden');
        }else {
            $('.external_url').addClass('hidden');
            $('.show_select_category').addClass('hidden');
            $('.show_select_product').addClass('hidden');
        }
    });

    $("#m_select_remote_countries").change(function () {
        $("#m_select_remote_users").val([]).trigger('change');
    });
    $("#m_select_platform").change(function () {
        $("#m_select_remote_users").val([]).trigger('change');
    });
});

