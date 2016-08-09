@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">{{ trans('label.my_profile') }}</div>

                <div class="panel-body form-horizontal">
                    @include('common.errors')
                    @include('common.flash_message')
                    <div class="form-group">
                        {!! Form::label('name', trans('label.name'), ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::text('name', isset($user['name']) ? $user['name'] : '', ['class' => 'form-control', 'disabled']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('email', trans('label.email'), ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::text('email', isset($user['email']) ? $user['email'] : '', ['class' => 'form-control', 'disabled']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('avatar', trans('label.avatar'), ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-6">
                            <img src="{{ url(isset($user['avatar']) ? $user['avatar'] : config('common.user.default_avatar')) }}" class="img-thumbnail img-row">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-7 col-md-offset-3">
                            <a class="btn btn-info" href="{{ url('user/profiles/' . $user->id . '/edit') }}">
                                {{ trans('label.update_profile') }}
                            </a>
                            <a class="btn btn-info" href="{{ url('user/profiles/getChangePassword/' . $user->id) }}">
                                {{ trans('label.change_password') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
