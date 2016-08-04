@extends('news.master')

@section('style')
    {{ Html::style('/css/summernote.css') }}
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-9">

                @include('layout.result')
                @include('layout.error')

                @yield('form')

            </div>
        </div>
    </div>

@endsection

@section('script')
    {{ Html::script('/js/summernote.min.js') }}
    {{ Html::script('/js/custom.js') }}
@endsection

