
var filter_product = new Vue({
    el : '#filter_product' ,
    data : {
        loading : false ,
        edit_row : '',
    },
    methods : {
        search : function () {
            this.loading = true;
            table_product.ajax.reload();
        },
        delete_product: function (product) {

            var this_ = this;
            swal({
                title: translations['pending_delete'],
                showConfirmButton: false,
                onOpen: function () {
                    // swal.showLoading()
                }
            })

            axios.post(get_url + "/admin/products/delete",
                {
                    id: product.id
                }
            ).then(function (res) {



                var get_res = full_general_handle_response(res.data , this_);
                if (get_res) {

                    swal(translations['success_delete'], translations['done_delete'], "success");
                  //  table_product.row(filter_product.edit_row).hide();
                    table_product.ajax.reload(null , false);
                }

            }).catch(function (err) {
                filter_product.loading = false;
            });

        },
        change_status:function (id , status) {

            axios.post(get_url + "/admin/change_order_status",
                {
                    product_id: id,
                    status: status,
                }
            ).then(function (res) {




                toastr.success(res.data['success_msg']);
                // toastr.success('تم تعديل الحاله بنجاح');



            }).catch(function (err) {
            });
        },
        add_note_order:function (product , note_in_manufacturing,note_charged_up,note_charged_at_sea,note_at_the_harbour,note_in_the_warehouse,note_delivered) {


            axios.post(get_url + "/admin/add_note",
                {
                    product_id: product.id,
                    note_in_manufacturing : note_in_manufacturing,
                    note_charged_up:note_charged_up,
                    note_charged_at_sea:note_charged_at_sea,
                    note_at_the_harbour:note_at_the_harbour,
                    note_in_the_warehouse:note_in_the_warehouse,
                    note_delivered:note_delivered,
                }
            ).then(function (res) {


                if (res.data.status) {
                    swal(res.data.success_msg, res.data.success_msg, "success");
                    table_product.ajax.reload();
                }else {
                    swal("خطأ", res.data['error_msg'], "error");
                }

            }).catch(function (err) {

            });
        }
    }
});


$(document).ready(function () {

    $("#select_categories").select2({placeholder: "اختار الصنف/التصنيفات"});
    $("#select_brands").select2({placeholder: "اختار الماركة"});

    table_product.on('click', '.delete', function () {

        var row = $(this).closest('tr');
        if (row.attr('role') == undefined) {
            row = $(this).parent('tr'['role=row']);
        }
        filter_product.edit_row = row;

        swal({
            title: translations['sure_delete'],
            text: "",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: translations['yes_delete'],
            cancelButtonText: translations['no_delete'],
            reverseButtons: !0
        }).then(function (e) {
            if (e.value) {
                filter_product.delete_product(table_product.row(row).data());
            } else {
                e.dismiss && swal(translations['cancelled_delete'], translations['didnt_delete'], "error")
            }

        });
    });

    table_product.on('click', '.product_change_status', function () {


        var row = $(this).closest('tr');
        if (row.attr('role') == undefined) {
            row = $(this).parent('tr'['role=row']);
        }
        filter_product.edit_row = row;

        var id = table_product.row(row).data().id;
       var status =   $('#select_product_status_'+id).find(":selected").val();

        filter_product.change_status(id , status)


    });


    table_product.on('click', '.add_note_product', function () {

        var row = $(this).closest('tr');
        if(row.attr('role') == undefined) {
            row = $(this).parent('tr'['role=row']);
        }

        swal({
            title: 'ملاحظات الطلبات',


            type: "warning",
            showCancelButton: !0,
            confirmButtonText: 'اضف',
            cancelButtonText:translations['no_delete'],
            reverseButtons: !0,
            html:"" +
            "<input  class='swal2-input' id='note_in_manufacturing' value='"+table_product.row(row).data().note_in_manufacturing+"' style='display: flex;' placeholder='ملاحظة في التصنيع' type='text'>" +
            "<input  class='swal2-input' id='note_charged_up' value='"+table_product.row(row).data().note_charged_up+"'  style='display: flex;' placeholder='ملاحظة تم الشحن ' type='text'>"+
            "<input  class='swal2-input' id='note_charged_at_sea' value='"+table_product.row(row).data().note_charged_at_sea+"' style='display: flex;' placeholder='ملاحظة مشحون بالبحر ' type='text'>"+
            "<input  class='swal2-input' id='note_at_the_harbour' value='"+table_product.row(row).data().note_at_the_harbour+"' style='display: flex;' placeholder='ملاحظة الميناء والجمارك ' type='text'>"+
            "<input  class='swal2-input' id='note_in_the_warehouse' value='"+table_product.row(row).data().note_in_the_warehouse+"' style='display: flex;' placeholder='ملاحظة في المستودع ' type='text'>"+
            "<input  class='swal2-input' id='note_delivered' value='"+table_product.row(row).data().note_delivered+"' style='display: flex;' placeholder='ملاحظة تم التسليم ' type='text'>"
            ,

        }).then(function (e ) {

            if(e.value) {


                var note_in_manufacturing = $('#note_in_manufacturing').val() ;
                var note_charged_up = $('#note_charged_up').val() ;
                var note_charged_at_sea = $('#note_charged_at_sea').val() ;
                var note_at_the_harbour = $('#note_at_the_harbour').val() ;
                var note_in_the_warehouse = $('#note_in_the_warehouse').val() ;
                var note_delivered = $('#note_delivered').val() ;




                filter_product.add_note_order(table_product.row(row).data(),note_in_manufacturing,note_charged_up,note_charged_at_sea,note_at_the_harbour,note_in_the_warehouse,note_delivered);

            }else {
                e.dismiss && swal('تم التراجع', 'تم التراجع عن اضافه ملاحظة', "error")
            }

        });
    });


});

