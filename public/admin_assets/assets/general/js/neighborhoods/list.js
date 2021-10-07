var table;
var DatatablesDataSourceAjaxServer = {
    init: function () {
        table = $("#neighborhood-table").DataTable({
            responsive: !0,
            searchDelay: 500,
            processing: !0,
            serverSide: !0,
            ajax: {
                url: "get-neighborhoods-ajax",
                data: function (e) {
                    e.city_id = $('#m_select_city_form2').val();
                }
            },
            columns: [
                {data: "id"},
                {data: "name_ar"},
                {data: "name_en"},
                {data: "city_name" , name : 'cities.name_ar'},
                {data: "actions", searchable: false}
            ]
        });

        $("#m_select_city_form2").change(function () {
            table.ajax.reload();

        });
    }
};
jQuery(document).ready(function () {

    DatatablesDataSourceAjaxServer.init()
});