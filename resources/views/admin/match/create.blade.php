@extends($layout)
@section('content')
    {!! Form::open(['route' => 'admin.matches.store', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'method' => 'POST']) !!}
    <div class="page-header">
        <h2>{{ trans('label.create_subject', ['subject' => 'match']) }}</h2>
        <button type="submit" class="btn btn-default btn-lg btn-header">{{ trans('label.save') }}</button>
        <button type="button" class="btn btn-default btn-lg btn-header" id="btn-back">{{ trans('label.back') }}</button>
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
            {!! Form::label('team1_id', trans('label.team1'), ['class' => 'control-label col-sm-2 required']) !!}
            <div class="col-md-9">
                {!! Form::select('team1_id', [], old('team1_id'), ['class' => 'form-control teams', 'required' => true, 'placeholder' => trans('message.choose_one'), 'data-alert' => trans('message.choose_league_first')]) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('team_2', trans('label.team2'), ['class' => 'control-label col-sm-2 required']) !!}
            <div class="col-md-9">
                {!! Form::select('team2_id', [], old('team2_id'), ['class' => 'form-control teams', 'required' => true, 'placeholder' => trans('message.choose_one'), 'data-alert' => trans('message.choose_league_first')]) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('place', trans('label.place'), ['class' => 'control-label col-sm-2']) !!}
            <div class="col-sm-9">
                {!! Form::text('place', old('place'), ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('start_time', trans('label.start_time'), ['class' => 'control-label col-sm-2']) !!}
            <div class="col-sm-9">
                {!! Form::text('start_time', old('start_time'), ['class' => 'form-control date-time']) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('end_time', trans('label.end_time'), ['class' => 'control-label col-sm-2']) !!}
            <div class="col-sm-9">
                {!! Form::text('end_time', old('end_time'), ['class' => 'form-control date-time']) !!}
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
@section('script')
    {!! Html::script('/bower/jqueryui-timepicker-addon/dist/jquery-ui-timepicker-addon.min.js') !!}
    {!! Html::script('/js/match.js') !!}
@endsection
