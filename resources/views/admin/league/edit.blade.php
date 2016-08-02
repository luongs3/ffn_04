@extends($layout)
@section("content")
    {!! Form::model($league, ['route' => ['admin.leagues.update', $league['id']], 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'method' => 'PUT']) !!}
    <div class="page-header">
        <h2>{{ trans('label.league_profile') }}</h2>
        <button type="submit" class="btn btn-default btn-lg btn-header">{{ trans('label.save') }}</button>
        <button type="button" class="btn btn-default btn-lg btn-header" id="btn-back">{{ trans('label.back') }}</button>
    </div>
    @include('layout.error')
    <div class="col-sm-8">
        <div class="form-group">
            {!! Form::label('name', trans('label.name'), ['class' => 'control-label col-sm-2 required']) !!}
            <div class="col-sm-9">
                {!! Form::text('name', $league['name'], ['class' => 'form-control', 'required' => true]) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('description', trans('label.description'), ['class' => 'control-label col-sm-2']) !!}
            <div class="col-sm-9">
                {!! Form::textarea('description', $league['description'], ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group" id="image-preview">
            {!! Form::label('image', trans('label.image'), ['class' => 'control-label']) !!}
            {!! Form::hidden('image_hidden', $league['image'], ['class' => 'form-control', 'id' => 'image_hidden']) !!}
            {!! Form::file('image', ['class' => 'form-control']) !!}
            <img class="img img-responsive" id="image-url" src="{{ asset($league['image']) }}">
        </div>
    </div>
    {!! Form::close() !!}
@endsection
