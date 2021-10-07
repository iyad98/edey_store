var table_order;

function set_order_status(status) {
    $('.order-status a').removeClass('order-status-active');
    $('.order_status_item_' + status).addClass('order-status-active');
    $('#select_order_status').val(status).trigger('change');
}

var columns =  [
    {data: has_option ? "options" : "linkable_order_id", name: 'orders.id', orderable: false , searchable: false},
    {data: "linkable_name", name: 'orders.user_name'},
    {data: "order_status", name: 'orders.status' , searchable: false},
    {data: "phone", name: 'orders.user_phone'},
    {data: "payment_name", name: 'payment_methods.name_ar' , searchable: false},
    {data: "total_price", name: 'orders.total_price'},
    {data: "created_at"},
    {data: "platform", name: 'orders.platform' , searchable: false},
    {data: "shipping_company_name", name: 'order_company_shipping.shipping_company_name' , searchable: false},
    {data: "shipment_at" , searchable: false},

];

var DatatablesDataSourceAjaxServer = {
    init: function () {
        table_order = $("#order-table").DataTable({
            responsive: false,
            "order": [[6, "desc"]],
            searchDelay: 500,
            processing: !0,

            serverSide: !0,
            "language": {
                "processing": pagination.processing,
                "search": pagination.search,
                "lengthMenu": pagination.lengthMenu,
                "info": pagination.info,
                sZeroRecords: pagination.sZeroRecords,
                buttons: {
                    selectAll: "تحديد الكل",
                    selectNone: "الغاء التحديد",
                    colvis:'تحديد عمود',
                }
            },
            "drawCallback": function (settings) {
                order_vue.order_ids = [];
                order_vue.search_loading = false;
            },
            /*"language":
                 {
                     "processing": '<div id="loading_"></div>',
                 },

             "drawCallback": function( settings ) {
                 $('.m-portlet').removeClass('my-block-overlay');
             },
             */

            ajax: {
                url: "/admin/get-orders-ajax",
                data: function (e) {

                    e.deleted = deleted;
                    e.type_product_id = type_product_id;
                    e.type_product    = type_product;

                    e.status = $('#select_order_status').val();
                    e.payment_method = $('#select_order_payment_method').val();
                    e.shipping_company = $('#select_order_shipping_company').val();


                    e.country_id = $('#select_country').val();
                    e.city_id = $('#select_city').val();
                    e.platform = $('#select_platform').val();


                    e.date_from = $('#date_from').val();
                    e.date_to = $('#date_to').val();

                    e.search_type = $('#select_search_type').val();
                    e.search_value = $('#searchValue').val();


                    e.is_return = is_return;

                    /*   e.pharmacy_id = $('.pharmacy_id_hidden').val();
                       e.type = $('#select_order_type').val();
                       e.status = $('#select_order_status').val();*/
                }
            },
            columns: columns ,
            columnDefs:[
                {
                    targets:0,
                },
            ]
            ,"lengthMenu": [[ 10,  25 , 50, 100, -1], [ 10,  25 , 50, 100, "All"]]
            ,"dom": "<'row' <'col-md-2'l> <'col-md-10'B>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
            select: {style: 'multi'},
            buttons: [
                'selectAll',
                'colvis',
                'selectNone',
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [':visible:not(:last-child)' ]
                    }
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [':visible:not(:last-child)' ]
                    }
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [':visible:not(:last-child)' ]
                    }
                }

            ],

        });

        function inArray(needle, haystack) {
            var length = haystack.length;
            for(var i = 0; i < length; i++) {
                if(haystack[i] == needle) return true;
            }
            return false;
        }

        $('#select_search_type').on('change', function () {
            let placeholder = "ابحث";

            switch ($(this).val()) {
                case "1" :
                    placeholder = "ابحث";
                    break;
                case "2" :
                    placeholder = "رقم الطلب";
                    break;
                case "3" :
                    placeholder = "رقم الجوال";
                    break;
                case "4" :
                    placeholder = "المبلغ الاجمالي";
                    break;
            }
            $('#searchValue').prop('placeholder', placeholder);
        });


        $("#m_daterangepicker_order_date").daterangepicker({
            buttonClasses: "m-btn btn",
            applyClass: "btn-primary",
            cancelClass: "btn-secondary",
            locale: {
                format: 'YYYY-MM-DD',
                cancelLabel: 'رجوع',
                applyLabel: 'تطبيق',
            },
        }, function (a, t, n) {
            $('#date_from').val(a.format("YYYY-MM-DD"));
            $('#date_to').val(t.format("YYYY-MM-DD"));
            $("#m_daterangepicker_order_date .form-control").val(a.format("YYYY-MM-DD") + " / " + t.format("YYYY-MM-DD"));
        });

    }

};
jQuery(document).ready(function () {
    $('.order-status a').removeClass('order-status-active');
    $('.order_status_item_-1').addClass('order-status-active');
    DatatablesDataSourceAjaxServer.init();


    // checkbox
    $('#check_all').change(function () {
        var if_checked = this.checked;
        order_vue.order_ids = [];
        table_order.rows().every(function (rowIdx, tableLoop, rowLoop) {
            var data = this.data();
            $('#option-row-' + (data.id)).prop('checked', if_checked);
            if (if_checked) {
                order_vue.order_ids.push(data.id);
            }
        });
    });
    table_order.on('change', '.option-row', function () {
        let if_all_checked = true;
        order_vue.order_ids = [];
        table_order.rows().every(function (rowIdx, tableLoop, rowLoop) {

            var data = this.data();
            if (!$('#option-row-' + (data.id)).is(":checked")) {
                if_all_checked = false;
            } else {
                order_vue.order_ids.push(data.id);
            }

        });
        if (if_all_checked) {
            $('#check_all').prop('checked', true);
        } else {
            $('#check_all').prop('checked', false);
        }

    });
});
