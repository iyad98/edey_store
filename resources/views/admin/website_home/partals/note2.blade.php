
<div class="row top_row mt-3 mb-3">
    <div class="col-sm-3"></div>
    <div class="col-sm-6"><h5 style="font-weight: 600">{{trans('admin.sacand_note')}}</h5>
    </div>
</div>
<div class="row top_row mb-5">
    <div class="col-lg-4">

        <label>{{trans('admin.note_ar')}}:</label>
        <div class="input-group m-input-group m-input-group--square">
            <input type="text"
                   class="form-control m-input"
                   v-model="website_note_text_second.text_ar"
                   placeholder="{{trans('admin.note_ar')}}">

        </div>

    </div>
    <div class="col-lg-4">

        <label>{{trans('admin.note_en')}}:</label>
        <div class="input-group m-input-group m-input-group--square">
            <input type="text"
                   class="form-control m-input"
                   v-model="website_note_text_second.text_en"

                   placeholder="{{trans('admin.note_en')}}">
        </div>

    </div>
    <div class="col-lg-2">

        <div class="row" style="margin-top: 8%">

            <div class="col-sm-12">
                        <span class="get_status change_status m-switch m-switch--outline m-switch--icon m-switch--info">

                    <label>
                         <input type="checkbox" name="" id="website_note_text_second_checkbox">
	                     <span></span>
                    </label>
                </span>
            </div>
        </div>


    </div>
    <div class="col-lg-2">
        <button type="button" @click="update_website_note_text_second" :disabled="website_note_text_second_loading"
                class="btn m-btn btn-primary" style="width: 100px;"
                v-text="'{{trans('admin.save')}}'"
                :class="website_note_text_second_loading ? 'm-loader m-loader--light m-loader--left' : ''">
        </button>
    </div>

    <div class="col-lg-4 show_select_pointer">
        <label>{{trans('admin.select_pointer')}}:</label>
        <select class="form-control select_pointer_second_note">
            <option value="-1">{{trans('admin.not_found')}}</option>
            <option value="1">{{trans('admin.category')}}</option>
            <option value="2">{{trans('admin.product')}}</option>
            <option value="3">{{trans('admin.external_url')}}</option>

        </select>

    </div>
    <div class="col-lg-4 show_select_category_second_note hidden">
        <label>{{trans('admin.categories')}}:</label>
        <br>
        <div class="col-lg-12 col-md-12 col-sm-12" data-select2-id="80" id="m_select_category_form_div">
            <select class="form-control m-select2 " id="m_select_category_form_second_note" name="param"
                    data-select2-id="m_select_category_form_second_note" tabindex="-1" aria-hidden="true">
                <option value=""></option>
                @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->category_with_parents_text}}</option>
                @endforeach
            </select>
        </div>

    </div>
    <div class="col-lg-4 show_select_product_second_note hidden">
        <label>{{trans('admin.products')}}:</label>
        <div id="m_select_remote_marketing_products_div">
            <select class="form-control m-select2" id="m_select_remote_marketing_products_second_note"
                    name="param"
                    data-select2-id="m_select_remote_marketing_products_second_note">

            </select>
        </div>


    </div>
    <div class="col-lg-4 external_url_second_note hidden">
        <label>{{trans('admin.external_url')}}:</label>

        <input type="text" class="form-control" v-model="website_note_text_second.url"
               placeholder="{{trans('admin.external_url')}}"
               value="">
    </div>
</div>

<div class="row top_row mb-5">
    <div class="col-lg-4 show_select_pointer">
        <label>لون الخط :</label>
        <input type="color" class="form-control " v-model="website_note_text_second.text_color">
    </div>

    <div class="col-lg-4 show_select_pointer">
        <label>لون الخلفية :</label>
        <input type="color" class="form-control " v-model="website_note_text_second.background_color">



    </div>
</div>
<hr>

