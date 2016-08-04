@extends('news.create-update')

@section('form')

    {{ Form::open(['route' => 'admin.posts.store', 'files' => 'true']) }}
        @include('news.partials._form', ['buttonText' => trans('news.create_button')])
    {{ Form::close() }}

@endsection
