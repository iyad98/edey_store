var table;
var DatatablesDataSourceAjaxServer = {
    init: function () {
        table = $("#contact-table").DataTable({
            responsive: !0,
            dom: 'rtlip',
            searchDelay: 500,
            processing: !0,
            serverSide: !0,
            "order": [[4, "desc"]],
            "language": {
                "processing": pagination.processing ,
                "search": pagination.search,
                "lengthMenu": pagination.lengthMenu,
                "info": pagination.info,
                sZeroRecords: pagination.sZeroRecords,
            },
            ajax: {
                url: "get-contacts-ajax",
                data: function (e) {

                }
            },
            columns: [
                {data: "id"},
                {data : 'name' } ,
                {data: "email"},
                {data: "message"},
                {data: "created_at"},

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
