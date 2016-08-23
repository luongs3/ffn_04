@extends($layout)
@section('content')
    {!! Form::open(['route' => 'admin.match-events.store', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'method' => 'POST']) !!}
    <div class="page-header">
        <h2>{{ trans('label.create_match_event') }}</h2>
        <button type="submit" class="btn btn-default btn-lg btn-header">{{ trans('label.save') }}</button>
        <button type="button" class="btn btn-default btn-lg btn-header" id="btn-back"
            data-placeholders="{{ json_encode($placeHolders) }}"
        >
            {{ trans('label.back') }}
        </button>
    </div>
    @include('layout.error')
    <div class="col-sm-8">
        <div class="form-group">
            {!! Form::label('league_id', trans('label.leagues'), ['class' => 'control-label col-sm-2 required']) !!}
            <div class="col-md-9">
                {!! Form::select('league_id', $leagues, old('league_id'), ['class' => 'form-control', 'required' => true, 'placeholder' => trans('message.choose_one')]) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('season_id', trans('label.seasons'), ['class' => 'control-label col-sm-2 required']) !!}
            <div class="col-md-9">
                {!! Form::select('season_id', [], old('season_id'), ['class' => 'form-control', 'required' => true, 'placeholder' => trans('message.choose_one'), 'data-alert' => trans('message.choose_league_first')]) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('match_id', trans('label.match'), ['class' => 'control-label col-sm-2 required']) !!}
            <div class="col-md-9">
                {!! Form::select('match_id', [], old('match_id'), ['class' => 'form-control', 'required' => true, 'placeholder' => trans('message.choose_one'), 'data-alert' => trans('message.choose_season_first')]) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('time', trans('label.time'), ['class' => 'control-label col-sm-2']) !!}
            <div class="col-sm-9">
                {!! Form::number('time', old('time'), ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('title', trans('label.title'), ['class' => 'control-label col-sm-2']) !!}
            <div class="col-sm-9">
                {!! Form::text('title', old('title'), ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('content', trans('label.content'), ['class' => 'control-label col-sm-2']) !!}
            <div class="col-sm-9">
                {!! Form::textarea('content', old('content'), ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('icon_type', trans('label.icon_type'), ['class' => 'control-label col-sm-2']) !!}
            <div class="col-sm-9">
                {!! Form::select('icon', $iconTypes, old('icon_type'), ['class' => 'form-control', 'placeholder' => trans('message.choose_one')]) !!}
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group" id="image-preview">
            {!! Form::label('image', trans('label.image'), ['class' => 'control-label']) !!}
            {!! Form::hidden('image_hidden', null, ['class' => 'form-control', 'id' => 'image_hidden']) !!}
            {!! Form::file('image', ['class' => 'form-control']) !!}
            <img class="img img-responsive" id="image-url">
        </div>
    </div>
    {!! Form::close() !!}
@endsection
@section('script')
    {!! Html::script('/js/match_event.js') !!}
@endsection
