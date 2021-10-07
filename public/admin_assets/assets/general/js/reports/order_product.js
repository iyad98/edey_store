$(document).ready(function () {


    $('#select_search_type').change(function () {
        let value = $(this).val();
        if(value == 1) {
            $('.search_product_div').removeClass('hidden');
            $('.search_sku_div').addClass('hidden');
        }else {
            $('.search_product_div').addClass('hidden');
            $('.search_sku_div').removeClass('hidden');
        }
    });


    $('#general_search').click(function () {
        var params = {
            start_at : $('#date_from').val() ,
            end_at : $('#date_to').val() ,
        };
        if($('#select_search_type').val() == 1) {
            params['product_id'] = $('#m_select_remote_products').val();
        }else {
            params['product_variation_id'] = $('#m_select_remote_sku').val();
        }
        var str = jQuery.param( params );
        window.location = "?"+str;
    });
    $("#m_select_remote_products").select2({
        placeholder: "ابحث عن المنتجات",
        allowClear: !0,
        ajax: {
            // url: "https://api.github.com/search/repositories",
            url: get_url + "/admin/get-details-products-ajax",
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
            if (e.loading) return "جار البحث ...";
            return e.name || e.text;
        },
        templateSelection: function (e) {
            return e.name || e.text;
        },
    });
    $("#m_select_remote_sku").select2({
        placeholder: "ابحث عن رمز المخزون",
        allowClear: !0,
        ajax: {
            // url: "https://api.github.com/search/repositories",
            url: get_url + "/admin/get-sku-products-ajax",
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
            if (e.loading) return "جار البحث ...";
            if(e.product) {
                return  e.sku+"( "+ (e.product ? e.product.name : '') +" )"
            }else {
                return e.text;
            }
        },
        templateSelection: function (e) {
            if(e.product) {
                return  e.sku+"( "+ (e.product ? e.product.name : '') +" )"
            }else {
                return e.text;
            }
        },
    });

    if(type_product != 0) {
        $('#select_search_type').val(type_product);
        $('#select_search_type').change();
    }


    if(product != "") {
        $('#m_select_remote_products').append(new Option(product.name, product.id, true, true));
    }
    if(product_variation != "") {
        $('#m_select_remote_sku').append(new Option(product_variation.sku+"( "+ (product_variation.product ? product_variation.product.name : '') +" )", product_variation.id, true, true));
    }
});