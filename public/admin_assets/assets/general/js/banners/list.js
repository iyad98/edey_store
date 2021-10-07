var table;
var DatatablesDataSourceAjaxServer = {
    init: function () {
        table = $("#banner-table").DataTable({
            responsive: !0,
            searchDelay: 500,
            processing: !0,
            dom: 'rtlip',
            serverSide: !0,
            "language": {
                "processing": pagination.processing ,
                "search": pagination.search,
                "lengthMenu": pagination.lengthMenu,
                "info": pagination.info,
                sZeroRecords: pagination.sZeroRecords,
            },
            ajax: {
                url: "get-banners-ajax",
                data: function (e) {
                 //   e.slider_id = $('#m_select_slider_form2').val();
                 //   e.category_id = $('#m_select_category_form2').val();
                }
            },
            columns: [
                {data: "id"},
                {data: "display_name_ar" , name : 'banners.name_ar' },
                {data: "type" , searchable: false , orderbale : false},
                {data: "status" , class : 'status'},
                {data: "actions", searchable: false}
            ]
        });

        $('#searchValue').on( 'keyup', function () {
            table.search( this.value ).draw();
        });

        /*
        $("#m_select_slider_form2").change(function () {
            table.ajax.reload();

        });
        $("#m_select_category_form2").change(function () {
            table.ajax.reload();

        });
        */
    }
};
jQuery(document).ready(function () {

    DatatablesDataSourceAjaxServer.init()
});
