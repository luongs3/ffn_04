@extends($layout)
@section("content")
    {!! Form::open(['route' => 'admin.ranks.store', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'method' => 'POST']) !!}
    <div class="page-header">
        <h2>{{ trans('label.create_subject', ['subject' => 'rank']) }}</h2>
        <button type="submit" class="btn btn-default btn-lg btn-header">{{ trans('label.save') }}</button>
        <button type="button" class="btn btn-default btn-lg btn-header" id="btn-back">{{ trans('label.back') }}</button>
    </div>
    @include('layout.error')
    <div class="col-sm-8">
        <div class="form-group">
            {!! Form::label('seasons', trans('label.seasons'), ['class' => 'control-label col-sm-2 required']) !!}
            <div class="col-md-9">
                {!! Form::select('season_id', $seasons, null, ['class' => 'form-control', 'required' => true, 'placeholder' => trans('message.choose_one')]) !!}
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
