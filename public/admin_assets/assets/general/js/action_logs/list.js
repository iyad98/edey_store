var table_notification;
var DatatablesDataSourceAjaxServer = {
    init: function () {
        table_notification = $("#action-logs-table").DataTable({
            responsive: !0,
            searchDelay: 500,
            processing: !0,
            serverSide: !0,
            order: [[2, "desc"]],
            ajax: {
                url: get_url+"/admin/get-action-logs-ajax",
                data: function (e) {
                    e.date_from =  $('#date_from').val();
                    e.date_to =  $('#date_to').val();

                },

            },
            columns: [
                {data: "admin.admin_email" , name : "admin.admin_email"},
                {data: "description" , searchable : false},
                {data: "created_at"},
            ]
        });


        $("#m_daterangepicker_order_date").daterangepicker({
            buttonClasses: "m-btn btn",
            applyClass: "btn-primary",
            cancelClass: "btn-secondary"
        }, function (a, t, n) {
            $('#date_from').val(a.format("YYYY-MM-DD"));
            $('#date_to').val(t.format("YYYY-MM-DD"));
            $("#m_daterangepicker_order_date .form-control").val(a.format("YYYY-MM-DD") + " / " + t.format("YYYY-MM-DD"));
            table_notification.ajax.reload();
        });

    }
};
jQuery(document).ready(function () {

    DatatablesDataSourceAjaxServer.init();

});