var table_order;


var DatatablesDataSourceAjaxServer = {
    init: function () {
        table_order = $("#custom-order-table").DataTable({
            // responsive: false,
            dom: 'rtlip',
            "order": [[0, "desc"]],
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
            /*"language":
                 {
                     "processing": '<div id="loading_"></div>',
                 },

             "drawCallback": function( settings ) {
                 $('.m-portlet').removeClass('my-block-overlay');
             },
             */
            ajax: {
                url: "/admin/report-sku-ajax",
                data: function (e) {

                    e.status = $('#select_order_status').val();
                    e.payment_method = $('#select_order_payment_method').val();

                    e.date_from = $('#date_from').val();
                    e.date_to = $('#date_to').val();
                }
            },
            columns: [
                {data: "sku_product" ,name : 'product_variation.sku' } ,
                {data: "sku_product_name" ,name : 'product.name_ar' } ,
                {data: "show_image" ,searchable : false , orderable : false } ,
                {data: "order_id" } ,
                {data: "quantity", name : 'order_products.quantity' },
                {data : "order_status" , searchable : false , orderable : false},
                {data : "order.created_at" , name : 'order.created_at'},
                {data: "payment_name", searchable : false , orderable : false},

            ] ,"lengthMenu": [[ 10,  25 , 50, 100, -1], [ 10,  25 , 50, 100, "All"]]
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
    DatatablesDataSourceAjaxServer.init();

});
