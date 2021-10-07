var table;
var DatatablesDataSourceAjaxServer = {
    init: function () {
        table = $("#country-table").DataTable({
            responsive: !0,
            searchDelay: 500,
            dom: 'rtlip',
            "order": [[6, "desc"]],
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
                url: "get-countries-ajax",
                data: function (e) {
                    //  e.country_id = $('#m_select_country_form2').val();
                }
            },
            columns: [
                {data: "options", name: 'countries.id', orderable: false},
                {data : "show_image" , searchable: false , orderable : false},
                {data: "name_ar"},
                {data: "iso2"},
                {data: "currency_symbol" , name : 'currencies.symbol_ar'},
                {data : "show_status"},
                {data : 'status' , class : 'hidden'},
                {data: "actions", searchable: false}
            ]
        });

        $('#searchValue').on( 'keyup', function () {
            table.search( this.value ).draw();
        });

        /* $("#m_select_country_form2").change(function () {
             table.ajax.reload();

         });*/
    }
};
jQuery(document).ready(function () {

    DatatablesDataSourceAjaxServer.init();

    // checkbox
    $('#check_all').change(function () {
        var if_checked = this.checked;
        vm.country_ids = [];
        table.rows().every(function (rowIdx, tableLoop, rowLoop) {
            var data = this.data();
            $('#option-row-' + (data.id)).prop('checked', if_checked);
            if(if_checked) {
                vm.country_ids.push(data.id);
            }
        });
    });
    table.on('change' , '.option-row' , function () {
        let if_all_checked = true;
        vm.country_ids = [];
        table.rows().every(function (rowIdx, tableLoop, rowLoop) {

            var data = this.data();
            if(!$('#option-row-' + (data.id)).is(":checked")) {
                if_all_checked = false;
            }else {
                vm.country_ids.push(data.id);
            }

        });
        if(if_all_checked) {
            $('#check_all').prop('checked', true);
        }else {
            $('#check_all').prop('checked', false);
        }

    });
});
