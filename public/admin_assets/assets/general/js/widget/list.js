var table;
var DatatablesDataSourceAjaxServer = {
    init: function () {
        table = $("#widget").DataTable({
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
                url: "get-widget-ajax",
                data: function (e) {
                    e.city_id = $("#m_select_city_form2").val();
                }
            },
            columns: [
                {data: "id"},
                {data: "name_ar" },
                {data: "name_en"},
                {data: "product_counts" },
                {data: "actions", searchable: false}
            ],
            columnDefs:[
                {
                    targets:-1,
                    render:function (data , type , row) {
                        return "<span class='dropdown'> " +
                        "<a href='widget/"+row['id']+"/edit' class='edit m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill' title='add ads'> " +
                            "<i class='la la-edit'></i> " +
                            "</a>";
                    }
                },
                { "searchable": false, targets : -1 }
            ],
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
