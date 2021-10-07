var table;
var DatatablesDataSourceAjaxServer = {
    init: function () {
        table = $("#shipping-company-table").DataTable({
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
            "drawCallback": function( settings ) {
                vm.shipping_city_ids = [];
            },
            ajax: {
                url: get_url+"/admin/get-shipping-company-cities-ajax",
                data: function (e) {
                    e.shipping_company_country_id = $('#get_shipping_company_country_id').val();
                }
            },
            columns: [
                {data: "options", name: 'city.name_ar', orderable: false},
                {data : 'cash_status' , name : 'shipping_company_cities.cash'} ,
                {data: "actions", searchable: false}
            ]
        });

        $('#searchValue').on( 'keyup', function () {
            table.search( this.value ).draw();
        });

    }
};
jQuery(document).ready(function () {

    DatatablesDataSourceAjaxServer.init();

    // checkbox
    $('#check_all').change(function () {
        var if_checked = this.checked;
        vm.shipping_city_ids = [];
        table.rows().every(function (rowIdx, tableLoop, rowLoop) {
            var data = this.data();
            $('#option-row-' + (data.id)).prop('checked', if_checked);
            if(if_checked) {
                vm.shipping_city_ids.push(data.id);
            }
        });
    });
    table.on('change' , '.option-row' , function () {
        let if_all_checked = true;
        vm.shipping_city_ids = [];
        table.rows().every(function (rowIdx, tableLoop, rowLoop) {

            var data = this.data();
            if(!$('#option-row-' + (data.id)).is(":checked")) {
                if_all_checked = false;
            }else {
                vm.shipping_city_ids.push(data.id);
            }

        });
        if(if_all_checked) {
            $('#check_all').prop('checked', true);
        }else {
            $('#check_all').prop('checked', false);
        }

    });

});
