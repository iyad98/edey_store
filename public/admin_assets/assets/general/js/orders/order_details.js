/* v-if="pharmacies.includes(order_product.pharmacy_id)" */


var order_details = new Vue({
    el: '#order_details',
    created: function () {

    },
    data: {

        order: order,
        edit_order_data: '',
        countries: JSON.parse(JSON.stringify(countries)),
        cities: JSON.parse(JSON.stringify(cities)),
        shipping_companies: shipping_companies,
        payment_methods: payment_methods,

        products : [],
        msg: {
            success: '',
            error: '',
        },
        products : [],

        error_product_random_id : "",
        loading: false,
        edit_loading: false ,
        add_loading : false,

        currency_type : 1 ,
        change_status_loading : false ,
        shipping_policy_loading : false,

        invoice_number_loading : false ,

        /////  return order ////////////
        return_order_loading : false,
        shipping_policy_return_loading : false ,

        is_gift : false,

        return_order_note_text:order.return_order_note_text,
        return_order_note_file : order.return_order_note_file,
    },
    created : function () {
        $('.user_data').removeClass('hidden');
        this.edit_order_data = JSON.parse(JSON.stringify(this.order));
        this.is_gift = this.edit_order_data.order_user_shipping.gift_target_phone;

    },
    methods: {
        set_attribute_value: function (attribute_values) {
            let get_attribute_value_names = pluck_('name');
            let get_attribute_values = get_attribute_value_names(attribute_values);
            return get_attribute_values.join(' - ');
        },

        change_status: function () {
            var precious_status = this.order.status;
            var order_status = $('#select_order_status').val();
            var order_id = this.order.id;
            // var shipping_policy = this.order.shipping_policy;
            var shipping_policy = $('#shipping_policy_td').val();

            /*if (this.order.status == order_status) {
                return;
            }*/
            this.change_status_loading = true;
            axios.post(get_url + "/admin/order/change-status",
                {
                    order_id: order_id,
                    order_status: order_status ,
                    shipping_policy : shipping_policy
                }
            ).then(function (res) {


                order_details.change_status_loading = false;
                if (res.data['status']) {

                    order_details.order.can_edit = res.data['data']['order']['can_edit'];
                    order_details.order.status = parseInt(res.data['data']['order']['status']);
                    order_details.order.status_text = res.data['data']['order']['status_text'];
                    order_details.order.status_class = res.data['data']['order']['status_class'];
                    order_details.set_date(res.data['data']['order']);
                    toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "800",
                        "timeOut": "3000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    };

                    toastr.success(res.data['success_msg']);
                }else {
                    swal("خطأ",res.data['error_msg'],"error");
                    $('#select_order_status').val(precious_status);
                    order_details.order.can_edit = res.data['data']['order']['can_edit'];
                    order_details.order.status = res.data['data']['order']['status'];
                    order_details.order.status_text = res.data['data']['order']['status_text'];
                    order_details.order.status_class = res.data['data']['order']['status_class'];


                }


            }).catch(function () {
                order_details.change_status_loading = false;
            });
        },

        shipping_policy : function (add , is_return = 0) {

            var order_id = this.order.id;
            if(is_return == 1) {
                var shipping_policy_return = $('#shipping_policy_return_input').val();
                this.shipping_policy_return_loading = true;
            }else {
                var shipping_policy = $('#shipping_policy_input').val();
                this.shipping_policy_loading = true;
            }

            axios.post(get_url + "/admin/order/shipping_policy",
                {
                    order_id: order_id,
                    shipping_policy : shipping_policy,
                    shipping_policy_return : shipping_policy_return,
                    add : add,
                    is_return : is_return,
                }
            ).then(function (res) {

                order_details.shipping_policy_loading = false;
                order_details.shipping_policy_return_loading = false;

                $('#shipping_policy_input').val(res.data['data']['shipping_policy']);
                $('#shipping_policy_return_input').val(res.data['data']['shipping_policy_return']);

                order_details.order.shipping_policy = res.data['data']['shipping_policy'];
                order_details.order.shipping_policy_return = res.data['data']['shipping_policy_return'];

                if (res.data['status']) {

                    toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "800",
                        "timeOut": "3000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    };

                    toastr.success(res.data['success_msg']);
                }else {
                    swal("خطأ",res.data['error_msg'],"error")
                }


            }).catch(function () {
                order_details.shipping_policy_loading = false;
                order_details.shipping_policy_return_loading = false;
            });
        },
        print_shipping_policy : function (is_return = 0) {
            let order_id = this.order.id;
            let shipping_policy = this.order.shipping_policy;

            let shipping_policy_return = this.order.shipping_policy_return;

            if(is_return == 1) {
                if(shipping_policy_return == "" || shipping_policy_return=="null" || shipping_policy_return == null) {
                    swal("خطأ","الرجاء اضافة بوليصة الشحن اولا","error");
                    return;
                }
            }else {
                if(shipping_policy == "" || shipping_policy=="null" || shipping_policy == null) {
                    swal("خطأ","الرجاء اضافة بوليصة الشحن اولا","error");
                    return;
                }
            }


            window.location = get_url + "/admin/order/print_shipping_policy?order_id="+order_id+"&is_return="+is_return;
        },
        show_cancel_shipping_policy : function (is_return = 0) {
            swal({
                title: translations['sure_cancel_shipping'],
                text: "",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: translations['yes_delete'],
                cancelButtonText: translations['no_delete'],
                reverseButtons: !0
            }).then(function (e) {
                if (e.value) {
                    order_details.cancel_shipping_policy(is_return);
                } else {
                    e.dismiss && swal(translations['cancel_shipping_order'], translations['cancel_shipping_not_done'], "error")
                }

            });
        },
        cancel_shipping_policy : function (is_return) {
            var order_id = this.order.id;

            if(is_return == 1) {
                this.shipping_policy_return_loading = true;
            }else {
                this.shipping_policy_loading = true;
            }
            axios.post(get_url + "/admin/order/cancel-shipping-policy",
                {
                    order_id: order_id,
                    is_return : is_return
                }
            ).then(function (res) {

                order_details.shipping_policy_loading = false;
                order_details.shipping_policy_return_loading = false;

                $('#shipping_policy_input').val(res.data['data']['shipping_policy']);
                $('#shipping_policy_return_input').val(res.data['data']['shipping_policy_return']);

                order_details.order.shipping_policy = res.data['data']['shipping_policy'];

                if (res.data['status']) {

                    toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "800",
                        "timeOut": "3000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    };
                    toastr.success(res.data['success_msg']);
                }else {
                    swal("خطأ",res.data['error_msg'],"error")
                }


            }).catch(function () {
                order_details.shipping_policy_loading = false;
                order_details.shipping_policy_return_loading = false;
            });
        },

        edit_order: function (event) {
            var get_row = $(event.target).closest('tr');
            get_row.find('.quantity').removeClass('hidden');
            get_row.find('.show_quantity').addClass('hidden');
            get_row.find('.edit_or_remove').addClass('hidden');
            get_row.find('.save_or_cancel').removeClass('hidden');
        },
        cancel_edit: function () {
            var get_row = $(event.target).closest('tr');
            get_row.find('.quantity').addClass('hidden');
            get_row.find('.show_quantity').removeClass('hidden');
            get_row.find('.edit_or_remove').removeClass('hidden');
            get_row.find('.save_or_cancel').addClass('hidden');
        },
        save_order: function (event, order_product_id) {
            var get_row = $(event.target).closest('tr');

            var quantity = get_row.find('.quantity').val();
            var currency_type = this.currency_type;

            mApp.block("#products-block", {});
            axios.post(get_url + "/admin/order/update-order-product",
                {
                    quantity: quantity,
                    order_product_id: order_product_id ,
                    currency_type : currency_type ,
                }).then(function (res) {

               
                if (res.data['status']) {
                    order_details.order = res.data['data']['order'];

                    get_row.find('.quantity').addClass('hidden');
                    get_row.find('.show_quantity').removeClass('hidden');
                    get_row.find('.edit_or_remove').removeClass('hidden');
                    get_row.find('.save_or_cancel').addClass('hidden');
                }else {
                    swal("خطأ",res.data['error_msg'],"error")
                }

                mApp.unblock("#products-block", {});

            }).catch(function (err) {

            });
        },
        show_delete_order_product: function (order_product) {

            var attribute_values = this.set_attribute_value(order_product.product_attribute_values__);

            swal({
                title: translations['sure_delete_2'] + " : " + order_product.product.name + " ؟ ",
                text: attribute_values,
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: translations['yes_delete'],
                cancelButtonText: translations['no_delete'],
                reverseButtons: !0
            }).then(function (e) {
                if (e.value) {
                    order_details.delete_order_product(order_product.id);
                } else {
                    e.dismiss && swal(translations['cancelled_delete'], translations['didnt_delete'], "error")
                }

            });
        },
        delete_order_product: function (order_product_id) {

            var currency_type = this.currency_type;

            mApp.block("#products-block", {});
            axios.post(get_url + "/admin/order/delete-order-product",
                {
                    order_product_id: order_product_id ,
                    currency_type : currency_type
                }).then(function (res) {

                if (res.data['status']) {
                    order_details.order = res.data['data']['order'];

                }else {
                    swal("خطأ",res.data['error_msg'],"error");
                }

                mApp.unblock("#products-block", {});
            }).catch(function (err) {

            });
        },

        set_date : function (order) {
            this.order.processing_at = order.processing_at;
            this.order.shipment_at = order.shipment_at;
            this.order.pending_at = order.pending_at;
            this.order.finished_at = order.finished_at;
            this.order.canceled_at = order.canceled_at;
            this.order.returned_at = order.returned_at;
            this.order.failed_at = order.failed_at;
        },


        ////////////////////////////////////////////////////
        show_add_products_to_order: function () {
             $('#m_modal_1').modal('show');
        } ,
        get_filter_product_data : function (product) {
            if(product && product.length > 0) {
                var product_attributes = product[0].attributes;
                var attributes = [];
                product_attributes.forEach(function (t) {
                    var attribute_values = [];
                    t.attribute_values.forEach(function (t2) {
                        t2.attribute_value.is_selected = t2.is_selected;
                        attribute_values.push(t2.attribute_value);
                    });
                    let get_selected = attribute_values.find(el => el.is_selected == 1);
                    let selected = '';
                    if(get_selected) {
                        selected = get_selected.id;
                    }
                    attributes.push({
                        id : t.attribute.id ,
                        name : t.attribute.name ,
                        key : t.attribute.attribute_type.key,
                        attribute_values :attribute_values ,
                        selected : selected ,

                    });
                });

                this.products.push({
                    id : product[0].id ,
                    name :product[0].name ,
                    image : product[0].image ,
                    attributes : attributes ,
                    quantity : 1 ,
                    random_id : makeid(25) ,
                });
            }


        } ,
        delete_attribute_product : function (index) {
            this.products.splice(index , 1);
        },
        add_products_to_order : function () {

            var this_ = this;
            var products = JSON.stringify(this.products);
            var order_id = this.order.id;
            var currency_type = this.currency_type;

            this.error_product_random_id ="";
            this.add_loading = true;

            mApp.block("#products-block", {});

            axios.post(get_url+"/admin/order/add-product-to-order" , {
                order_id : order_id ,
                products : products ,
                currency_type : currency_type ,
            }).then(function (res) {

                order_details.add_loading = false;
                let get_status = full_general_handle_response(res.data ,this_ , true);
                $('#m_modal_1').animate({ scrollTop: 0 }, 'slow');
                if(!res.data['status']) {
                    order_details.error_product_random_id = res.data['data']['random_id'];
                }else {
                    order_details.order = res.data['data']['order'];
                    setTimeout(function () {
                        $('#m_modal_1').modal('hide');
                        order_details.products = [];
                    } , 1500);
                }

                mApp.unblock("#products-block", {});
            }).catch(function (err) {
                mApp.unblock("#products-block", {});

            });

        },

        /////////////////////////////////////////////////////
        update_order_as_currency_type : function () {
            let order_id = this.order.id;
            let currency_type = this.currency_type;

            var params = {
                order_id : order_id ,
                currency_type : currency_type ,
            };

            mApp.block("#products-block", {});
            axios.get(get_url+'/admin/update-order-as-currency-type' ,{params}).then(function (res) {
                order_details.order = res.data;
                mApp.unblock("#products-block", {});
            }).catch(function (err) {
                mApp.unblock("#products-block", {});
            });
        },

        ///   edit order  //////////////
        show_edit_order: function () {
            this.edit_order_data = JSON.parse(JSON.stringify(this.order));
            $('#update_order_form').modal('show');
            $('#extra_data').prop('checked' , false);
            $('#extra_data').change();
            this.msg = {
                success: '',
                error: '',
            };
            $('.success_msg').addClass('hidden');
            $('.error_msg').addClass('hidden');

            this.countries =  JSON.parse(JSON.stringify(countries));
            this.cities =  JSON.parse(JSON.stringify(cities));
            this.$nextTick(function () {
                $('#select_cities').select2({placeholder: 'اختار مدينة'});
                $('#select_country').val(this.order.country_id_selected).trigger('change');
                $('#select_cities').val(this.order.city_id_selected).trigger('change');
            });
        },
        get_city_by_country_id: function (country_id) {

            $('#select_cities').prop('disabled', true);
            axios.get(get_url + "/admin/get-city-by-country-id/" + country_id).then(function (res) {
                $('#select_cities').prop('disabled', false);
                order_details.cities = res.data;
                order_details.$nextTick(function () {
                    $('#select_cities').select2({placeholder: 'اختار مدينة'});
                    $('#select_cities').change();
                });

            }).catch(function (err) {
                $('#select_cities').prop('disabled', false);
            })
        },
        get_shipping_companies_by_city_id: function (city_id) {
            $('#select_companies').prop('disabled', true);

            order_details.shipping_companies = [];
            axios.get(get_url + "/admin/get-shipping-companies-by-city-id/" + city_id).then(function (res) {
                $('#select_companies').prop('disabled', false);
                order_details.shipping_companies = res.data;
                order_details.$nextTick(function () {
                    $('#select_companies').change();

                });
            }).catch(function (err) {
                $('#select_companies').prop('disabled', false);
            })
        },
        get_payment_methods_by_shipping_company: function (shipping_company_id, city_id) {

            order_details.payment_methods = [];
            if(!shipping_company_id || !city_id) return;
            $('#get_payment_methods').prop('disabled', true);

            axios.get(get_url + "/admin/get-payment-methods-by-shipping-company/" + shipping_company_id + "/" + city_id)
                .then(function (res) {
                    $('#get_payment_methods').prop('disabled', false);
                    order_details.payment_methods = res.data;

                }).catch(function (err) {
                $('#get_payment_methods').prop('disabled', false);
            })
        },
        update_order_form_data : function () {
            let data = {
                id : this.edit_order_data.id ,
                first_name : this.edit_order_data.order_user_shipping.first_name ,
                last_name : this.edit_order_data.order_user_shipping.last_name ,

                phone : this.edit_order_data.user_phone ,
                email : this.edit_order_data.user_email ,

                gift_target_phone : this.is_gift ? this.edit_order_data.order_user_shipping.gift_target_phone : null,
                gift_first_name : this.is_gift ? this.edit_order_data.order_user_shipping.gift_first_name : null,
                gift_last_name : this.is_gift ? this.edit_order_data.order_user_shipping.gift_last_name : null,
                gift_target_email : this.is_gift ? this.edit_order_data.order_user_shipping.gift_target_email : null,
                gift_text : this.is_gift ? this.edit_order_data.order_user_shipping.gift_text : null,

                address : this.edit_order_data.order_user_shipping.address ,
                billing_national_address : this.edit_order_data.order_user_shipping.billing_national_address ,
                billing_building_number : this.edit_order_data.order_user_shipping.billing_building_number ,
                billing_postalcode_number : this.edit_order_data.order_user_shipping.billing_postalcode_number ,
                billing_extra_number : this.edit_order_data.order_user_shipping.billing_extra_number ,
                billing_unit_number : this.edit_order_data.order_user_shipping.billing_unit_number ,

                extra_data : $('#extra_data').is(':checked') ? 1 : 0 ,
                country_id : $('#select_country').val() ,
                city_id : $('#select_cities').val() ,
                shipping_company_id : $('#select_companies').val() ,
                payment_method_id : $('#get_payment_methods').val() ,
            };

            this.loading = true;
            let this_ = this;
            axios.post(get_url + "/admin/update-order-form-data" , data).then(function (res) {

                order_details.loading = false;
                let get_status = full_general_handle_response(res.data, this_, true);
                $('#update_order_form').animate({scrollTop: 0}, 'slow');

                if(res.data['status']) {
                    order_details.order = res.data['data']['order'];
                    setTimeout(function () {
                        $('#update_order_form').modal('hide');
                    }, 1500);
                }

            }).catch(function (err) {
                order_details.loading = false;
            });
        },

        ////// add_invoice_number /////////////////////
        add_invoice_number : function(){
            var order_id = this.order.id;
            var invoice_number = $('#invoice_number_input').val();

            this.invoice_number_loading = true;
            axios.post(get_url + "/admin/order-invoice/"+order_id,
                {
                    invoice_number : invoice_number,
                }
            ).then(function (res) {

                order_details.invoice_number_loading = false;
                $('#invoice_number_input').val(res.data['data']['invoice_number']);
                order_details.order.invoice_number = res.data['data']['invoice_number'];
                if (res.data['status']) {

                    toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "800",
                        "timeOut": "3000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    };

                    toastr.success(res.data['success_msg']);
                }else {
                    swal("خطأ",res.data['error_msg'],"error")
                }


            }).catch(function () {
                order_details.invoice_number_loading = false;
            });
        },

        ///// returned orde  /////////////////////////
        show_approve_return_order : function(){
            swal({
                title: " قبول طلب الاسترجاع",
                text: "هل متأكد من قبول طلب الاسترجاع",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText:"نعم",
                cancelButtonText: "لا , ارجع",
                reverseButtons: !0
            }).then(function (e) {
                if (e.value) {
                    order_details.approve_return_order();
                } else {
                    e.dismiss && swal("تم الرجوع عن الموافقة", "لم يتم الموافقة", "error")
                }

            });
        },
        show_reject_return_order : function(){
            swal({
                title: " رفض طلب الاسترجاع",
                text: "هل متأكد من رفض طلب الاسترجاع",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText:"نعم",
                cancelButtonText: "لا , ارجع",
                reverseButtons: !0
            }).then(function (e) {
                if (e.value) {
                    order_details.reject_return_order();
                } else {
                    e.dismiss && swal("تم الرجوع عن الرفض", "لم يتم الرفض", "error")
                }

            });
        },
        approve_return_order : function () {
            var order_id = this.order.id;

            this.return_order_loading = true;
            axios.get(get_url + "/admin/approve-order-return/"+order_id,).then(function (res) {

                order_details.return_order_loading = false;
                if (res.data['status']) {
                    order_details.order.returned_status = res.data['data']['returned_status'];
                    toastr.success(res.data['success_msg']);
                }else {
                    swal("خطأ",res.data['error_msg'],"error")
                }

            }).catch(function () {
                order_details.return_order_loading = false;
            });
        },
        reject_return_order : function () {
            var order_id = this.order.id;

            this.return_order_loading = true;
            axios.get(get_url + "/admin/reject-order-return/"+order_id,).then(function (res) {

                order_details.return_order_loading = false;
                if (res.data['status']) {
                    order_details.order.returned_status = res.data['data']['returned_status'];
                    toastr.success(res.data['success_msg']);
                }else {
                    swal("خطأ",res.data['error_msg'],"error")
                }

            }).catch(function () {
                order_details.return_order_loading = false;
            });
        },
        send_return_note:function () {
            var order_id = this.order.id;
            var formData = new FormData();
            formData.append('return_order_note_text', this.return_order_note_text);
            formData.append('return_order_note_file', this.return_order_note_file);

            axios.post(get_url + "/admin/send-return-order-note/"+order_id, formData).then(function (res) {

                if (res.data['status']) {

                    toastr.success(res.data['success_msg']);
                }else {
                    swal("خطأ",res.data['error_msg'],"error")
                }

            }).catch(function (err) {
                vm.loading = false;
            });



        }
,
        get_file: function (event, selector) {
            var file = event.target.files[0];
            if (file) {
                this.return_order_note_file = file;
                read_url(event.target, selector);
            } else {
                this.return_order_note_file = '';
            }

        },

    },
    watch : {
        currency_type : function (value) {
            this.update_order_as_currency_type();
        }
    }
});

