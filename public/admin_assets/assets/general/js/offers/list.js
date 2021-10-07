var table_offer;
var DatatablesDataSourceAjaxServer = {
    init: function () {
        table_offer = $("#offer-table").DataTable({
            responsive: !0,
            searchDelay: 500,
            processing: !0,
            serverSide: !0,
            ajax: {
                url: "getOfferAjax",
                data: function (e) {
                    e.status = $('#select_status').val();
                }
            },
            columns: [
                {data: "id"},
                {data: "show_image" , searchable: false , orderable:false},
                {data: "name_en"},
                {data: "name_ar"},
                {data: "discount_rate_text" , name : 'discount_rate' },
                {data: "status"},
                {data: "actions", searchable: false}
            ]
        });

        $('#select_status').change(function () {
            table_offer.ajax.reload();
        });

    }
};
jQuery(document).ready(function () {

    DatatablesDataSourceAjaxServer.init()
});