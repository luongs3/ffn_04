@extends($layout)
@section("content")
<div class="grid">
    <div class="page-header">
        <h2>
            {{ trans('label.my_profile') }}
            {{ $message }}
        </h2>
        <button type="button" class="btn btn-default btn-lg btn-header" id="btn-back">
            {{ trans('label.back') }}
        </button>
    </div>
    <div class="page-content">
        <div class="panel-body form-horizontal">
            @include('common.errors')
            <div class="form-group">
                {!! Form::label('name', trans('label.name'), ['class' => 'col-md-3 control-label']) !!}
                <div class="col-md-6">
                    {!! Form::text('name', isset($user->name) ? $user->name : '', ['class' => 'form-control', 'disabled']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('email', trans('label.email'), ['class' => 'col-md-3 control-label']) !!}
                <div class="col-md-6">
                    {!! Form::text('email', $user->email, ['class' => 'form-control', 'disabled']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('avatar', trans('label.avatar'), ['class' => 'col-md-3 control-label']) !!}
                <div class="col-md-6">
                    <img src="{{ url(isset($user['avatar']) ? $user['avatar'] : config('common.user.default_avatar')) }}" class="img-thumbnail img-row">
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('confirmed', trans('label.activity'), ['class' => 'col-md-3 control-label']) !!}
                <div class="col-md-6">
                    {!! Form::text('confirmed', $optionActive[$user->confirmed], ['class' => 'form-control', 'disabled']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('role', trans('label.role'), ['class' => 'col-md-3 control-label']) !!}
                <div class="col-md-6">
                    {!! Form::select('role', $optionRole, $user->role, ['class' => 'form-control', 'disabled']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('confirmation_code', trans('label.confirmation_code'), ['class' => 'col-md-3 control-label']) !!}
                <div class="col-md-6">
                    {!! Form::text('confirmationCode', $user->confirmation_code, ['class' => 'form-control', 'disabled']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('point', trans('label.point'), ['class' => 'col-md-3 control-label']) !!}
                <div class="col-md-6">
                    {!! Form::text('point', $user->point, ['class' => 'form-control', 'disabled']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
