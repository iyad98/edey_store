
@extends('website_v2.app.layout')
@section('title'){{$breadcrumb_title}} @endsection

@section('content')


    <div class="block_breadcrumb">
        <div class="container">
            <ol class="breadcrumb">



                <li class="breadcrumb-item"><a href="{{url('')}}">الرئيسية</a></li>
            </ol>
        </div>
    </div>
    <div class="content_innerPage">
        <div class="container">
            <div class="content_editor_page">
                @if (session('status'))
                    <h2 style="text-align: center;"> {{ trans('website.reset_password_done') }}</h2>
                    <img src="/website_v2/images/done.svg" style="margin: auto;display: block;width: 50px;">
                @endif
            </div>
        </div>
    </div>




@stop()

@section('js')


@stop()

