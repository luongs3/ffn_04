@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">{{ trans('label.my_profile') }}</div>

                <div class="panel-body">
                    @include('common.errors')
                    {!! Form::open([
                        'action' => ['User\UserController@postChangePassword', $user->id],
                        'method' => 'POST',
                        'class' => 'form-horizontal frmChangePassword'
                    ]) !!}
                        <div class="form-group">
                            {!! Form::label('password', trans('label.password'), ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::password('password', ['class' => 'form-control', 'id' => 'password']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('newPassword', trans('label.new_password'), ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::password('newPassword', ['class' => 'form-control', 'id' => 'new-password']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('newPasswordConfirmation', trans('label.password_confirm'), ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::password('newPasswordConfirmation', ['class' => 'form-control', 'id' => 'new-password-confirmation']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-7 col-md-offset-3">
                                {!! Form::submit(trans('label.save'), ['class' => 'btn btn-primary']) !!}
                                {!! Form::reset(trans('label.reset'), ['class' => 'btn btn-default']) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
