var table_category;
var DatatablesDataSourceAjaxServer = {
    init: function () {
        table_category = $("#category-table").DataTable({
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
                url: "getCategoryAjax",
                data: function (e) {
                    e.type = $('#select_category_type').val();
                    e.parent = $('#m_select2_2').val();
                }
            },
            columns: [
                {data: "id"},
                {data: "show_image" , searchable: false , orderable:false},
               // {data: "name_en"},
                {data: "name_ar"},
              //  {data: "description_en"},
                {data: "description_ar"},
                {data: "parent.name_ar" , name: "parent", searchable: false , orderable:false},
                {data: "actions", searchable: false}
            ]
        });

        $('#searchValue').on( 'keyup', function () {
            table_category.search( this.value ).draw();
        });


        $('#m_select2_2').change(function () {

            vm.get_tree_of_parent($(this).val());
           /* if($(this).val() != -1) {
                $('#show_main_category').text(" : "+$( "#m_select2_2 option:selected" ).text());
            }else {
                $('#show_main_category').text("");
            }*/
            table_category.ajax.reload();
        });


    }
};
jQuery(document).ready(function () {

    DatatablesDataSourceAjaxServer.init()
});
