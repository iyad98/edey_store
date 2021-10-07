var table_admin;
var DatatablesDataSourceAjaxServer = {
    init: function () {
        table_admin = $("#admin").DataTable({
            responsive: false,
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
                url: "getAdminAjax",
                data: function (e) {
                    e.status = $('#select_status').val();
                    e.role = $('#select_role_search').val();
                }
            },
            columns: [
                {data: "admin_id"},
                {data: "show_image" , searchable: false , orderable:false},
                {data: "admin_name"},
                {data: "admin_username"},
                {data: "admin_phone"},
                {data: "admin_email"},
                {data: "role_name" , searchable: false , orderable:false},
                {data: "admin_status" , class : 'status'},
                {data: "actions", searchable: false}
            ]
        });

        $('#searchValue').on( 'keyup', function () {
            table_admin.search( this.value ).draw();
        });


        $('#select_status').change(function () {
            table_admin.ajax.reload();
        });
        $('#select_role_search').change(function () {
            table_admin.ajax.reload();
        });
    }
};
jQuery(document).ready(function () {
    DatatablesDataSourceAjaxServer.init()
});
