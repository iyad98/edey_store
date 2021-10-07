var vm = new Vue({
    el: '#app',
    data: {

        slider: {
            name_ar: '',
            name_en: '',
            image : '' ,
        },

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

    },
    methods: {


        validateForm: function (event) {
            vm.$validator.validateAll().then(function (valid) {
                if (valid) {
                    if (vm.add) {
                        vm.add_slider();
                    } else {

                        vm.update_slider();
                    }

                }
            });
        },

        empty_slider: function () {
            this.add = true;
            var empty_slider = {
                name_ar: '',
                name_en: '',
                image : '' ,
            };

            this.slider = empty_slider;
        },
        edit_slider: function (data) {
            this.add = false;
            this.edit_id = data.id;
            this.slider.name_ar = data.name_ar;
            this.slider.name_en = data.name_en;
            this.slider.image = data.image;


        },
        reset_validation: function () {
            vm.$validator.reset();
        },

        add_slider: function () {
            var formData = new FormData();
            this.slider.category_id = $('#m_select_category_form').val();
            this.loading = true;
            Object.keys(this.slider).forEach(function (key) {
                formData.append(key, vm.slider[key]);
            });


            axios.post(get_url + "/admin/sliders/add", formData).then(function (res) {
                vm.loading = false;
                var get_res = handle_response(res.data);

                scroll_to_div('.m-dropdown__wrapper');
                if (get_res) {

                    setTimeout(function () {
                        $('.add_form').addClass('hidden');
                        $('.show_data').removeClass('hidden');
                    }, 1200);
                    table.ajax.reload();
                    vm.$validator.reset();
                }
            }).catch(function (err) {
                vm.loading = false;
            });


        },
        update_slider: function () {
            var formData = new FormData();
            this.slider.category_id = $('#m_select_category_form').val();

            this.loading = true;
            Object.keys(this.slider).forEach(function (key) {
                formData.append(key, vm.slider[key]);
            });
            formData.append('id', this.edit_id);

            axios.post(get_url + "/admin/sliders/update", formData).then(function (res) {
                vm.loading = false;
                var get_res = handle_response(res.data);
                scroll_to_div('.m-dropdown__wrapper');
                if (get_res) {

                    setTimeout(function () {
                        $('.add_form').addClass('hidden');
                        $('.show_data').removeClass('hidden');
                    }, time_to_hide_success_msg);

                    table.ajax.reload(null , false);
                }
            }).catch(function (err) {
                vm.loading = false;
            });


        },
        approve : function (category) {

            axios.post(get_url + "/admin/bank-transfer/approve",
                {
                    id: category.id
                }
            ).then(function (res) {

                var get_res = handle_response(res.data);
                if (get_res) {
                    swal(translations['success_approve'], translations['success_approve'], "success");
                    table.ajax.reload();
                }else {
                    swal("خطأ", res.data['error_msg'], "error");
                    return false;
                }

            }).catch(function (err) {
                vm.loading = false;
            });

        },
        reject : function (category , reject_reason) {

            axios.post(get_url + "/admin/bank-transfer/reject",
                {
                    id: category.id ,
                    reject_reason : reject_reason,
                }
            ).then(function (res) {
                var get_res = handle_response(res.data);
                if (get_res) {
                    swal(translations['success_reject'], translations['success_reject'], "success");
                    table.ajax.reload();
                }else {
                    swal("خطأ", res.data['error_msg'], "error");
                    return false;
                }

            }).catch(function (err) {
                vm.loading = false;
            });

        },

        get_file: function (event, selector) {
            var file = event.target.files[0];
            if (file) {
                this.slider['image'] = file;
                read_url(event.target, selector);
            } else {
                this.slider['image'] = '';
            }

        }


    },
    watch: {

    }
});

$(document).ready(function () {

    // init

    $("#m_select_category_form").select2({placeholder: "Select a city"});
    $("#m_select_category_form2").select2({placeholder: "Select a city"});
    $("#m_select_category_form").change(function () {
        vm.slider.city_id = $(this).val();
    });

    /////
    $('#add_new_slider').click(function () {
        $('.add_form').removeClass('hidden');
        $('.show_data').addClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_slider();
        vm.reset_validation();
    });
    $('#cancel').click(function () {
        $('.add_form').addClass('hidden');
        $('.show_data').removeClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_slider();
        vm.reset_validation();
    });

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
        vm.edit_slider(row_data);
        $('#m_select_category_form').val(row_data.category_id).trigger('change');
    });


    table.on('click', '.approve', function () {
        var row = $(this).closest('tr');
        if (row.attr('role') == undefined) {
            row = $(this).parent('tr'['role=row']);
        }
        vm.edit_row = row;
        swal({
            title: translations['sure_approve_bank']+" : "+table.row(row).data().id +" ؟ ",
            text: "",
            type: "info",
            showCancelButton: !0,
            confirmButtonText: translations['yes'],
            cancelButtonText: translations['no'],
            reverseButtons: !0
        }).then(function (e) {
            if (e.value) {
                vm.approve(table.row(row).data());
            } else {
                e.dismiss && swal(translations['cancelled_approve'], translations['didnt_approve'], "warning")
            }

        });
    });
    table.on('click', '.reject', function () {
        var row = $(this).closest('tr');
        if (row.attr('role') == undefined) {
            row = $(this).parent('tr'['role=row']);
        }
        vm.edit_row = row;
        swal({
            title: translations['sure_reject_bank']+" : "+table.row(row).data().id +" ؟ ",
            text: "",
            type: "info",
            showCancelButton: !0,
            confirmButtonText: translations['yes'],
            cancelButtonText: translations['no'],
            reverseButtons: !0
        }).then(function (e) {
            if (e.value) {
                swal({
                    title: translations['reject_reason'],
                    html: "<input id='reject_reason' type='text' class='form-control' placeholder='" +
                    translations['reject_reason'] +
                    "'>",
                    type: "info",
                    showCancelButton: !0,
                    confirmButtonText: translations['yes'],
                    cancelButtonText: translations['no'],
                    reverseButtons: !0 ,
                    preConfirm: function () {
                        var reject_reason = $('#reject_reason').val();
                        if(reject_reason == "") {
                            return false
                        }else {
                            return true;
                        }
                    },

                }).then(function (e) {
                    if (e.value) {
                        vm.reject(table.row(row).data() , $('#reject_reason').val());
                    }else {
                        e.dismiss && swal(translations['cancelled_reject'], translations['didnt_reject'], "warning")

                    }
                });
               // vm.delete_slider(table.row(row).data());
            } else {
                e.dismiss && swal(translations['cancelled_reject'], translations['didnt_reject'], "warning")
            }

        });
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
                vm.delete_slider(table.row(row).data());
            } else {
                e.dismiss && swal(translations['cancelled_delete'], translations['didnt_delete'], "error")
            }

        });
    });



});

