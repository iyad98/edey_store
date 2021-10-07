var table;
var DatatablesDataSourceAjaxServer = {
    init: function () {
        table = $("#cancel_reasons").DataTable({
            responsive: !0,
            searchDelay: 500,
            processing: !0,
            serverSide: !0,
            dom: 'rtlip',
            "language": {
                "processing": pagination.processing ,
                "search": pagination.search,
                "lengthMenu": pagination.lengthMenu,
                "info": pagination.info,
                sZeroRecords: pagination.sZeroRecords,
            },
            ajax: {
                url: "get-cancel-reasons-ajax",
                data: function (e) {

                }
            },
            columns: [
                {data: "id"},
                {data: "title_ar"},
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
