@extends('layout.layout')
@section("content")
<div class="grid">
    <div class="page-header">
        <h2>
            {{ trans('label.edit_account') }}
        </h2>
        <button type="button" class="btn btn-default btn-lg btn-header" id="btn-back">
            {{ trans('label.back') }}
        </button>
    </div>
    <div class="page-content">
        <div class="panel-body form-horizontal">
            @include('common.errors')
            {!! Form::open([
                'method' => 'PUT',
                'action' => ['Admin\UserController@update', $user->id],
                'class' => 'form-horizontal frmAdminUpdateUser',
            ]) !!}
                <div class="form-group">
                    {!! Form::label('name', trans('label.name'), ['class' => 'col-md-3 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::text('name', isset($user->name) ? $user->name : '', ['class' => 'form-control', 'id' => 'name']) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('email', trans('label.email'), ['class' => 'col-md-3 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::text('email', isset($user->email) ? $user->email : '', ['class' => 'form-control', 'id' => 'email']) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('role', trans('label.role'), ['class' => 'col-md-3 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::select('role', $optionRole, $user->role, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('point', trans('label.point'), ['class' => 'col-md-3 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::text('point', isset($user->point) ? $user->point : '', ['class' => 'form-control', 'id' => 'point']) !!}
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
