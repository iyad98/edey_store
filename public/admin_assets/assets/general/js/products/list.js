var table_product;

function get_sort_by() {
    var value = $('#select_sort_status').val();

    if(value == 1) {
        return {key : 0 , order : 'desc'};
    }else if(value == 2) {
        return {key : 0 , order : 'asc'};
    }else {
        return {key : 2 , order : 'desc'};
    }


}
var DatatablesDataSourceAjaxServer = {
    init: function () {
        table_product = $("#product-table").DataTable({
           // responsive: !0,
            searchDelay: 500,
            processing: !0,
            serverSide: !0,
            "drawCallback": function( settings ) {
                filter_product.loading = false;
            },
            'aaSorting': [[get_sort_by().key , get_sort_by().order], [0, 'desc']],
           // "order": [get_sort_by().key ,get_sort_by().order ],
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
            ajax: {
                url: "get-products-ajax",
                data: function (e) {
                    e.category_id = $("#select_categories").val();
                    e.stock_status_id = $("#select_stock_status").val();
                    e.brand_id = $("#select_brands").val();
                    e.is_variation = $("#select_product_type_status").val();
                }
            },

            columns: [

                {data: "id" },
                {data: "show_image" , searchable: false , orderable:false},
                {data: "name_ar"},
                {data: "price" , searchable: false , orderable:false},
                {data: "price_after" , searchable: false , orderable:false},
                {data: "discount_rate" , searchable: false , orderable:false},
                {data: "categories" , searchable: false , orderable:false},
                {data: "stock_status" , searchable: false , orderable:false},
                {data: "automatic_coupon" , searchable: false , orderable:false},
                {data: "in_archive" , searchable: false , orderable:true},
                {data: "actions", searchable: false},
            ],

            "lengthMenu": [[ 10,  25 , 50, 100, -1], [ 10,  25 , 50, 100, "All"]],
            "dom": "<'row' <'col-md-2'l> <'col-md-10'B>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
            select: {
                style: 'multi'
            },
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

        $('#select_sort_status').change(function () {
            var value = $(this).val();
            var sort = get_sort_by();
            table_product
                .order( [sort.key , sort.order ] );

        });

        $('#searchValue').on( 'keyup', function () {
            table_product.search( this.value ).draw();
        });
    }
};
jQuery(document).ready(function () {

    DatatablesDataSourceAjaxServer.init();
});
