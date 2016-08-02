@extends($layout)
@section("content")
    {!! Form::model($season, ['route' => ['admin.seasons.update', $season['id']], 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'method' => 'PUT']) !!}
    <div class="page-header">
        <h2>{{ trans('label.season_profile') }}</h2>
        <button type="submit" class="btn btn-default btn-lg btn-header">{{ trans('label.save') }}</button>
        <button type="button" class="btn btn-default btn-lg btn-header" id="btn-back">{{ trans('label.back') }}</button>
    </div>
    @include('layout.error')
    <div class="col-sm-8">
        <div class="form-group">
            {!! Form::label('name', trans('label.name'), ['class' => 'control-label col-sm-2 required']) !!}
            <div class="col-sm-9">
                {!! Form::text('name', $season['name'], ['class' => 'form-control', 'required' => true]) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('leagues', trans('label.leagues'), ['class' => 'control-label col-sm-2']) !!}
            <div class="col-md-9">
                {!! Form::select('league_id', $leagues, $season['league_id'], ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
