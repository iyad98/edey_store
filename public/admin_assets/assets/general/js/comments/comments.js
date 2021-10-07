var vm = new Vue({
    el: '#app',
    data: {

        comment: {
            name_ar: '',
            name_en: '',
            account_number : '',
            iban:'',
            image: ''

        },
        get_comment_status : 1 ,
        comment_status : {
            all : 0 ,
            approve : 0 ,
            disapprove : 0 ,
            pending : 0 ,
            trash : 0 ,

        } ,

        msg: {
            success: '',
            error: ''
        },
        add: false,
        edit_id: '',
        loading: false,
        edit_row: '',


    },

    created: function () {

        axios.get(get_url+"/admin/get-comments-status").then(function (res) {
            vm.comment_status = res.data;
        }).catch(function (err) {

        });
    },
    methods: {


        edit_comment: function (data) {
            this.add = false;
            this.edit_id = data.id;
            this.comment.name_ar = data.name_ar;
            this.comment.name_en = data.name_en;
            this.comment.image = data.image;
            this.comment.iban = data.iban;
            this.comment.account_number = data.account_number;

        },
        reset_validation: function () {
            vm.$validator.reset();
        },

        update_comment: function () {
            var formData = new FormData();

            this.loading = true;


            Object.keys(this.comment).forEach(function (key) {
                formData.append(key, vm.comment[key]);
            });
            formData.append('id', this.edit_id);

            axios.post(get_url + "/admin/comments/update", formData).then(function (res) {
                vm.loading = false;
                var get_res = handle_response(res.data);
                scroll_to_div('.m-dropdown__wrapper');
                if (get_res) {

                    setTimeout(function () {
                        $('.add_form').addClass('hidden');
                        $('.show_data').removeClass('hidden');
                    }, time_to_hide_success_msg);

                    table.ajax.reload(null, false);
                }
            }).catch(function (err) {
                vm.loading = false;
            });


        },
        delete_comment: function (comment , type) {
            let params = {
                type : type ,
            }
            axios.delete(get_url + "/admin/comments/"+( comment.id) , {
                params
            }).then(function (res) {

                var get_res = handle_response(res.data);
                if (get_res) {
                    swal(translations['success_delete'], translations['done_delete'], "success");
                    vm.comment_status = res.data['data']['comment_status'];
                    table.ajax.reload();
                }

            }).catch(function (err) {
                vm.loading = false;
            });

        },
        change_status_comment: function (comment , status_) {
            let data = {
                id : comment.id ,
                status : status_ ,
            };

            axios.post(get_url + "/admin/comments/change-status" ,data ).then(function (res) {

                var get_res = handle_response(res.data);
                if (get_res) {
                    if(status_ == 1) {
                        swal(translations['success_approve_comment'], translations['didnt_approve_comment'], "success");
                    }else {
                        swal(translations['success_disapprove_comment'], translations['didnt_disapprove_comment'], "success");
                    }

                    vm.comment_status = res.data['data']['comment_status'];
                    table.ajax.reload();
                }

            }).catch(function (err) {
                vm.loading = false;
            });

        },
        get_file: function (event, selector) {
            var file = event.target.files[0];
            if (file) {
                this.comment['image'] = file;
                read_url(event.target, selector);
            } else {
                this.comment['image'] = '';
            }

        }


    },
    watch: {
        get_comment_status : function () {
            Vue.nextTick(function () {
                table.ajax.reload();
            });
        }
    }
});

$(document).ready(function () {



    table.on('click', '.edit', function () {
        var row = $(this).closest('tr');
        if (row.attr('role') == undefined) {
            row = $(this).parent('tr'['role=row']);
        }

        var row_data = table.row(row).data();
        $('.add_form').removeClass('hidden');
        $('.show_data').addClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.edit_comment(row_data);
    });
    table.on('click', '.delete', function () {
        var row = $(this).closest('tr');
        if (row.attr('role') == undefined) {
            row = $(this).parent('tr'['role=row']);
        }
        vm.edit_row = row;
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
                vm.delete_comment(table.row(row).data() , 1);
            } else {
                e.dismiss && swal(translations['cancelled_delete'], translations['didnt_delete'], "error")
            }

        });
    });
    table.on('click', '.cancel_delete', function () {
        var row = $(this).closest('tr');
        if (row.attr('role') == undefined) {
            row = $(this).parent('tr'['role=row']);
        }
        vm.edit_row = row;
        swal({
            title: translations['sure_cancel_delete'],
            text: "",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: translations['yes_cancel_delete'],
            cancelButtonText: translations['no_cancel_delete'],
            reverseButtons: !0
        }).then(function (e) {
            if (e.value) {
                vm.delete_comment(table.row(row).data() , 2);
            } else {
                e.dismiss && swal(translations['cancelled_cancel_delete'], translations['didnt_cancel_delete'], "error")
            }

        });
    });
    table.on('click', '.approve', function () {
        var row = $(this).closest('tr');
        if (row.attr('role') == undefined) {
            row = $(this).parent('tr'['role=row']);
        }
        vm.edit_row = row;
        swal({
            title: translations['sure_approve_comment'],
            text: "",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: translations['yes_approve_comment'],
            cancelButtonText: translations['no_approve_comment'],
            reverseButtons: !0
        }).then(function (e) {
            if (e.value) {
                vm.change_status_comment(table.row(row).data() , 1);
            } else {
                e.dismiss && swal(translations['cancelled_approve_comment'], translations['didnt_approve_comment'], "error")
            }

        });
    });
    table.on('click', '.disapprove', function () {
        var row = $(this).closest('tr');
        if (row.attr('role') == undefined) {
            row = $(this).parent('tr'['role=row']);
        }
        vm.edit_row = row;
        swal({
            title: translations['sure_disapprove_comment'],
            text: "",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: translations['yes_disapprove_comment'],
            cancelButtonText: translations['no_disapprove_comment'],
            reverseButtons: !0
        }).then(function (e) {
            if (e.value) {
                vm.change_status_comment(table.row(row).data() , 2);
            } else {
                e.dismiss && swal(translations['cancelled_disapprove_comment'], translations['didnt_disapprove_comment'], "error")
            }

        });
    });


});

