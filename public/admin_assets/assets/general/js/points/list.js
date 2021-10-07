var table;
var DatatablesDataSourceAjaxServer = {
    init: function () {
        table = $("#points-table").DataTable({
            responsive: !0,
            searchDelay: 500,
            processing: !0,
            serverSide: !0,

            // buttons: [
            //     {
            //         extend: 'print',
            //         autoPrint: false,
            //         text: 'Print',
            //         exportOptions: {
            //             rows: function ( idx, data, node ) {
            //                 var dt = new $.fn.dataTable.Api('#example' );
            //                 var selected = dt.rows( { selected: true } ).indexes().toArray();
            //
            //                 if( selected.length === 0 || $.inArray(idx, selected) !== -1)
            //                     return true;
            //
            //
            //                 return false;
            //             }
            //         }
            //     }
            //
            // ],
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
                url: "get-user-points-ajax",
                data: function (e) {

                }
            },
            columns: [
                {data: "id", name: 'id'},
                {data: "first_name"},
                {data: "phone"},
                {data: "points_count", searchable : false ,sortable:false},
                {data: "action" , searchable : false,sortable:false},

            ]
            ,"dom": "<'row' <'col-md-2'l> <'col-md-10'B>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
            select: {style: 'multi'},
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

        });

        $('#searchValue').on( 'keyup', function () {
            table.search( this.value ).draw();
        });


    }
};

var vm = new Vue({
    el: '#app',
    data: {

    },

    methods: {

        increase_point: function (user , point) {
            axios.post(get_url + "/admin/users/increase_point",
                {
                    id: user.id,
                    point : point,
                }
            ).then(function (res) {

                var get_res = handle_response(res.data);
                if (get_res) {
                    swal(translations['success'], translations['success'], "success");
                    table.ajax.reload();
                }else {
                    swal("خطأ", res.data['error_msg'], "error");
                }

            }).catch(function (err) {
                vm.loading = false;
            });
        }
    }
});


jQuery(document).ready(function () {

    DatatablesDataSourceAjaxServer.init()

    table.on('click', '.point_action', function () {

        var row = $(this).closest('tr');
        if(row.attr('role') == undefined) {
            row = $(this).parent('tr'['role=row']);
        }
        swal({
            title: translations['sure_increase_point'],
            text: "",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: translations['yes'],
            cancelButtonText:translations['no_delete'],
            reverseButtons: !0,
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off',
            },
            inputPlaceholder: "عدد النقاط"

        }).then(function (e ) {

            if(e.value) {
                vm.increase_point(table.row(row).data(),e.value);

            }else {
                e.dismiss && swal(translations['cancelled_delete'], translations['didnt_delete'], "error")
            }

        });
    });
});
