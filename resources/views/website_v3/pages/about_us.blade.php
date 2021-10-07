
@extends('website_v3.app.layout')
@section('title') {{show_website_title(@$title)}} @endsection

@section('content')


    <div class="block_breadcrumb">
        <div class="container">
            <ol class="breadcrumb">



                <li class="breadcrumb-item"><a href="{{url('')}}">الرئيسية</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$breadcrumb_title}}</li>
            </ol>
        </div>
    </div>
    <div class="content_innerPage">
        <div class="container">
            <div class="content_editor_page">
                <h2 class="mb-4">{{$breadcrumb_title}}</h2>

                <p>{!! $about_us !!}
                </p>
            </div>
        </div>
    </div>

@stop()

@section('js')


@stop()