$(document).ready(function () {
    $('.show_hidden').removeClass('hidden');
    $('#select_order_status').val(order_details.order.status).trigger('change');
    $("#m_select_remote_products").select2({
        placeholder: "ابحث عن المنتجات",
        allowClear: !0,
        ajax: {
            // url: "https://api.github.com/search/repositories",
            url: get_url + "/admin/get-details-products-ajax",
            dataType: "json",
            delay: 250,

            data: function (e) {
                return {q: e.term, page: e.page}
            },
            processResults: function (e, t) {
                return t.page = t.page || 1, {results: e.items, pagination: {more: e.incomplete_results}}
            },
            cache: !0
        },
        escapeMarkup: function (e) {
            return e
        },
        minimumInputLength: 3,
        language: {
            inputTooShort: function () {
                return 'الرجاء إدخال 3 أحرف أو أكثر';
            }
        },
        templateResult: function (e) {
            if (e.loading) return "جار البحث ...";
            return e.name || e.text;
        },
        templateSelection: function (e) {
            return e.name || e.text;
        },
    });

    $("#m_select_remote_products").change(function () {
        order_details.get_filter_product_data($(this).select2('data'));

    });


    $('#select_cities').select2({placeholder: 'اختار مدينة'});


    // edit order
    $('#extra_data').change(function () {
        if($('#extra_data').is(':checked')) {
            $('.show_extra_data').removeClass('hidden');
        }else {
            $('.show_extra_data').addClass('hidden');
        }
    });
    $('#select_country').change(function () {
        order_details.get_city_by_country_id($(this).val());
    });

    $('#select_cities').change(function () {
        order_details.get_shipping_companies_by_city_id($(this).val());
    });

    $('#select_companies').change(function () {
        order_details.get_payment_methods_by_shipping_company($(this).val() , $('#select_cities').val());
    });

});


