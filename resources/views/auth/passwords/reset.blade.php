@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('label.reset_password') }}</div>
                <div class="panel-body">
                    @include('common.errors')
                    {!! Form::open([
                        'method' => 'POST',
                        'url'  => '/password/reset',
                        'class' => 'form-horizontal'
                    ]) !!}
                        <div class="form-group {{$errors->has('email') ? ' has-error' : ''}}">
                            {!! Form::label('email', trans('label.email_address'), [
                            'class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::email('email', $email or old('email'), ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group {{$errors->has('password') ? ' has-error' : ''}}">
                            {!! Form::label('password', trans('label.password'), [
                            'class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::password('password', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group {{$errors->has('password_confirmation') ? ' has-error' : ''}}">
                            {!! Form::label('password-confirm', trans('label.password_confirm'), [
                            'class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::password('password', ['class' => 'form-control', 'id' => 'password-confirm']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                {!! Form::submit(trans('label.reset_password'), ['class' => 'btn btn-primary']) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
