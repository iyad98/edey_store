var table_order;

function set_order_status(status) {
    $('.order-status a').removeClass('order-status-active');
    $('.order_status_item_' + status).addClass('order-status-active');
    $('#select_order_status').val(status).trigger('change');
}

var DatatablesDataSourceAjaxServer = {
    init: function () {
        table_order = $("#custom-order-table").DataTable({
           responsive: false,
            "order": [[0, "desc"]],
            dom: 'rtlip',
            searchDelay: 500,
            processing: !0,
            serverSide: !0,
            "searching": false ,
            "language": {
                "processing": pagination.processing ,
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
                url: "/admin/get-store-statistics-ajax",
                data: function (e) {

                    e.status = $('#select_order_status').val();
                    e.payment_method = $('#select_order_payment_method').val();
                    e.shipping_company = $('#select_order_shipping_company').val();
                    e.date_from = $('#date_from').val();
                    e.date_to = $('#date_to').val();
                    e.country_id = $('#select_country').val();
                    e.city_id = $('#select_city').val();



                    e.search_type = $('#select_search_type').val();
                    e.search_value = $('#searchValue').val();


                    /*   e.pharmacy_id = $('.pharmacy_id_hidden').val();
                       e.type = $('#select_order_type').val();
                       e.status = $('#select_order_status').val();*/
                }
            },
            columns: [
                {data: "created_at" , width : "200", orderable : false } ,
                {data: "user_name", name: 'orders.user_name', orderable : false },
                {data: "user_phone", name: 'orders.user_phone', orderable : false },
                {data: "id", orderable : false  } ,
                {data: "products_count", orderable : false  } ,
                {data: "price" , orderable : false } ,
                {data: "total_coupon_price", orderable : false  } ,
                {data: "price_after_discount_coupon", orderable : false  } ,
                {data: "shipping", orderable : false  } ,
                {data: "tax", orderable : false  } ,
                {data: "cash_fees", orderable : false  } ,
                {data: "total_price", orderable : false  } ,
                {data: "shipping_company_name", name: 'order_company_shipping.shipping_company_name', orderable : false },
                {data: "shipment_at", orderable : false  },
                {data: "payment_name", name: 'payment_methods.name_ar', orderable : false },
                {data : "actions" , searchable : false , orderable : false}

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


        $('#select_order_status').change(function () {
            table_order.ajax.reload();
        });
        $('#select_order_payment_method').change(function () {
            table_order.ajax.reload();
        });
        $('#select_order_payment_method').change(function () {
            table_order.ajax.reload();
        });
        $('#select_order_shipping_company').change(function () {
            table_order.ajax.reload();
        });

        $('#select_city').change(function () {
            table_order.ajax.reload();
        });


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
            cancelClass: "btn-secondary" ,
            locale: {
                format: 'YYYY-MM-DD' ,
                cancelLabel: 'رجوع' ,
                applyLabel: 'تطبيق' ,
            },
        }, function (a, t, n) {
            $('#date_from').val(a.format("YYYY-MM-DD"));
            $('#date_to').val(t.format("YYYY-MM-DD"));
            $("#m_daterangepicker_order_date .form-control").val(a.format("YYYY-MM-DD") + " / " + t.format("YYYY-MM-DD"));
            table_order.ajax.reload();
        });
    }
};
jQuery(document).ready(function () {
    $('.order-status a').removeClass('order-status-active');
    $('.order_status_item_-1').addClass('order-status-active');
    DatatablesDataSourceAjaxServer.init();

});
