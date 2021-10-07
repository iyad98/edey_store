<template>
    <!-- Modal-->
    <div class="modal fade" id="galleryImageForm" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 580px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" v-text="add ?'إضافة' : 'تعديل' "></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <success-error-msg-component :success="msg.success" :error="msg.error"></success-error-msg-component>
                    <form class="form">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label> الاسم بالعربي</label>
                                <input type="text" class="form-control get_file_name"  v-model="obj_data.name_ar" placeholder=" الاسم بالعربي">
                            </div>
                            <div class="form-group col-sm-6">
                                <label>الاسم بالانجليزي</label>
                                <input type="text" class="form-control get_file_name" v-model="obj_data.name_en" placeholder="الاسم بالانجليزي">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label> النوع</label>
                                <select class="form-control" v-model="obj_data.type_id">
                                    <option v-for="type in types" :value="type.id" v-text="type.name"></option>
                                </select>
                            </div>
                            <div class="form-group col-sm-6" :class="this.add ? '': 'hidden'">
                                <advance-image-comp @getEmitFile="getEmitFile" attr_name="src" :shock_event="shock_event"
                                                    :original_image="obj_data.src" :default_image="default_image"
                                                    selector_id_image="image1" image_name="الصورة">
                                </advance-image-comp>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">

                    <button type="button" :disabled="loading" @click="makeAction" class="btn m-btn btn-primary"
                            :class="loading ? 'm-loader m-loader--light m-loader--left' : ''">
                        حفظ
                    </button>

                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">
                        رجوع
                    </button>

                </div>
            </div>
        </div>
    </div>
</template>


<script>
    let empty_obj = {
        name_ar: '',
        name_en: '',
        type_id: '',
        src: ''
    };

    export default {
        props : ['default_image','types' ,  'data', 'add', 'shock_event'] ,
        created: function () {
            let this_ = this;

            this.setObjData();
        },
        methods: {
            setObjData: function () {
                this.obj_data = this.add ? JSON.parse(JSON.stringify(empty_obj)) : JSON.parse(JSON.stringify(this.data));
            },

            makeAction: function () {
                if (this.add) {
                    this.addGallery();
                } else {
                    this.updateGallery();
                }
            },
            addGallery: function () {
                let this_ = this;
                var formData = new FormData();
                Object.keys(this.obj_data).forEach(function (key) {
                    formData.append(key, this_.obj_data[key]);
                });
                this_.show_loading();

                axios.post(get_url+"/admin/galleries", formData)
                    .then(function (res) {
                        this_.hide_loading();
                        let resposne = full_general_handle_response( res.data ,this_, true);
                        if(res.data.status) {
                            this_.$root.$emit('add-gallery-event' , res.data['data']['gallery']);
                            if(res.data.status) {
                                setTimeout(function () {
                                    $('#galleryImageForm').modal('hide');
                                } , 1500);
                            }
                        }

                    }).catch(function (err) {
                    this_.hide_loading();
                });
            },
            updateGallery: function () {
                let this_ = this;
                var formData = new FormData();
                Object.keys(this.obj_data).forEach(function (key) {
                    formData.append(key, this_.obj_data[key]);
                });
                formData.append("_method", "PUT");

                this_.show_loading();


                axios.post(get_url+"/admin/galleries/"+ this_.obj_data.id, formData)
                    .then(function (res) {
                        this_.hide_loading();
                        let resposne = full_general_handle_response( res.data ,this_, true);
                        this_.$root.$emit('edit-gallery-event' , res.data['data']['gallery']);
                        if(res.data.status) {
                            setTimeout(function () {
                                $('#galleryImageForm').modal('hide');
                            } , 1500);
                        }

                    }).catch(function (err) {
                    this_.hide_loading();
                });
            },
        },
        watch: {
            shock_event: function () {
                this.setObjData();
                this.msg = {success: '', error: ''};
            }
        }

    }
</script>