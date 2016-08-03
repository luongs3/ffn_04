@extends($layout)
@section("content")
    {!! Form::model($rank, ['route' => ['admin.ranks.update', $rank['id']], 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'method' => 'PUT']) !!}
    <div class="page-header">
        <h2>{{ trans('label.rank_profile') }}</h2>
        <button type="submit" class="btn btn-default btn-lg btn-header">{{ trans('label.save') }}</button>
        <button type="button" class="btn btn-default btn-lg btn-header" id="btn-back">{{ trans('label.back') }}</button>
    </div>
    @include('layout.error')
    <div class="col-sm-8">
        <div class="form-group">
            {!! Form::label('seasons', trans('label.seasons'), ['class' => 'control-label col-sm-2 required']) !!}
            <div class="col-md-9">
                {!! Form::select('season_id', $seasons, $rank['season_id'], ['class' => 'form-control', 'placeholder' => trans('message.choose_one'), 'required' => true]) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('teams', trans('label.teams'), ['class' => 'control-label col-sm-2']) !!}
            <div class="col-md-9">
                {!! Form::select('team_id', $teams, $rank['team_id'], ['class' => 'form-control', 'placeholder' => trans('message.choose_one')]) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('number', trans('label.number'), ['class' => 'control-label col-sm-2']) !!}
            <div class="col-sm-9">
                {!! Form::number('number', $rank['number'], ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('score', trans('label.score'), ['class' => 'control-label col-sm-2']) !!}
            <div class="col-sm-9">
                {!! Form::number('score', $rank['score'], ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
