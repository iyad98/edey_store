<?php $category_name = get_category_lang(); ?>

@extends('website.layout')
@section('title') {{show_website_title(@$title)}} @endsection
@push('css')
@endpush


@section('content')
    <!-- SECTION-NAV -->
    <div id="section-nav-wrap">
        <section id="section-nav">
            <div class="container">
                <p>
                    @for($i=0 ; $i < count($breadcrumb_arr) ; $i++)
                        <a href="{{$breadcrumb_arr[$i]['url']}}"> {{$breadcrumb_arr[$i]['name']}} </a>
                        @if($i +1 != count($breadcrumb_arr))
                            <span> / </span>
                        @endif
                    @endfor


                </p>
            </div>
        </section>
    </div>
    <!-- /SECTION-NAV -->

    <section id="details_page">
        <div class="container">

            <div id="all_products">
                <div class="row mb-3">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <div class="d-none d-sm-block"><input type="text" v-model="search"
                                                                placeholder="{{trans('website.search_brands')}}" value=""
                                                                class="searchInput">
                            <button  type="button" class="searchbtn"></button>
                        </div>
                    </div>
                    <div class="col-md-4"></div>
                </div>
                <div class="row">

                    <div class="col-lg-2 col-sm-3 col-6 " v-for="brand in get_brands">
                        <div class="brand_style">
                            <a class="align_item"
                               :href="'{{LaravelLocalization::localizeUrl('shop')}}?brand='+brand.slug">
                                <img width="100" height="100" :src="brand.image"/>
                            </a>
                        </div>

                    </div>

                </div>
                <div class="row mt-3" v-show="show_more">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4 align_item" @click="page=page+1">
                        <button class="btn btn-sm btn-success">{{trans('website.show_more')}}</button>
                    </div>
                    <div class="col-sm-4"></div>

                </div>
            </div>

            <div class="row">
                <div class="col-sm"></div>
                <div class="col-sm">
                </div>
                <div class="col-sm"></div>
            </div>
        </div>

    </section>

@endsection

@push('js')
    <script>
        var brands = {!! $brands !!};
        var brand_vue = new Vue({
            el: '#all_products',
            data: {
                brands: brands,
                page: 1,
                show_more: true,
                search : '',

            },
            computed: {
                get_brands: function () {

                    let page = this.page;
                    let search = this.search;
                    let get_brands = this.brands.filter(function (item, index) {
                        return item.name.toLowerCase().includes(search.toLowerCase());
                    });
                    let get_brands_ = get_brands.filter(function (item, index) {
                        return  index < ((page+1) * 40);
                    });
                    get_brands = get_brands.filter(function (item, index) {
                        return  index < (page * 40);
                    });
                    this.show_more = !(get_brands_.length == get_brands.length);
                    return get_brands;
                }
            },

        });
    </script>
@endpush
