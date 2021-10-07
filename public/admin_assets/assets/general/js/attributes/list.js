var table;
var DatatablesDataSourceAjaxServer = {
    init: function () {
        table = $("#attribute-table").DataTable({
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
                url: "get-attributes-ajax",
                data: function (e) {
                    e.attribute_type_id = $('#select_type').val();
                }
            },
            columns: [
                {data: "id"},
                {data: "name_ar_link" , name : 'name_ar'},
                //{data: "name_en_link" , name : 'name_en'},
                {data: "attribute_type_name" , name : 'attribute_types.name_ar'},
                {data: "actions", searchable: false}
            ]
        });

        $("#select_type").change(function () {
            table.ajax.reload();

        });

        $('#searchValue').on( 'keyup', function () {
            table.search( this.value ).draw();
        });
    }
};
jQuery(document).ready(function () {

    DatatablesDataSourceAjaxServer.init()
});
