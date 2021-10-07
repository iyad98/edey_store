var table;
var DatatablesDataSourceAjaxServer = {
    init: function () {
        table = $("#attribute-value-table").DataTable({
            responsive: !0,
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
                url: "get-attribute-values-ajax",
                data: function (e) {
                    e.attribute_id = attribute.id;
                }
            },
            columns: [
                {data: "id"},
                {data: "name_ar"},
               // {data: "name_en"},
                {data: "view_value" , searchable: false , orderable : false},
                /*
                {data: "attribute_name" , name : 'attributes.name_ar'},
                */
                {data: "actions", searchable: false}
            ]
        });

    }
};
jQuery(document).ready(function () {

    DatatablesDataSourceAjaxServer.init()
});