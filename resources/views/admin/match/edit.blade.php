@extends($layout)
@section('content')
    {!! Form::model($match, ['route' => ['admin.matches.update', $match['id']], 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'method' => 'PUT']) !!}
    <div class="page-header">
        <h2>{{ trans('label.match_profile') }}</h2>
        <button type="submit" class="btn btn-default btn-lg btn-header">{{ trans('label.save') }}</button>
        <button type="button" class="btn btn-default btn-lg btn-header" id="btn-back">{{ trans('label.back') }}</button>
    </div>
    @include('layout.error')
    <div class="col-sm-8">
        <div class="form-group">
            {!! Form::label('team1_id', trans('label.team1'), ['class' => 'control-label col-sm-2 required']) !!}
            <div class="col-md-9">
                {!! Form::select('team1_id', $teams, $match['team1_id'], ['class' => 'form-control', 'required' => true, 'placeholder' => trans('message.choose_one')]) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('team_2', trans('label.team2'), ['class' => 'control-label col-sm-2 required']) !!}
            <div class="col-md-9">
                {!! Form::select('team2_id', $teams, $match['team2_id'], ['class' => 'form-control', 'required' => true, 'placeholder' => trans('message.choose_one')]) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('score_team1', trans('label.score_team1'), ['class' => 'control-label col-sm-2']) !!}
            <div class="col-sm-9">
                {!! Form::number('score_team1', $match['score_team1'], ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('score_team2', trans('label.score_team2'), ['class' => 'control-label col-sm-2']) !!}
            <div class="col-sm-9">
                {!! Form::number('score_team2', $match['score_team2'], ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('place', trans('label.place'), ['class' => 'control-label col-sm-2']) !!}
            <div class="col-sm-9">
                {!! Form::text('place', $match['place'], ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('start_time', trans('label.start_time'), ['class' => 'control-label col-sm-2']) !!}
            <div class="col-sm-9">
                {!! Form::text('start_time', $match['start_time'], ['class' => 'form-control date-time']) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('end_time', trans('label.end_time'), ['class' => 'control-label col-sm-2']) !!}
            <div class="col-sm-9">
                {!! Form::text('end_time', $match['end_time'], ['class' => 'form-control date-time']) !!}
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
@section('script')
    {!! Html::script('/bower/jqueryui-timepicker-addon/dist/jquery-ui-timepicker-addon.min.js') !!}
    {!! Html::script('/js/match.js') !!}
@endsection
