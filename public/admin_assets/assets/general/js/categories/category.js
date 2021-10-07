var vm = new Vue({
    el: '#app',
    data: {

        attr_name: 'image',
        selector_id_image: 'image1',
        default_image: JSON.parse(JSON.stringify(default_image)),
        default_guide_image : JSON.parse(JSON.stringify(default_image)),
        shock_event: '',

        filter_category_id : -1,
        category: {
            name_en: '',
            name_ar: '',
            description_en: '',
            description_ar: '',
            parent: -1,
            image: '',
            guide_image : '',

        },

        msg: {
            success: '',
            error: ''
        },
        add: false,
        edit_id: '',
        loading: false,
        edit_row: '',


        category_parent: [],
        cant_change_type: false,
        cant_see_type: true,

        tree_of_parents : [],
    },

    created: function () {
        this.get_tree_of_parent(-1);
    },
    methods: {

        setData: function (add, data) {
            this.default_image = add ? JSON.parse(JSON.stringify(default_image)) : data.image;
            this.default_guide_image = add ? JSON.parse(JSON.stringify(default_image)) : data.guide_image;
            this.shock_event = makeid(32);
        },
        validateForm: function (event) {
            vm.$validator.validateAll().then(function (valid) {
                if (valid) {
                    if (vm.add) {
                        vm.add_category();
                    } else {

                        vm.update_category();
                    }

                }
            });
        },

        empty_category: function () {
            this.add = true;
            var empty_category = {
                name_en: '',
                name_ar: '',
                description_en: '',
                description_ar: '',
                parent: -1,
                image: '',

            };
            this.cant_change_type = false;
            this.category = empty_category;
        },
        edit_category: function (category) {
            this.add = false;
            this.edit_id = category.id;
            this.category.name_en = category.name_en_edit;
            this.category.name_ar = category.name_ar_edit;
            this.category.description_en = category.description_en;
            this.category.description_ar = category.description_ar;
            //  this.category.parent = -1;
            this.category.image = category.image;

        },
        reset_validation: function () {
            vm.$validator.reset();
        },

        add_category: function () {
            var formData = new FormData();

            this.loading = true;
            vm.category.parent = $('#m_select_category_form').val();
            Object.keys(this.category).forEach(function (key) {
                formData.append(key, vm.category[key]);
            });

            axios.post(get_url + "/admin/categories/add", formData).then(function (res) {
                vm.loading = false;
                var get_res = handle_response(res.data);



                scroll_to_div('.m-dropdown__wrapper');
                if (get_res) {

                    vm.category_parent = res.data['data']['category_parent'];
                    vm.update_parent_category();

                    setTimeout(function () {
                        $('.add_form').addClass('hidden');
                        $('.show_data').removeClass('hidden');
                    }, 700);
                  //  table_category.ajax.reload();
                    $('#m_select2_2').val(res.data['data']['parent_id']).trigger('change');
                    vm.$validator.reset();
                }
            }).catch(function (err) {
                vm.loading = false;
            });

        },
        update_category: function () {
            var formData = new FormData();

            this.loading = true;
            var edit_id = this.edit_id;
            vm.category.parent = $('#m_select_category_form').val();
            Object.keys(this.category).forEach(function (key) {
                formData.append(key, vm.category[key]);
            });
            formData.append('id', this.edit_id);

            axios.post(get_url + "/admin/categories/update", formData).then(function (res) {
                vm.loading = false;
                var get_res = handle_response(res.data);
                scroll_to_div('.m-dropdown__wrapper');
                if (get_res) {
                 //   vm.category_parent = res.data['data']['category_parent'];
                 //   vm.update_parent_category();

                    vm.category_parent = res.data['data']['category_parent'];
                    setTimeout(function () {
                        $('.add_form').addClass('hidden');
                        $('.show_data').removeClass('hidden');
                    }, time_to_hide_success_msg);

                    $('#m_select2_2').val(res.data['data']['parent_id']).trigger('change');
                  //  table_category.ajax.reload(null , null);
                }
            }).catch(function (err) {
                vm.loading = false;
            });


        },
        delete_category: function (category) {
            axios.post(get_url + "/admin/categories/delete",
                {
                    id: category.id
                }
            ).then(function (res) {

                var get_res = handle_response(res.data);
                if (get_res) {

                 //   vm.category_parent = res.data['data']['category_parent'];
                 //  vm.update_parent_category();

                    swal(translations['success_delete'], translations['done_delete'], "success");

                    $("#m_select2_2 option[value=" +
                        category.id +
                        "]").remove();

                    $('#m_select2_2').val(res.data['data']['parent_id']).trigger('change');
                   // table_category.ajax.reload();
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
                this.category['image'] = file;
                read_url(event.target, selector);
            } else {
                this.category['image'] = '';
            }

        },


        get_parent_category: function () {
            $("#m_select2_2").empty();
            $("#m_select_category_form").empty();

            axios.get(get_url + "/admin/categories/parent/get").then(function (res) {
                vm.category_parent = res.data;
                vm.update_parent_category();

            }).catch(function (err) {

            });
        },
        update_parent_category : function () {

            $("#m_select2_2").empty();
            $("#m_select_category_form").empty();

            var newState = new Option($('#main_category_text').val(), -1, true, true);
            $("#m_select2_2").append(newState);
            vm.category_parent.forEach(function (value) {
                var newState = new Option(value.category_with_parents_text, value.id, false, false);
                $("#m_select2_2").append(newState);
            });

            ///////////////////////////////


            var newState = new Option($('#main_category_text').val(), -1, true, true);
            $("#m_select_category_form").append(newState);
            vm.category_parent.forEach(function (value) {
                var newState = new Option(value.category_with_parents_text, value.id, false, false);
                $("#m_select_category_form").append(newState);
            });
        } ,
        get_tree_of_parent : function (category_id) {
            axios.get(get_url + "/admin/categories/get-tree-of-parent" ,
                {
                    params : {
                        category_id : category_id ,
                    }
                }).then(function (res) {
                   // console.log(res.data);
                    vm.tree_of_parents = res.data;

            }).catch(function (err) {

            });
        } ,
        show_children : function (id) {
            $('#m_select2_2').val(id).trigger('change');
        }
    },
    watch: {
      /*  'category.parent': function (value) {
            if (value == -1) {
                this.cant_change_type = false;
            } else {

                var found = this.category_parent.find(function (element) {
                    return element.id == value;
                });
                this.category.type = found.type;
                this.cant_change_type = true;
            }
        }
        */
    }
});

$(document).ready(function () {


    $('#add_new_category').click(function () {
        $('.add_form').removeClass('hidden');
        $('.show_data').addClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_category();
        $('#m_select_category_form').val($('#m_select2_2').val()).trigger('change');
        vm.reset_validation();
        vm.setData(true, '');
    });
    $('#cancel').click(function () {
        $('.add_form').addClass('hidden');
        $('.show_data').removeClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_category();

        vm.reset_validation();
    });

    table_category.on('click', '.edit', function () {
        var row = $(this).closest('tr');
        if (row.attr('role') == undefined) {
            row = $(this).parent('tr'['role=row']);
        }

        var row_data = table_category.row(row).data();
        $('.add_form').removeClass('hidden');
        $('.show_data').addClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');

        var id = row_data.parent.id != undefined ? row_data.parent.id : -1;

        if (id != -1) {
            vm.cant_change_type = true;
        } else {
            vm.cant_change_type = false;
        }
        $('#m_select_category_form').val(id).trigger('change');
        vm.category.parent = id;
        vm.edit_category(row_data);
        vm.setData(false, row_data);
    });
    table_category.on('click', '.delete', function () {
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
                vm.delete_category(table_category.row(row).data());
            } else {
                e.dismiss && swal(translations['cancelled_delete'], translations['didnt_delete'], "error")
            }

        });
    });


    table_category.on('click', '.show_children_category', function () {
        var id = $(this).find('.category_id_hidden').val();
        $('#m_select2_2').val(id).trigger('change');
    });



    $("#m_select_category_form").select2({placeholder: "القسم الرئيسي"});
    $("#m_select_category_form").change(function () {
        vm.category.parent = $(this).val();

    });
    vm.get_parent_category();

});

