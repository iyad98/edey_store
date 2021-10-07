var vm = new Vue({
    el: '#app',
    data: {


        shock_event: '',

        cancel_reasons: {
            title_ar: '',
            title_en: '',


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

        setData: function (add, data) {
            this.default_image = add ? JSON.parse(JSON.stringify(default_image)) : data.image;
            this.shock_event = makeid(32);
        },

        validateForm: function (event) {
            vm.$validator.validateAll().then(function (valid) {
                if (valid) {
                    if (vm.add) {
                        vm.add_cancel_reasons();
                    } else {

                        vm.update_cancel_reasons();
                    }

                }
            });
        },

        empty_cancel_reasons: function () {
            this.add = true;
            var empty_cancel_reasons = {
                title_ar: '',
                title_en: '',
                description_ar: '',
                description_en: '',
                image: ''
            };

            this.cancel_reasons = empty_cancel_reasons;
        },
        edit_cancel_reasons: function (data) {
            this.add = false;
            this.edit_id = data.id;
            this.cancel_reasons.title_ar = data.title_ar;
            this.cancel_reasons.title_en = data.title_en;
            this.cancel_reasons.description_ar = data.description_ar;
            this.cancel_reasons.description_en = data.description_en;
            this.cancel_reasons.image = data.image;

        },
        reset_validation: function () {
            vm.$validator.reset();
        },

        add_cancel_reasons: function () {
            var formData = new FormData();

            this.loading = true;
            
            Object.keys(this.cancel_reasons).forEach(function (key) {
                formData.append(key, vm.cancel_reasons[key]);
            });
            
            axios.post(get_url + "/admin/cancel_reasons/add", formData).then(function (res) {
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
        update_cancel_reasons: function () {
            var formData = new FormData();

            this.loading = true;


            Object.keys(this.cancel_reasons).forEach(function (key) {
                formData.append(key, vm.cancel_reasons[key]);
            });
            formData.append('id', this.edit_id);
            
            axios.post(get_url + "/admin/cancel_reasons/update", formData).then(function (res) {
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
        delete_cancel_reasons: function (category) {
            axios.post(get_url + "/admin/cancel_reasons/delete",
                {
                    id: category.id
                }
            ).then(function (res) {

                var get_res = handle_response(res.data);
                if (get_res) {
                    swal(translations['success_delete'], translations['done_delete'], "success");
                    table.ajax.reload();
                }else {
                    swal("خطأ", res.data['error_msg'], "error");
                }

            }).catch(function (err) {
                vm.loading = false;
            });

        },
        get_file: function (event, selector) {
            var file = event.target.files[0];
            if (file) {
                this.cancel_reasons['image'] = file;
                read_url(event.target, selector);
            } else {
                this.cancel_reasons['image'] = '';
            }

        }


    },
    watch: {}
});

$(document).ready(function () {

    // init


    /////
    $('#add_new_cancel_reasons').click(function () {
        $('.add_form').removeClass('hidden');
        $('.show_data').addClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_cancel_reasons();
        vm.reset_validation();
        vm.setData(true, '');
    });
    $('#cancel').click(function () {
        $('.add_form').addClass('hidden');
        $('.show_data').removeClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_cancel_reasons();
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
        vm.edit_cancel_reasons(row_data);
        vm.setData(false, row_data);
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
                vm.delete_cancel_reasons(table.row(row).data());
            } else {
                e.dismiss && swal(translations['cancelled_delete'], translations['didnt_delete'], "error")
            }

        });
    });


});

