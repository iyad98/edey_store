var table_coupon;
var DatatablesDataSourceAjaxServer = {
    init: function () {
        table_coupon = $("#coupon-table").DataTable({
            responsive: !0,
            searchDelay: 500,
            processing: !0,
            dom: 'rtlip',
            serverSide: !0,
            "language": {
                "processing": pagination.processing ,
                "search": pagination.search,
                "lengthMenu": pagination.lengthMenu,
                "info": pagination.info,
                sZeroRecords: pagination.sZeroRecords,
            },
            ajax: {
                url: "get-coupons-ajax",
                data: function (e) {
                    e.status = $('#select_status').val();
                }
            },
            columns: [
                {data: "id"},
                {data: "coupon" },
                {data: "show_status" , searchable: false , orderable : false },
                {data: "orders_count" , searchable: false , },
                {data: "value" },
                {data: "min_price" },
                {data: "max_used" },
                {data: "type.name_ar" , name : "type.name_ar"},
                {data: "start_at_edit" ,name : 'start_at' ,searchable: false },
                {data: "end_at_edit" ,name : 'end_at' , searchable: false },
                {data: "actions", searchable: false}
            ]
        });

        $('#searchValue').on( 'keyup', function () {
            table_coupon.search( this.value ).draw();
        });


        $('#select_status').change(function () {
            table_coupon.ajax.reload();
        });


    }
};
jQuery(document).ready(function () {

    DatatablesDataSourceAjaxServer.init()
});
