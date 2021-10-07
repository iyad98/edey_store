var table;
var DatatablesDataSourceAjaxServer = {
    init: function () {
        table = $("#mailing-list-table").DataTable({
            responsive: !0,
            searchDelay: 500,
            processing: !0,
            serverSide: !0,
            // dom: 'rtlip',
            "language": {
                "processing": pagination.processing ,
                "search": pagination.search,
                "lengthMenu": pagination.lengthMenu,
                "info": pagination.info,
                sZeroRecords: pagination.sZeroRecords,
            },
            ajax: {
                url: "get-mailing-list-ajax",
                data: function (e) {

                }
            },
            columns: [
                {data: "id"},
                {data: "email"},
            ]
            ,"dom": "<'row' <'col-md-2'l> <'col-md-10'B>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
            select: {style: 'multi'},
            buttons: [
                'selectAll',

                'selectNone',
                'print',
                'csv',
                'excel',


            ],
        });

        $('#searchValue').on( 'keyup', function () {
            table.search( this.value ).draw();
        });


    }
};
jQuery(document).ready(function () {

    DatatablesDataSourceAjaxServer.init()
});
