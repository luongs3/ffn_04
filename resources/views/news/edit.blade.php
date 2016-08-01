@extends('news.create-update')

@section('form')

    {{ Form::model($post, ['route' => ['admin.posts.update', $post->id], 'method' => 'PUT', 'files' => 'true']) }}
        @include('news.partials._form', ['buttonText' => trans('news.update_button')])
    {{ Form::close() }}

@endsection
