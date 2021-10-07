var table;
var DatatablesDataSourceAjaxServer = {
    init: function () {
        table = $("#slider-table").DataTable({
            responsive: !0,
            dom: 'rtlip',
            searchDelay: 500,
            processing: !0,
            serverSide: !0,
            ajax: {
                url: "get-sliders-ajax",
                data: function (e) {
                    e.slider_id = $('#m_select_slider_form2').val();
                    e.category_id = $('#m_select_category_form2').val();
                }
            },
            columns: [
                {data: "id"},
                {data : 'show_image' , searchable: false , orderable : false} ,
                {data : 'show_image_web' , searchable: false , orderable : false} ,

                // {data: "display_name_en" , name : 'sliders.name_en' },
                {data: "display_name_ar" , name : 'sliders.name_ar' },
                {data: "pointer" ,searchable: false , orderable:false , width : "200" },
                {data: "parent.name_ar" , name: "parent", searchable: false , orderable:false},
                {data: "status" , class : 'status'},
                {data: "actions", searchable: false}
            ]
        });

        $('#searchValue').on( 'keyup', function () {
            table.search( this.value ).draw();
        });

        $("#m_select_slider_form2").change(function () {
            table.ajax.reload();

        });
        $("#m_select_category_form2").change(function () {
            table.ajax.reload();

        });
    }
};
jQuery(document).ready(function () {

    DatatablesDataSourceAjaxServer.init()
});
