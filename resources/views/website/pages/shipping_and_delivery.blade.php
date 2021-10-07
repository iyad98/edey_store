
@extends('website.app.layout')
@section('title') {{show_website_title(@$title)}} @endsection
<style>#sort_by_orderby {
        width: auto !important;
    }</style>
@section('content-page')
    @include('website.partals.header')
    @include('website.partals.nav')


    <div class="contact-page">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <ol class="breadcrumb">
                @foreach($breadcrumb_arr as $key=>$breadcrumb)
                    @if($key+1 == count($breadcrumb_arr))
                        {{$breadcrumb['name']}}
                    @else
                        <li class="breadcrumb-item">  <a href="{{$breadcrumb['url']}}">{{$breadcrumb['name']}}</a></li>
                    @endif
                @endforeach

            </ol>
        </nav>
        <div class="container">
            <div class="head-title">
                {{$breadcrumb_title}}
            </div>
            <div class="row">

                <div class="col-12 ">
                    <div class="about-text">

                        <p>
                            {!! $shipping_and_delivery !!}
                        </p>

                    </div>
                </div>

            </div>
        </div>
    </div>

    @include('website.partals.services')
    @include('website.partals.subscribe')
    @include('website.partals.footer')
@stop()

@section('js')
    <script src="{{url('')}}/website/general/js/shop/shop.js"></script>


@stop()

