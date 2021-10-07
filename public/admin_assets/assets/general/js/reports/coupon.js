var table_order;

function set_order_status(status) {
    $('.order-status a').removeClass('order-status-active');
    $('.order_status_item_' + status).addClass('order-status-active');
    $('#select_order_status').val(status).trigger('change');
}

var DatatablesDataSourceAjaxServer = {
    init: function () {
        table_order = $("#order-table").DataTable({
            responsive: false,
            dom: 'rtlip',
            "order": [[0, "desc"]],
            searchDelay: 500,
            processing: !0,
            serverSide: !0,
            /*
            dom: "<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>\n\t\t\t<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
            buttons: ["print", "copyHtml5", "excelHtml5", "csvHtml5", "pdfHtml5"],
            */
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
            "searching": false,
            /*"language":
                 {
                     "processing": '<div id="loading_"></div>',
                 },

             "drawCallback": function( settings ) {
                 $('.m-portlet').removeClass('my-block-overlay');
             },
             */
            ajax: {
                url: "/admin/get-coupon-bill-ajax",
                data: function (e) {

                    //   e.status = $('#select_order_status').val();
                    //    e.payment_method = $('#select_order_payment_method').val();

                    e.date_from = $('#date_from').val();
                    e.date_to = $('#date_to').val();

                    /*   e.pharmacy_id = $('.pharmacy_id_hidden').val();
                       e.type = $('#select_order_type').val();
                       e.status = $('#select_order_status').val();*/
                }
            },
            columns: [
                {data: "coupon", searchable: false, orderable: false},
                {data: "value", searchable: false, orderable: false},
                {data: "user_famous_rate", searchable: false, orderable: false},
                {data: "orders_count", searchable: false, orderable: false},
                {data: "checked_count", searchable: false, orderable: false},
                {data: "order_discount_price", searchable: false, orderable: false},
                {data: "pending_orders", searchable: false, orderable: false},
                {data: "pending_orders_price", searchable: false, orderable: false},
                {data: "confirm_orders", searchable: false, orderable: false},
                {data: "confirm_orders_price", searchable: false, orderable: false},
                {data: "user_famous_price", searchable: false, orderable: false},
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


        /*
        $('#select_order_status').change(function () {
            //  $('.m-portlet').addClass('my-block-overlay');
            table_order.ajax.reload();
        });
        $('#select_order_payment_method').change(function () {
            //  $('.m-portlet').addClass('my-block-overlay');
            table_order.ajax.reload();
        });

*/
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
            table_order.ajax.reload();
        });
    }
};
jQuery(document).ready(function () {
    $('.order-status a').removeClass('order-status-active');
    $('.order_status_item_-1').addClass('order-status-active');
    DatatablesDataSourceAjaxServer.init();

});
