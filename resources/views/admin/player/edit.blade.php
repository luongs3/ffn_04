@extends($layout)
@section("content")
    {!! Form::model($player, ['route' => ['admin.players.update', $player['id']], 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'method' => 'PUT']) !!}
    <div class="page-header">
        <h2>{{ trans('label.player_profile') }}</h2>
        <button type="submit" class="btn btn-default btn-lg btn-header">{{ trans('label.save') }}</button>
        <button type="button" class="btn btn-default btn-lg btn-header" id="btn-back">{{ trans('label.back') }}</button>
    </div>
    @include('layout.error')
    <div class="col-sm-8">
        <div class="form-group">
            {!! Form::label('name', trans('label.name'), ['class' => 'control-label col-sm-2 required']) !!}
            <div class="col-sm-9">
                {!! Form::text('name', $player['name'], ['class' => 'form-control', 'required' => true]) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('role', trans('label.role'), ['class' => 'control-label col-sm-2']) !!}
            <div class="col-md-9">
                {!! Form::select('role', $roleValues, $player['role'], ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('teams', trans('label.teams'), ['class' => 'control-label col-sm-2']) !!}
            <div class="col-md-9">
                {!! Form::select('team_id', $teams, $player['team_id'], ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group" id="image-preview">
            {!! Form::label('image', trans('label.image'), ['class' => 'control-label']) !!}
            {!! Form::hidden('image_hidden', $player['image'], ['class' => 'form-control', 'id' => 'image_hidden']) !!}
            {!! Form::file('image', ['class' => 'form-control']) !!}
            <img class="img img-responsive" id="image-url" src="{{ asset($player['image']) }}">
        </div>
    </div>
    {!! Form::close() !!}
@endsection
