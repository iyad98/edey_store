var table_user;
var DatatablesDataSourceAjaxServer = {
    init: function () {
        table_user = $("#user").DataTable({



            responsive: !0,
            searchDelay: 500,
            processing: !0,
            serverSide: !0,

            "lengthMenu": [[ 10,  25 , 50, 100, -1], [ 10,  25 , 50, 100, "All"]],
            "dom": "<'row' <'col-md-2'l> <'col-md-10'B>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
            select: {
                style: 'multi'
            },
            buttons: [
                'selectAll',
                'colvis',
                'selectNone',
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [':visible:not(:last-child)' ]
                    }
                },

                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [':visible:not(:last-child)' ]
                    }
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [':visible:not(:last-child)' ]
                    }
                }

            ],
            order : [0 , "desc"],
            "language": {
                "processing": pagination.processing ,
                "search": pagination.search,
                "lengthMenu": pagination.lengthMenu,
                "info": pagination.info,
                sZeroRecords: pagination.sZeroRecords,
                buttons: {
                    selectAll: "تحديد الكل",
                    selectNone: "الغاء التحديد",
                    colvis:'تحديد عمود',
                }
            },
           
           
            ajax: {
                url: "getUserAjax",
                data: function (e) {
                    e.status = $('#select_status').val()
                }
            },
            columns: [
                {data: "id"},
                {data: "show_image" , searchable: false , orderable:false},
                {data: "first_name"},
                {data: "last_name"},
                {data: "email"},
                {data: "phone"},
                {data : "package_name", name : 'packages.name_ar'},
                {data: "status" , class : 'status'},
                {data: "actions", searchable: false}
            ]
        });

        $('#searchValue').on( 'keyup', function () {
            table_user.search( this.value ).draw();
        });


        $('#select_status').change(function () {
            table_user.ajax.reload();
        });
    }
};
jQuery(document).ready(function () {
    DatatablesDataSourceAjaxServer.init()
});
