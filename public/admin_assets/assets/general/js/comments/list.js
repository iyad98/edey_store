var table;
var DatatablesDataSourceAjaxServer = {
    init: function () {
        table = $("#comment-table").DataTable({
            responsive: !0,
            searchDelay: 500,
            processing: !0,
            dom: 'rtlip',
            serverSide: !0,
            orderBy : [0  ,'desc'],
            "language": {
                "processing": pagination.processing ,
                "search": pagination.search,
                "lengthMenu": pagination.lengthMenu,
                "info": pagination.info,
                sZeroRecords: pagination.sZeroRecords,
            },
            ajax: {
                url: "get-comments-ajax",
                data: function (e) {
                    e.get_comment_status = vm.get_comment_status;
                }
            },
            columns: [
                {data : "id" , class : 'hidden'},
                {data : 'user_data' , name : 'user.first_name'} ,
                {data : 'user.last_name' , name : 'user.last_name' , class : 'hidden'} ,
                {data : 'user.email' , name : 'user.email' , class : 'hidden'} ,

                {data: "comment" , width : 400},
                {data: "product.name" , name : 'product.name_ar'},
                {data : 'created_at'},
                {data: "actions", searchable: false}
            ]
        });

        $('#searchValue').on( 'keyup', function () {
            table.search( this.value ).draw();
        });

    }
};
jQuery(document).ready(function () {

    DatatablesDataSourceAjaxServer.init()
});
