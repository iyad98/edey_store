var DatatablesDataSourceAjaxServer = {
    init: function () {
        var table = $("#m_table_1").DataTable({
            responsive: !0,
            searchDelay: 500,
            processing: !0,
            serverSide: !0,
            ajax: {
                url: "http://localhost/wajbati/public/admin/getUserAjax",
                data: function (e) {
                    // e.test = "Brad Mueller IV";
                }
            },
            columns: [
                {data: "id"},
                {data: "name"},
                {data: "username"},
                {data: "phone"},
                {data: "email"},
                {data: "status"},

                {data: "Actions", searchable: false}
            ],
            columnDefs: [
                {
                    targets: -1, title: "Actions", orderable: !1, render: function (a, e, t, n) {
                    return '\n                        <span class="dropdown">\n                            <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">\n                              <i class="la la-ellipsis-h"></i>\n                            </a>\n                            <div class="dropdown-menu dropdown-menu-right">\n                                <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>\n                                <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>\n                                <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>\n                            </div>\n                        </span>\n                        <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View">\n                          <i class="la la-edit"></i>\n                        </a>'
                }
                },
                {

                    targets: 5, render: function (a, e, t, n) {
                    var s = {
                        1: {title: "مفعل", class: " m-badge--success"},
                        0: {title: "غير مفعل", class: " m-badge--danger"},

                    };
                    return void 0 === s[a] ? a : '<span class="m-badge ' + s[a].class + ' m-badge--wide">' + s[a].title + "</span>"
                }
                },
                /*
                {
                    targets: 9, render: function (a, e, t, n) {
                    var s = {
                        1: {title: "Online", state: "danger"},
                        2: {title: "Retail", state: "primary"},
                        3: {title: "Direct", state: "accent"}
                    };
                    return void 0 === s[a] ? a : '<span class="m-badge m-badge--' + s[a].state + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + s[a].state + '">' + s[a].title + "</span>"
                }
                }*/
            ]
        });

    }
};
jQuery(document).ready(function () {
    DatatablesDataSourceAjaxServer.init()
});