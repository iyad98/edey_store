var table;
var DatatablesDataSourceAjaxServer = {
    init: function () {
        table = $("#package-table").DataTable({
            responsive: !0,
            dom: 'rtlip',
            searchDelay: 500,
            processing: !0,
            serverSide: !0,
            "language": {
                "processing": pagination.processing ,
                "search": pagination.search,
                "lengthMenu": pagination.lengthMenu,
                "info": pagination.info,
                sZeroRecords: pagination.sZeroRecords,
            },
            ajax: {
                url: "get-packages-ajax",
                data: function (e) {

                }
            },
            columns: [
                {data: "id"},
                {data : 'show_image' , searchable: false , orderable : false} ,
                {data: "name_ar"},
                {data: "price_from"},
                {data: "price_to"},
                {data: "discount_rate"},
                {data: "replace_hours"},
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
