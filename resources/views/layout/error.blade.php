@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>
            {{ trans('general.whoops') }}
        </strong>
        {{ trans('general.input_errors') }}
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
