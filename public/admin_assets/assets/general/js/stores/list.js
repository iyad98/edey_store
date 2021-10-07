var table;
var DatatablesDataSourceAjaxServer = {
    init: function () {
        table = $("#store-table").DataTable({
            responsive: !0,
            searchDelay: 500,
            dom: 'rtlip',
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
                url: "get-stores-ajax",
                data: function (e) {
                    //  e.country_id = $('#m_select_country_form2').val();
                }
            },
            columns: [
                {data: "id"},
                {data: "name_ar"},
                {data: "city.name" , name : 'city.name'},
                {data : 'phone' },
                {data : 'address_ar' },
                {data: "actions", searchable: false}
            ]
        });

        $('#searchValue').on( 'keyup', function () {
            table.search( this.value ).draw();
        });

    }
};
jQuery(document).ready(function () {
    DatatablesDataSourceAjaxServer.init();
});
