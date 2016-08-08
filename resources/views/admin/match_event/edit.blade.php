@extends($layout)
@section('content')
    {!! Form::model($matchEvent, ['route' => ['admin.matches.update', $matchEvent['id']], 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'method' => 'PUT']) !!}
    <div class="page-header">
        <h2>{{ trans('label.match_profile') }}</h2>
        <button type="submit" class="btn btn-default btn-lg btn-header">{{ trans('label.save') }}</button>
        <button type="button" class="btn btn-default btn-lg btn-header" id="btn-back">{{ trans('label.back') }}</button>
    </div>
    @include('layout.error')
    <div class="col-sm-8">
        <div class="form-group">
            {!! Form::label('match_id', trans('label.name'), ['class' => 'control-label col-sm-2 required']) !!}
            <div class="col-md-9">
                {!! Form::select('match_id', $matches, $matchEvent['match_id'], ['class' => 'form-control', 'required' => true, 'placeholder' => trans('message.choose_one')]) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('time', trans('label.time'), ['class' => 'control-label col-sm-2']) !!}
            <div class="col-sm-9">
                {!! Form::number('time', $matchEvent['time'], ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('title', trans('label.title'), ['class' => 'control-label col-sm-2']) !!}
            <div class="col-sm-9">
                {!! Form::text('title', $matchEvent['title'], ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('content', trans('label.content'), ['class' => 'control-label col-sm-2']) !!}
            <div class="col-sm-9">
                {!! Form::textarea('content', $matchEvent['content'], ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('icon_type', trans('label.icon_type'), ['class' => 'control-label col-sm-2']) !!}
            <div class="col-sm-9">
                {!! Form::select('icon_type', $iconTypes, $matchEvent['icon_type'], ['class' => 'form-control', 'placeholder' => trans('message.choose_one')]) !!}
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group" id="image-preview">
            {!! Form::label('image', trans('label.image'), ['class' => 'control-label']) !!}
            {!! Form::hidden('image_hidden', null, ['class' => 'form-control', 'id' => 'image_hidden']) !!}
            {!! Form::file('image', ['class' => 'form-control']) !!}
            <img class="img img-responsive" id="image-url" src="{{ asset($matchEvent['image']) }}">
        </div>
    </div>
    {!! Form::close() !!}
@endsection
