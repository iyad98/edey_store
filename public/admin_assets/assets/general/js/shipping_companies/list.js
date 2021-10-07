var table;
var DatatablesDataSourceAjaxServer = {
    init: function () {
        table = $("#shipping-company-table").DataTable({
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
                url: "get-shipping-companies-ajax",
                data: function (e) {
                    e.city_id = $("#m_select_city_form2").val();
                }
            },
            columns: [
                {data: "id"},
                {data : 'show_image' , searchable: false , orderable : false},
                {data: "name_ar" },
                {data: "phone" },
                {data: "show_status" , class : 'status' ,  searchable: false , orderable : false},
                // {data: "name_en"},
                {data: "actions", searchable: false}
            ]
        });

        $('#searchValue').on( 'keyup', function () {
            table.search( this.value ).draw();
        });

        $("#m_select_city_form2").change(function () {
            table.ajax.reload();
        });
    }
};
jQuery(document).ready(function () {

    DatatablesDataSourceAjaxServer.init()
});
