@extends($layout)
@section("content")
<div class="grid">
    <div class="page-header">
        <h2>
            {{ trans('label.create_account') }}
        </h2>
        <button type="button" class="btn btn-default btn-lg btn-header" id="btn-back">
            {{ trans('label.back') }}
        </button>
    </div>
    <div class="page-content">
        <div class="panel-body form-horizontal">
            @include('common.errors')
            {!! Form::open([
                'method' => 'POST',
                'action' => ['Admin\UserController@store'],
                'class' => 'form-horizontal frmAdminCreateUser',
            ]) !!}
                <div class="form-group">
                    {!! Form::label('name', trans('label.name'), ['class' => 'col-md-3 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('email', trans('label.email'), ['class' => 'col-md-3 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::text('email', old('email'), ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('password', trans('label.password'), ['class' => 'col-md-3 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::password('password', ['class' => 'form-control', 'id' => 'password']) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('label', trans('label.password_confirm'), ['class' => 'col-md-3 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::password('password_confirm', ['class' => 'form-control', 'id' => 'password_confirm']) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('role', trans('label.role'), ['class' => 'col-md-3 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::select('role', $optionRole, old('role'), ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('point', trans('label.point'), ['class' => 'col-md-3 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::text('point', old('point'), ['class' => 'form-control', 'id' => 'point']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-7 col-md-offset-3">
                        {!! Form::submit(trans('label.save'), ['class' => 'btn btn-info']) !!}
                        {!! Form::reset(trans('label.reset'), ['class' => 'btn btn-info']) !!}
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
