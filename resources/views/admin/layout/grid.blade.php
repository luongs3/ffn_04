@extends($layout)
@section("content")
    <div class="grid">
        <div class="page-title">
            <div class="title_left">
                <h3>{{ ucfirst(trans('general.subject', ['subject' => $subject])) }}</h3>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{ trans('label.manage_subject', ['subject' => $subject]) }}</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li>
                                <button id="btn-create" type="button"
                                    class="btn btn-default btn-lg btn-header"
                                    data-manage="{{ route('admin.' . $subject . '.index') }}"
                                    data-url="{{ route('admin.' . $subject . '.' . 'create') }}">
                                {{ trans('label.create') }}
                                </button>
                            </li>
                            <li>
                                <button id="btn-delete" type="button"
                                    class="btn btn-default btn-lg btn-header"
                                    data-manage="{{ route('admin.' . $subject . '.index') }}"
                                    data-url="{{ route('admin.' . $subject . '.' . 'destroy', ['id' => 1]) }}"
                                    data-alert="{{ trans('message.delete_these_items') }}"
                                    data-check="{{ trans('message.choose_item_before_deleting') }}">
                                {{ trans('label.delete') }}
                                </button>
                            </li>
                            <li>
                                <button id="btn-export" type="button"
                                    class="btn btn-default btn-lg btn-header"
                                    data-manage="{{ route('admin.' . $subject . '.index') }}"
                                    data-url="{{ route('admin.' . $subject . '.' . 'export') }}">
                                {{ trans('label.export') }}
                                </button>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table class="table table-bordered table-striped table-responsive table-grid" id="{{ $subject }}">
                            <thead>
                            <tr>
                                <th><span class="select-all">{{ trans('label.all') }}</span></th>
                                @foreach ($columns as $column)
                                    <th>{{ trans("label.$column") }}</th>
                                @endforeach
                                <th title="edit">{{ trans('label.edit') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (count($rows))
                                @foreach ($rows as $key => $row)
                                    <tr>
                                        <td>
                                            {!! Form::checkbox('select', $row['id'], false, ['class' => 'select']) !!}
                                        </td>
                                        @foreach ($columns as $column)
                                            @if ($column == 'image' || $column == 'avatar' || $column == 'logo')
                                                <td><img class="img img-thumbnail img-row" src="{{ asset($row[$column]) }}"></td>
                                            @else
                                                <td>{{ $row[$column] }}</td>
                                            @endif
                                        @endforeach
                                        <td>
                                            <a href="{{ route('admin.' . $subject . '.edit', ['id' => $row['id']]) }}" title="edit">
                                                <i class="glyphicon glyphicon-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        @if (count($rows))
                            {!! $rows->render() !!}
                            <span id="table-statistic">{{ trans('general.table_statistic', ['from' => $from, 'to' => $to, 'total' => $total]) }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
