@extends($layout)
@section("content")
    <div class="grid">
        <div class="page-header">
            <h2>{{ trans('label.manage_subject', ['subject' => 'users']) }}</h2>
            <button id="btn-create" type="button"
                    class="btn btn-default btn-lg btn-header"
                    data-manage="{{ route('admin.users.index') }}"
                    data-url="{{ route('admin.users.create') }}">
                {{ trans('label.create') }}
            </button>
            <button id="btn-delete-user" type="button"
                    class="btn btn-default btn-lg btn-header"
                    data-manage="{{ route('admin.users.index') }}"
                    data-url="{{ route('admin.users.destroy', ['id' => 1]) }}"
                    data-alert="{{ trans('message.delete_these_items') }}"
                    data-check="{{ trans('message.choose_item_before_deleting') }}"
                    data-success="{{ trans('message.delete_successfully') }}">
                {{ trans('label.delete') }}
            </button>
            <button id="btn-export" type="button"
                class="btn btn-default btn-lg btn-header"
                data-manage="{{ route('admin.users.index') }}"
                data-url="{{ action('Admin\ExportController@index', ['subject' => 'users']) }}">
            {{ trans('label.export') }}
            </button>
            <div class="clearfix"></div>
        </div>
        <div class="page-content">
            @include('common.errors')
            @include('common.flash_message')
            <table class="table table-bordered table-striped table-responsive table-grid" id="users">
                <thead>
                    <tr>
                        <th><span class="select-all">{{ trans('label.all') }}</span></th>
                        <th>{{ trans('label.no') }}</th>
                        <th>{{ trans('label.name') }}</th>
                        <th>{{ trans('label.avatar') }}</th>
                        <th>{{ trans('label.role') }}</th>
                        <th>{{ trans('label.email') }}</th>
                        <th>{{ trans('label.activity') }}</th>
                        <th title="edit">{{ trans('label.edit') }}</th>
                        <th title="show">{{ trans('label.show') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $user)
                        <tr id = 'row-{{ $user->id }}'>
                            <td>
                                {!! Form::checkbox('select', $user->id, false, ['class' => 'select']) !!}
                            </td>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <a href="{{ route('admin.users.show', ['id' => $user->id]) }}" title="show">
                                    {{ $user->name }}
                                </a>
                            </td>
                            <td>
                                <img src="{{ url(isset($user['avatar']) ? $user['avatar'] : config('common.user.default_avatar')) }}" class="img img-thumbnail img-row">
                            </td>
                            <td>
                                <a href="{{ route('admin.users.show', ['id' => $user->id]) }}" title="show">
                                    {{ $optionRole[$user->role] }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.users.show', ['id' => $user->id]) }}" title="show">
                                    {{ $user->email }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.users.show', ['id' => $user->id]) }}" title="show">
                                    {{ $optionActive[$user->confirmed] }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.users.edit', ['id' => $user->id]) }}" title="edit">
                                    <i class="glyphicon glyphicon-edit"></i>
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.users.show', ['id' => $user->id]) }}" title="show">
                                    <i class="glyphicon glyphicon-arrow-right"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $users->render() !!}
        </div>
    </div>
@endsection
