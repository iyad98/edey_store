var table;
var DatatablesDataSourceAjaxServer = {
    init: function () {
        table = $("#order-bank-table").DataTable({
            responsive: !0,
            searchDelay: 500,
            processing: !0,
            serverSide: !0,
             "order": [0 ,'desc' ],
            dom: 'rtlip',
            "language": {
                "processing": pagination.processing ,
                "search": pagination.search,
                "lengthMenu": pagination.lengthMenu,
                "info": pagination.info,
                sZeroRecords: pagination.sZeroRecords,
            },
            ajax: {
                url: "get-order-bank-ajax",
                data: function (e) {
                }
            },
            columns: [
                {data: "id"},
                {data: "order_id"},
                {data: "file"},
                {data: "name"},
                {data: "account_number"},
                {data: "price"},
                {data: "bank_name" , name : 'banks.name_ar'},
                {data: "actions", searchable: false}
            ]
        });
        $('#searchValue').on( 'keyup', function () {
            table.search( this.value ).draw();
        });

    }
};
jQuery(document).ready(function () {

    DatatablesDataSourceAjaxServer.init()
});
