@extends('layouts.app')

<!-- Main Content -->
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('label.reset_password') }}</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @include('common.errors')
                    {!! Form::open([
                        'method' => 'POST',
                        'url' => '/password/email',
                        'class' => 'form-horizontal',
                    ]) !!}
                        <div class="form-group {{$errors->has('email') ? ' has-error' : ''}}">
                            {!! Form::label('email', trans('label.email_address'), ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                            {!! Form::email('email', old('email'), ['class' => 'form-control', 'id' => 'email']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                {!! Form::submit(trans('label.send_mail_reset_password'), ['class' => 'btn btn-primary']) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
