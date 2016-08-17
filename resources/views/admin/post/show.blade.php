@extends('layout.layout')
@section("content")
<div class="grid">
    <div class="page-header">
        <h2>
            {{ trans('label.post') }}
            {{ $message }}
        </h2>
        <button type="button" class="btn btn-default btn-lg btn-header" id="btn-back">
            {{ trans('label.back') }}
        </button>
    </div>
    <div class="page-content">
        <div class="panel-body form-horizontal">
            @include('common.errors')
            <div class="form-group">
                {!! Form::label('name', trans('label.username'), ['class' => 'col-md-3']) !!}
                {!! $post->user['name']!!}
            </div>
            <div class="form-group">
                {!! Form::label('category', trans('label.category'), ['class' => 'col-md-3']) !!}
                {!! $post->category['name'] !!}
            </div>
            <div class="form-group">
                {!! Form::label('league', trans('label.league'), ['class' => 'col-md-3']) !!}
                {!! $post->league['name']!!}
            </div>
            <div class="form-group">
                {!! Form::label('title', trans('label.title'), ['class' => 'col-md-3']) !!}
                {!! $post->title !!}
            </div>
            <div class="form-group">
                {!! Form::label('content', trans('label.content'), ['class' => 'col-md-3']) !!}
                {!! $post->content !!}
            </div>
            <div class="form-group">
                {!! Form::label('published_at', trans('label.published_at'), ['class' => 'col-md-3']) !!}
                {!! $post->published_at !!}
            </div>
            <div class="form-group">
                {!! Form::label('is_post', trans('label.is_post'), ['class' => 'col-md-3']) !!}
                {!! $optionPost[$post->is_post] !!}
            </div>
            <div class="form-group">
                {!! Form::label('image', trans('label.image'), ['class' => 'col-md-3']) !!}
                <div class="col-md-6">
                    <img src="{{ url(isset($post['image']) ? $post['image'] : config('news.posts_image_default')) }}" class="img img-thumbnail img-row">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
