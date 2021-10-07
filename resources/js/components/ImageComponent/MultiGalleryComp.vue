<template>

    <div class="modal fade" id="MultiGalleryImages" tabindex="-1" role="dialog" aria-labelledby="exampleModalSizeLg"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document" style="max-width: 84%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" >إضافة صورة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-3 vertical-line-left">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" @change="getFile($event)">
                                <label class="custom-file-label"></label>
                            </div>
                        </div>
                        <div class="col-sm-9 gallery_images vertical-line-left">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control search-gallery" v-model="gallery.search"
                                               placeholder="search ...">
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <select class="form-control search-gallery" v-model="gallery.type_id">
                                            <option value="-1">الكل</option>
                                            <option v-for="type in types" :value="type.id" v-text="type.name"></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="pointer col-sm-3 mt-3" v-for="image in gallery.images" :key="image.id"
                                     @click="setSelectedImage(image)">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <img :class="selected_image_ids.includes(image.id) ? 'image-selected' : ''" width="120"
                                                 height="100" :src="image.src"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 word-break">
                                            الاسم : {{image.name}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4">
                                    <button @click="showMore" type="button" class="btn btn-primary btn-sm mr-2">
                                        عرض المزيد
                                    </button>
                                </div>
                                <div class="col-sm-4"></div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!--<button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">-->
                    <!--{{__('admin.cancel')}}-->
                    <!--</button>-->
                    <button @click="sendFile" type="button" style="width: 120px;"
                            class="btn btn-primary font-weight-bold">حفظ
                    </button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {

        props: ['default_image', 'attr_name', 'selector_id_image' , 'obj' , 'shock_multi_image_event'],
        data: function () {
            return {
                gallery: {
                    images: [],
                    search: '',
                    type_id: -1,
                    page: 1,
                    next_page_url: ''
                },
                types: [],
                selected_image: [],
                selected_image_ids : [],
            }
        },
        created: function () {
//            this.selected_image.push({
//                id: '',
//                src: this.default_image,
//                name: '',
//                file: null
//            });
            this.getImages(false);
            this.getTypes();
        },
        methods: {
            getTypes: function () {
                let this_ = this;
                axios.get(get_url+'/admin/get-remote-gallery-types').then(function (res) {
                    this_.types = res.data['data']['gallery_types'];
                }).catch(function (err) {
                });
            },
            getImages: function (push) {
                let this_ = this;
                this.gallery.page = push ? this.gallery.page++ : 1;

                this_.blockUI('.gallery_images');
                axios.get(get_url+'/admin/get-remote-galleries',
                    {
                        params: {
                            search: this_.gallery.search,
                            type_id: this_.gallery.type_id,
                            page: this_.gallery.page
                        }
                    }).then(function (res) {

                    if (push) {
                        res.data['data'].forEach(function (item) {
                            this_.gallery.images.push(item);
                        });
                    } else {
                        this_.gallery.images = res.data['data'];
                    }

                    this_.gallery.next_page_url = res.data['next_page_url'];
                    this_.UnblockUI('.gallery_images');

                }).catch(function (err) {
                    this_.UnblockUI('.gallery_images');
                });
            },

            setSelectedImage: function (image) {

                if(!this.pluck(this.selected_image , 'id').includes(image.id)) {
                    this.selected_image.push({
                        id: image.id,
                        src: image.src,
                        name: image.name,
                        file: null
                    });
                    $('.custom-file-label').text('');
                }else {
                    this.selected_image.splice(this.selected_image.findIndex(el => el.id == image.id) , 1);
                }
                this.selected_image_ids = this.pluck(this.selected_image , 'id');
            },
            getFile: function (event) {
                let this_ = this;
                var file = event.target.files[0];

                var formData = new FormData();
                formData.append('src', file);
                formData.append('name_ar', file.name);
                formData.append('name_en', file.name);
                formData.append('type_id', this.gallery.type_id == -1 ? 1 : this.gallery.type_id);

                this_.blockUI('.gallery_images');

                axios.post(get_url+"/admin/galleries", formData)
                    .then(function (res) {
                        this_.UnblockUI('.gallery_images');

                        let resposne = full_general_handle_response( res.data ,this_, true);
                        this_.gallery.images.unshift(res.data['data']['gallery']);
                        $('.custom-file-label').text('');
                    }).catch(function (err) {
                    this_.UnblockUI('.gallery_images');
                });
            },

            showMore: function () {
                if (this.gallery.next_page_url != null) {
                    this.gallery.page++;
                    this.getImages(true);
                }
            },
            sendFile: function () {
                this.$emit('get-advance-emit-multi-file',this.obj , this.selected_image , this.attr_name);
                $('#MultiGalleryImages').modal('hide');
            }
        },
        watch: {
            "gallery.search": function (value) {
                if (value.length >= 3 || value.length == 0) {
                    this.getImages(false);
                }
            },
            "gallery.type_id": function (value) {
                this.getImages(false);
            },
            shock_multi_image_event : function () {
                this.selected_image = [];
                this.selected_image_ids = [];
            },
        }
    }
</script>

<style>
    .image-selected {
        border: 4px solid #3fccc5;
    }

    img {
        border-radius: 17px;
    }

    .vertical-line-left {
        border-left: 1px solid #00000054;
    }

    .vertical-line-right {
        border-right: 1px solid #00000054;
    }
    .word-break{
        word-break: break-all;
    }
</style>