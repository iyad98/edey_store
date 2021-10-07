var table_company;
var DatatablesDataSourceAjaxServer = {
    init: function () {
        table_company = $("#company-table").DataTable({
            responsive: !0,
            searchDelay: 500,
            processing: !0,
            serverSide: !0,
            ajax: {
                url: "getCompaniesAjax",
                data: function (e) {
                   // e.status = $('#select_status').val();
                }
            },
            columns: [
                {data: "id"},
                {data: "name_en"},
                {data: "name_ar"},
                {data: "type_text"},
                {data: "actions", searchable: false}
            ]
        });


    }
};
jQuery(document).ready(function () {

    DatatablesDataSourceAjaxServer.init()
});