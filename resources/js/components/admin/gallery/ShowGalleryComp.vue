<template>
    <div class="row vertical-scroll">
        <div class="col-sm-12 gallery_images">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <input type="text" class="form-control" v-model="gallery.search"
                               placeholder="search ...">
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="form-group">
                        <select class="form-control" v-model="gallery.type_id">
                            <option value="-1">الكل</option>
                            <option v-for="type in types" :value="type.id" v-text="type.name"></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="pointer col-sm-2 mt-10" v-for="image in gallery.images">
                    <div class="image-input image-input-outline">
                        <div class="image-input-wrapper">
                            <img  width="120" height="100" :src="image.src"/>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label @click="editGallery(image)" class="cursor-pointer">
                                    <i class="fa fa-edit" style="font-size: 18px;margin-top: -193%;margin-left: -31%;"></i>
                                </label>

                            </div>
                            <div class="col-sm-6">
                                <label @click="deleteGallery(image)" class="cursor-pointer">
                                    <i class="fa fa-window-close" style="font-size: 22px;margin-top: -105%;margin-left: -31%;"></i>
                                </label>
                            </div>
                        </div>
                        <!--<label @click="editGallery(image)" class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change"-->
                        <!--data-toggle="tooltip" title="" data-original-title="Change avatar">-->
                        <!--<i class="fa fa-edit" style="font-size: 18px;margin-top: -193%;margin-left: -31%;"></i>-->
                        <!--</label>-->
                        <!--<span  @click="deleteGallery(image)">-->
                        <!--<i class="fa fa-window-close" style="font-size: 22px;margin-top: -105%;margin-left: -31%;"></i>-->
                        <!--</span>-->


                    </div>
                    <div class="word-break" style="margin: 17px">الاسم : {{image.name}}</div>
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
</template>


<script>
    export default {
        props : ['types'] ,
        data: function () {
            return {
                gallery: {
                    images: [],
                    search: '',
                    type_id: -1,
                    page: 1,
                    next_page_url: ''
                },
            }
        },
        created : function () {
            let this_ = this;
            this.$root.$on('add-gallery-event' , function (value) {
                this_.gallery.images.unshift(value);
            });
            this.$root.$on('edit-gallery-event' , function (value) {
                let get_index = this_.gallery.images.findIndex(el => el.id == value.id);
                Vue.set(this_.gallery.images , get_index , value);
            });
            this.$root.$on('delete-gallery-event' , function (value) {
                let get_index = this_.gallery.images.findIndex(el => el.id == value.id);
                this_.gallery.images.splice(get_index , 1);
            });
            this.getImages(false);

        },
        methods : {
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
            showMore: function () {
                if (this.gallery.next_page_url != null) {
                    this.gallery.page++;
                    this.getImages(true);
                }
            },

            editGallery : function (image) {
                this.$emit('edit-gallery' , image);
            },
            deleteGallery : function (image) {
                this.$emit('delete-gallery' , image);
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
        }
    }
</script>

<style>
    .cursor-pointer {
        cursor: pointer;
    }
    .word-break  {
        word-break: break-all;
    }
    .vertical-scroll {
        height: 500px;
        overflow-y: auto;
    }
</style>