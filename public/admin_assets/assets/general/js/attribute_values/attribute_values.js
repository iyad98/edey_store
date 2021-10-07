var vm = new Vue({
    el: '#app',
    data: {

        attribute_value: {
            name_ar: '',
            name_en: '',
            color_value :'#000000',
            image_value : '' ,
            label_value : '' ,
            value : ''

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
                        vm.add_attribute_value();
                    } else {

                        vm.update_attribute_value();
                    }

                }
            });
        },

        empty_attribute_value: function () {
            this.add = true;
            var empty_attribute_value = {
                name_ar: '',
                name_en: '',
                color_value :'#000000',
                image_value : '' ,
                label_value : '' ,
                value : ''
            };

            this.attribute_value = empty_attribute_value;
        },
        edit_attribute_value: function (data) {
            this.add = false;
            this.edit_id = data.id;
            this.attribute_value.name_ar = data.name_ar;
            this.attribute_value.name_en = data.name_en;

            if(attribute.attribute_type.key == 'color') {
                this.attribute_value.color_value = data.value;
            }else if(attribute.attribute_type.key == 'image') {
                this.attribute_value.image_value = data.value;
            }else {
                this.attribute_value.label_value = data.value;
            }

        },
        reset_validation: function () {
            vm.$validator.reset();
        },

        add_attribute_value: function () {
            var formData = new FormData();

            this.loading = true;
            if(attribute.attribute_type.key == 'color') {
                this.attribute_value.value = this.attribute_value.color_value;
            }else if(attribute.attribute_type.key == 'image') {
                this.attribute_value.value = this.attribute_value.image_value;
            }else {
                this.attribute_value.value = this.attribute_value.label_value;
            }
            this.attribute_value.attribute_id = attribute.id;
            this.attribute_value.attribute_key = attribute.attribute_type.key;
            Object.keys(this.attribute_value).forEach(function (key) {
                formData.append(key, vm.attribute_value[key]);
            });


            axios.post(get_url + "/admin/attribute-values/add", formData).then(function (res) {
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
        update_attribute_value: function () {
            var formData = new FormData();

            this.loading = true;

            if(attribute.attribute_type.key == 'color') {
                this.attribute_value.value = this.attribute_value.color_value;
            }else if(attribute.attribute_type.key == 'image') {
                this.attribute_value.value = this.attribute_value.image_value;
            }else {
                this.attribute_value.value = this.attribute_value.label_value;
            }
            this.attribute_value.attribute_id = attribute.id;
            this.attribute_value.attribute_key = attribute.attribute_type.key;

            Object.keys(this.attribute_value).forEach(function (key) {
                formData.append(key, vm.attribute_value[key]);
            });
            formData.append('id', this.edit_id);

            axios.post(get_url + "/admin/attribute-values/update", formData).then(function (res) {
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
        delete_attribute_value : function (category) {
            axios.post(get_url + "/admin/attribute-values/delete",
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
                this.attribute_value['image_value'] = file;
                read_url(event.target, selector);
            } else {
                this.attribute_value['image_value'] = '';
            }

        }


    },
    watch: {

    }
});

$(document).ready(function () {

    // init

    $("#m_select_city_form").select2({placeholder: "Select a city"});
    $("#m_select_city_form2").select2({placeholder: "Select a city"});
    $("#m_select_city_form").change(function () {
        vm.attribute_value.city_id = $(this).val();
    });

    /////
    $('#add_new_attribute_value').click(function () {
        $('.add_form').removeClass('hidden');
        $('.show_data').addClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_attribute_value();
        vm.reset_validation();
    });
    $('#cancel').click(function () {
        $('.add_form').addClass('hidden');
        $('.show_data').removeClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_attribute_value();
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
        vm.edit_attribute_value(row_data);
        $('#m_select_city_form').val(row_data.city_id).trigger('change');
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
                vm.delete_attribute_value(table.row(row).data());
            } else {
                e.dismiss && swal(translations['cancelled_delete'], translations['didnt_delete'], "error")
            }

        });
    });



});

