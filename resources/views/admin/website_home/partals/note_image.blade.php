<div class="row top_row mt-3 mb-3">
    <div class="col-sm-3"></div>
    <div class="col-sm-6"><h5 style="font-weight: 600">{{trans('admin.website_note_home')}}</h5>
    </div>
</div>
<div class="row top_row mb-5">
    <div class="col-lg-4">

        <label>{{trans('admin.image_website_ar')}}:</label>
        <div class="input-group m-input-group m-input-group--square">
            <input type="file" @change="get_file($event , '#image_ar' , 'image_ar')"
                   class="form-control m-input"
                   placeholder="{{trans('admin.image')}}">
            <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <img id="image_ar" width="100" height="100"
                                             :src="website_note.image_ar == ''? '{{get_general_path_default_image('settings')}}' :website_note.image_ar">
                                    </span>
            </div>
        </div>

    </div>
    <div class="col-lg-4">

        <label>{{trans('admin.image_website_en')}}:</label>
        <div class="input-group m-input-group m-input-group--square">
            <input type="file" @change="get_file($event , '#image_en' , 'image_en')"
                   class="form-control m-input"
                   placeholder="{{trans('admin.image')}}">
            <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <img id="image_en" width="100" height="100"
                                             :src="website_note.image_en == ''? '{{get_general_path_default_image('settings')}}' :website_note.image_en">
                                    </span>
            </div>
        </div>

    </div>
    <div class="col-lg-2">

        <div class="row" style="margin-top: 8%">

            <div class="col-sm-12">
                        <span class="get_status change_status m-switch m-switch--outline m-switch--icon m-switch--info">

                    <label>
                         <input type="checkbox" name="" id="website_note">
	                     <span></span>
                    </label>
                </span>
            </div>
        </div>


        {{--<select class="form-control" v-model="pop_up.status">--}}
            {{--<option value="1">{{trans('admin.active')}}</option>--}}
            {{--<option value="0">{{trans('admin.not_active')}}</option>--}}
            {{--</select>--}}

    </div>
    <div class="col-lg-2">
        <button type="button" @click="update_website_note" :disabled="website_note_loading"
                class="btn m-btn btn-primary" style="width: 100px;"
                v-text="'{{trans('admin.save')}}'"
                :class="website_note_loading ? 'm-loader m-loader--light m-loader--left' : ''">
        </button>
    </div>

    <div class="col-lg-4 show_select_pointer">
        <label>{{trans('admin.select_pointer')}}:</label>
        <select class="form-control select_pointer">
            <option value="-1">{{trans('admin.not_found')}}</option>
            <option value="1">{{trans('admin.category')}}</option>
            <option value="2">{{trans('admin.product')}}</option>
            <option value="3">{{trans('admin.external_url')}}</option>

        </select>

    </div>
    <div class="col-lg-4 show_select_category hidden">
        <label>{{trans('admin.categories')}}:</label>
        <br>
        <div class="col-lg-12 col-md-12 col-sm-12" data-select2-id="80" id="m_select_category_form_div">
            <select class="form-control m-select2 " id="m_select_category_form" name="param"
                    data-select2-id="m_select_category_form" tabindex="-1" aria-hidden="true">
                <option value=""></option>
                @foreach($categories as $category)
                <option value="{{$category->id}}">{{$category->category_with_parents_text}}</option>
                @endforeach
            </select>
        </div>

    </div>
    <div class="col-lg-4 show_select_product hidden">
        <label>{{trans('admin.products')}}:</label>
        <div id="m_select_remote_marketing_products_div">
            <select class="form-control m-select2" id="m_select_remote_marketing_products"
                    name="param"
                    data-select2-id="m_select_remote_marketing_products">

            </select>
        </div>


    </div>
    <div class="col-lg-4 external_url hidden">
        <label>{{trans('admin.external_url')}}:</label>

        <input type="text" class="form-control" v-model="website_note.url"
               placeholder="{{trans('admin.external_url')}}"
               value="">
    </div>
</div>
<hr>
