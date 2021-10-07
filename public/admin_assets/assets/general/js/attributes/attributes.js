var vm = new Vue({
    el: '#app',
    data: {

        attribute: {
            name_ar: '',
            name_en: '',
        },

        msg: {
            success: '',
            error: ''
        },
        add: false,
        edit_id: '',
        loading: false,
        edit_row: '',

        attribute_types : attribute_types ,

    },

    created: function () {

    },
    methods: {


        validateForm: function (event) {
            vm.$validator.validateAll().then(function (valid) {
                if (valid) {
                    if (vm.add) {
                        vm.add_attribute();
                    } else {

                        vm.update_attribute();
                    }

                }
            });
        },

        empty_attribute: function () {
            this.add = true;
            var empty_attribute = {
                name_ar: '',
                name_en: '',
            };

            this.attribute = empty_attribute;
        },
        edit_attribute: function (data) {
            this.add = false;
            this.edit_id = data.id;
            this.attribute.name_ar = data.name_ar;
            this.attribute.name_en = data.name_en;
            this.attribute.city_id = data.city_id;


        },
        reset_validation: function () {
            vm.$validator.reset();
        },

        add_attribute: function () {
            var formData = new FormData();

            this.loading = true;
            vm.attribute.attribute_type_id = $('#select_type_form').val();
            Object.keys(this.attribute).forEach(function (key) {
                formData.append(key, vm.attribute[key]);
            });


            axios.post(get_url + "/admin/attributes/add", formData).then(function (res) {
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
        update_attribute: function () {
            var formData = new FormData();

            vm.attribute.attribute_type_id = $('#select_type_form').val();

            this.loading = true;
            Object.keys(this.attribute).forEach(function (key) {
                formData.append(key, vm.attribute[key]);
            });
            formData.append('id', this.edit_id);

            axios.post(get_url + "/admin/attributes/update", formData).then(function (res) {
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
        delete_attribute : function (category) {
            axios.post(get_url + "/admin/attributes/delete",
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
                    return false;
                }

            }).catch(function (err) {
                vm.loading = false;
            });

        },
        get_file: function (event, selector) {
            var file = event.target.files[0];
            if (file) {
                this.attribute['image'] = file;
                read_url(event.target, selector);
            } else {
                this.attribute['image'] = '';
            }

        }


    },
    watch: {

    }
});

$(document).ready(function () {

    // init


    /////
    $('#add_new_attribute').click(function () {
        $('.add_form').removeClass('hidden');
        $('.show_data').addClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_attribute();
        vm.reset_validation();

    });
    $('#cancel').click(function () {
        $('.add_form').addClass('hidden');
        $('.show_data').removeClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_attribute();
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
        vm.edit_attribute(row_data);
        $('#select_type_form').val(row_data.attribute_type_id).trigger('change');
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
                vm.delete_attribute(table.row(row).data());
            } else {
                e.dismiss && swal(translations['cancelled_delete'], translations['didnt_delete'], "error")
            }

        });
    });



});

