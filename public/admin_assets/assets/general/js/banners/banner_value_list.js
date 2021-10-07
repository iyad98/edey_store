var table;
var DatatablesDataSourceAjaxServer = {
    init: function () {
        table = $("#banner_value-table").DataTable({
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
                url: "get-banner-values-ajax",
                data: function (e) {
                    e.parent_id = parent_id;
                    //   e.slider_id = $('#m_select_slider_form2').val();
                    //   e.category_id = $('#m_select_category_form2').val();
                }
            },
            columns: [
                {data: "id"},
                {data : 'show_image' , searchable: false , orderable : false} ,
                {data : 'show_image_web' , searchable: false , orderable : false} ,
                {data: "name_ar" , name : 'banners.name_ar' },
                {data: "pointer" ,searchable: false , orderable:false , width : "200" },
                {data: "status" ,searchable: false , orderable:false  },
                {data: "actions", searchable: false}
            ]
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