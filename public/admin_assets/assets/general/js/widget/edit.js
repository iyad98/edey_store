
var vm = new Vue({
    el: '#app_categories',
    data: {

        widget : {
            image_ar : widget.image_ar,
            image_en : widget.image_en,
            image_mobile_ar : widget.image_mobile_ar,
            widget_type : widget.widget_type,
            website_home_id : widget.website_home_id,


        },

        msg: {
            success: '',
            error: ''
        }
    },
    methods: {



        get_file: function (event, selector , attribute) {


            var file = event.target.files[0];

            if (file) {
                this.widget[attribute] = file;
                read_url(event.target, selector);
            } else {
                this.widget[attribute] = '';
            }

        },

        add_widget : function () {


            var formData = new FormData();

            formData.append('image_ar', this.widget.image_ar);
            formData.append('image_mobile_ar', this.widget.image_mobile_ar);

            formData.append('image_en', this.widget.image_en);
            formData.append('widget_type', this.widget.widget_type);
            formData.append('website_home_id', this.widget.website_home_id);


            this.website_note_loading = true;



            axios.post(get_url + "/admin/widget/"+this.widget.website_home_id+"/update", formData).then(function (res) {

                vm.website_note_loading = false;


                var get_res = handle_response(res.data);
                console.log(get_res);
                scroll_to_div('.m-dropdown__wrapper');

            }).catch(function (err) {
                vm.website_note_loading = false;
            });


        },
    }
});
$(function () {

    $('#select_categories').select2();
    $('#select_banners').select2();
    $('#select_categories_2').select2();

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
            $('.external_url').addClass('hidden');
            $('.show_select_category').addClass('hidden');
            $('.show_select_product').addClass('hidden');
        } else if (value == 1) {
            $('.external_url').addClass('hidden');
            $('.show_select_category').removeClass('hidden');
            $('.show_select_product').addClass('hidden');
        } else if (value == 2) {
            $('.external_url').addClass('hidden');
            $('.show_select_category').addClass('hidden');
            $('.show_select_product').removeClass('hidden');
        }else if (value == 3) {
            $('.external_url').removeClass('hidden');
            $('.show_select_category').addClass('hidden');
            $('.show_select_product').addClass('hidden');
        }
    });

    app_home_banner_categories.forEach(function (t) {
        vm.categories.push({
            id: t.id,
            name: t.name,
            name_ar: t.name_ar,
            name_en: t.name_en,
            in_home_products_count: t.product_counts,
            type: t.type,
        });
    });
    vm.categories_sidebar = arrange_sidebar_categories(sidebar_categories);

    if(website_note.category_id) {
        $('.select_pointer').val(1);
    }else if(website_note.product_id) {
        $('#m_select_remote_marketing_products').append(new Option(website_note.product_name , website_note.product_id , true , true));
        $('.select_pointer').val(2);
    }else if(website_note.url) {
        $('.select_pointer').val(3);
    }else {
        $('.select_pointer').val(-1);
    }
    $('.select_pointer').change();
    $('#m_select_category_form').val(website_note.category_id ? website_note.category_id : -1).trigger('change');


    $('#select_categories').change(function () {

        let value = $(this).val();
        if (value == -1) return;

        var check = vm.categories.find(function (el) {
            return el.id == value && el.type == 1;
        });
        var get_item = all_categories.find(el => el.id == value);
        if (!check) {
            vm.categories.push({
                id: $(this).select2('data')[0].id,
                name: $(this).select2('data')[0].text,
                name_ar: get_item.name_ar,
                name_en: get_item.name_en,
                in_home_products_count: 5,
                type: 1,
            });
        }

        $(this).val('-1').trigger('change');
    });
    $('#select_banners').change(function () {

        let value = $(this).val();
        if (value == -1) return;

        var check = vm.categories.find(function (el) {
            return el.id == value && el.type == 2;
        });
        var get_item = banners.find(el => el.id == value);
        if (!check) {
            vm.categories.push({
                id: $(this).select2('data')[0].id,
                name: $(this).select2('data')[0].text,
                name_ar: get_item.name_ar,
                name_en: get_item.name_en,
                in_home_products_count: 0,
                type: 2,
            });
        }

        $(this).val('-1').trigger('change');
    });
    $('#select_categories_2').change(function () {

        let value = $(this).val();
        if (value == -1) return;

        var check = vm.categories_sidebar.find(function (el) {
            return el.id == value;
        });
        var get_item = all_categories.find(el => el.id == value);

        if (!check) {
            vm.categories_sidebar.push({
                id: $(this).select2('data')[0].id,
                name: $(this).select2('data')[0].text,
                nickname_ar: get_item.name_ar,
                nickname_en: get_item.name_en,
            });
        }

        $(this).val('-1').trigger('change');
    });
    $('#select_orderby_type').change(function () {

        let value = $(this).val();
        let text =  $(this).children("option:selected").text();
        let type = value == -1 ? 5 : 6;

        let name_ar = "";
        let name_en = "";
        if(type == 5) {
            name_ar = translations.latest_product_ar;
            name_en = translations.latest_product_en;
        }else {
            name_ar = translations.most_sales_ar;
            name_en = translations.most_sales_en;
        }
        var check = vm.categories.find(function (el) {
            return el.id == value;
        });
        if (value == 0) return;

        if(!check) {
            vm.categories.push({
                id: value,
                name: text,
                name_ar: name_ar,
                name_en: name_en,
                in_home_products_count: 5,
                type: type,
            });
        }


    });


    $("#sortable").sortable();
    $("#sortable").disableSelection();

    $("#sortable2").sortable();
    $("#sortable2").disableSelection();


    if(website_note.status == 1) {
        $('#website_note').prop('checked' , true);
    }else {
        $('#website_note').prop('checked' , false);
    }

});