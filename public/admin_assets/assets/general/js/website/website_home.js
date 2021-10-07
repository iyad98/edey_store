function arrange_sidebar_categories(sidebar_categories) {
    var sidebar_categories_after_arrange = [];
    sidebar_categories.forEach(function (t) {
        let data = {order : t.in_website_sidebar_order ,id : t.id , name: t.name,nickname_ar : t.website_nickname_ar , nickname_en : t.website_nickname_en ,};
        if(t.parent_website) {
            data.parent = t.parent_website;
        }
        sidebar_categories_after_arrange.push(data);
    });
    var tree = new Tree(sidebar_categories_after_arrange);
    tree = Object.values(tree.nodes);
    let list_items = [];
    tree.forEach(function (t) {
        if(!t.hasOwnProperty('parent')) {
            list_items.push(t);
        }
    });
    list_items = list_items.sort(function(a, b) {
        return parseFloat(a.order) - parseFloat(b.order);
    });
    return list_items;

}

var vm = new Vue({
    el: '#app_categories',
    data: {

        website_note : {
            image_ar : website_note.image_ar,
            image_en : website_note.image_en,
            product_id : website_note.product_id,
            category_id : website_note.category_id,
            url : website_note.url,
            status : website_note.status,
        },

        website_note_text_first : {
            text_en : website_note_text_first.text_en,
            text_ar : website_note_text_first.text_ar,
            product_id : website_note_text_first.product_id,
            category_id : website_note_text_first.category_id,
            url : website_note_text_first.url,
            text_color : website_note_text_first.text_color,
            background_color : website_note_text_first.background_color,
            status : website_note_text_first.status,
        },

        website_note_text_second : {
            text_en : website_note_text_second.text_en,
            text_ar : website_note_text_second.text_ar,
            product_id : website_note_text_second.product_id,
            category_id : website_note_text_second.category_id,
            url : website_note_text_second.url,
            text_color : website_note_text_second.text_color,
            background_color : website_note_text_second.background_color,
            status : website_note_text_second.status,
        },


        all_categories : all_categories ,
        banners : banners ,
        categories: [],
        categories_sidebar: [],
        loading: false,
        loading2: false,
        website_note_loading : false,
        website_note_text_first_loading : false,
        website_note_text_second_loading : false,
        msg: {
            success: '',
            error: ''
        }
    },
    methods: {
        delete_category: function (index) {
            this.categories.splice(index, 1);
        },
        delete_category2: function (index) {
            this.categories_sidebar.splice(index, 1);
        },

        add_home_categories: function () {

            this.loading = true;
            let categories = [];
            $('#sortable li').each(function () {
                categories.push({
                    id: $(this).val(),
                    in_home_products_count: $(this).find('.in_home_products_count').val(),
                    type: $(this).find('.type').val() ,
                    name_ar : $(this).find('.name_ar').val(),
                    name_en : $(this).find('.name_en').val(),
                });
            });

            categories = JSON.stringify(categories);
            axios.post('website/add-home-data', {
                categories: categories
            }).then(function (res) {
                vm.loading = false;
                var get_res = handle_response(res.data);
                scroll_to_div('#app_categories');

            }).catch(function (err) {

            });
        },
        add_sidebar_categories: function () {

            this.loading2 = true;
            let categories = [];

            let get_tree = $('.dd').nestable('serialize');
            categories = JSON.stringify(get_tree);

            axios.post('website/add-sidebar-categories', {
                categories: categories
            }).then(function (res) {
                vm.loading2 = false;
                var get_res = handle_response(res.data);
                scroll_to_div('#app_categories');
            }).catch(function (err) {

            });
        },

        get_list_class : function (type) {
            if(type == 1) {
                return 'm-badge--primary m-badge--wide';
            }else if(type == 5 || type == 6) {
                return 'm-badge--danger m-badge--wide';
            }else {
                return 'm-badge--success m-badge--wide';
            }
        },

       
        get_file: function (event, selector , attribute) {

            var file = event.target.files[0];
            if (file) {
                this.website_note[attribute] = file;
                read_url(event.target, selector);
            } else {
                this.website_note[attribute] = '';
            }

        },

        update_website_note : function () {

            var formData = new FormData();

            formData.append('select_pointer', $('.select_pointer').val());
            formData.append('image_ar', this.website_note.image_ar);
            formData.append('image_en', this.website_note.image_en);
            formData.append('product_id', $('#m_select_remote_marketing_products').val());
            formData.append('category_id', $('#m_select_category_form').val());
            formData.append('url', this.website_note.url);
            formData.append('status', $('#website_note').is(":checked") ? 1 : 0);

          
            this.website_note_loading = true;
            axios.post(get_url + "/admin/website/update-note-in-website-home", formData).then(function (res) {

                vm.website_note_loading = false;
                var get_res = handle_response(res.data);
                scroll_to_div('.m-dropdown__wrapper');

            }).catch(function (err) {
                vm.website_note_loading = false;
            });


        },
        update_website_note_text_first : function () {

            var formData = new FormData();

            formData.append('select_pointer', $('.select_pointer_first_note').val());
            formData.append('text_ar', this.website_note_text_first.text_ar);
            formData.append('text_en', this.website_note_text_first.text_en);

            formData.append('text_color', this.website_note_text_first.text_color);
            formData.append('background_color', this.website_note_text_first.background_color);

            formData.append('product_id', $('#m_select_remote_marketing_products_first_note').val());
            formData.append('category_id', $('#m_select_category_form_first_note').val());
            formData.append('url', this.website_note_text_first.url);
            formData.append('status', $('#website_note_text_first_checkbox').is(":checked") ? 1 : 0);


            this.website_note_text_first_loading = true;
            axios.post(get_url + "/admin/website/update-note-text-first-in-website-home", formData).then(function (res) {

                vm.website_note_text_first_loading = false;
                var get_res = handle_response(res.data);
                scroll_to_div('.m-dropdown__wrapper');

            }).catch(function (err) {
                vm.website_note_text_first_loading = false;
            });


        },

        update_website_note_text_second : function () {

            var formData = new FormData();

            formData.append('select_pointer', $('.select_pointer_second_note').val());
            formData.append('text_ar', this.website_note_text_second.text_ar);
            formData.append('text_en', this.website_note_text_second.text_en);
            formData.append('text_color', this.website_note_text_second.text_color);
            formData.append('background_color', this.website_note_text_second.background_color);
            formData.append('product_id', $('#m_select_remote_marketing_products_second_note').val());
            formData.append('category_id', $('#m_select_category_form_second_note').val());
            formData.append('url', this.website_note_text_second.url);
            formData.append('status', $('#website_note_text_second_checkbox').is(":checked") ? 1 : 0);


            this.website_note_text_second_loading = true;
            axios.post(get_url + "/admin/website/update-note-text-second-in-website-home", formData).then(function (res) {

                vm.website_note_text_second_loading = false;
                var get_res = handle_response(res.data);
                scroll_to_div('.m-dropdown__wrapper');

            }).catch(function (err) {
                vm.website_note_text_second_loading = false;
            });


        }
    }
});
$(function () {


    $('#select_categories').select2();
    $('#select_banners').select2();
    $('#select_categories_2').select2();

    $("#m_select_category_form").select2({placeholder: "اختار الصنف"});
    $("#m_select_category_form_first_note").select2({placeholder: "اختار الصنف"});
    $("#m_select_category_form_second_note").select2({placeholder: "اختار الصنف"});



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
    $("#m_select_remote_marketing_products_first_note").select2({
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
    $("#m_select_remote_marketing_products_second_note").select2({
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
    $('.select_pointer_first_note').change(function () {

        let value = $(this).val();
        if (value == -1) {
            $('.external_url_first_note').addClass('hidden');
            $('.show_select_category_first_note').addClass('hidden');
            $('.show_select_product_first_note').addClass('hidden');
        } else if (value == 1) {
            $('.external_url_first_note').addClass('hidden');
            $('.show_select_category_first_note').removeClass('hidden');
            $('.show_select_product_first_note').addClass('hidden');
        } else if (value == 2) {
            $('.external_url_first_note').addClass('hidden');
            $('.show_select_category_first_note').addClass('hidden');
            $('.show_select_product_first_note').removeClass('hidden');
        }else if (value == 3) {
            $('.external_url_first_note').removeClass('hidden');
            $('.show_select_category_first_note').addClass('hidden');
            $('.show_select_product_first_note').addClass('hidden');
        }
    });
    $('.select_pointer_second_note').change(function () {

        let value = $(this).val();
        if (value == -1) {
            $('.external_url_second_note').addClass('hidden');
            $('.show_select_category_second_note').addClass('hidden');
            $('.show_select_product_second_note').addClass('hidden');
        } else if (value == 1) {
            $('.external_url_second_note').addClass('hidden');
            $('.show_select_category_second_note').removeClass('hidden');
            $('.show_select_product_second_note').addClass('hidden');
        } else if (value == 2) {
            $('.external_url_second_note').addClass('hidden');
            $('.show_select_category_second_note').addClass('hidden');
            $('.show_select_product_second_note').removeClass('hidden');
        }else if (value == 3) {
            $('.external_url_second_note').removeClass('hidden');
            $('.show_select_category_second_note').addClass('hidden');
            $('.show_select_product_second_note').addClass('hidden');
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


    if(website_note_text_first.category_id) {
        $('.select_pointer_first_note').val(1);
    }else if(website_note_text_first.product_id) {
        $('#m_select_remote_marketing_products_first_note').append(new Option(website_note_text_first.product_name , website_note_text_first.product_id , true , true));
        $('.select_pointer_first_note').val(2);
    }else if(website_note_text_first.url) {
        $('.select_pointer_first_note').val(3);
    }else {
        $('.select_pointer_first_note').val(-1);
    }


    if(website_note_text_second.category_id) {
        $('.select_pointer_second_note').val(1);
    }else if(website_note_text_second.product_id) {
        $('#m_select_remote_marketing_products_second_note').append(new Option(website_note_text_second.product_name , website_note_text_second.product_id , true , true));
        $('.select_pointer_second_note').val(2);
    }else if(website_note_text_second.url) {
        $('.select_pointer_second_note').val(3);
    }else {
        $('.select_pointer_second_note').val(-1);
    }



    $('.select_pointer').change();
    $('.select_pointer_first_note').change();
    $('.select_pointer_second_note').change();



    $('#m_select_category_form').val(website_note.category_id ? website_note.category_id : -1).trigger('change');
    $('#m_select_category_form_first_note').val(website_note_text_first.category_id ? website_note_text_first.category_id : -1).trigger('change');
    $('#m_select_category_form_second_note').val(website_note_text_second.category_id ? website_note_text_second.category_id : -1).trigger('change');

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

    if(website_note_text_first.status == 1) {
        $('#website_note_text_first_checkbox').prop('checked' , true);
    }else {
        $('#website_note_text_first_checkbox').prop('checked' , false);
    }


    if(website_note_text_second.status == 1) {
        $('#website_note_text_second_checkbox').prop('checked' , true);
    }else {
        $('#website_note_text_second_checkbox').prop('checked' , false);
    }

});