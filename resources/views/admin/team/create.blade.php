@extends($layout)
@section("content")
    {!! Form::open(['route' => 'admin.teams.store', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'method' => 'POST']) !!}
    <div class="page-header">
        <h2>{{ trans('label.create_subject', ['subject' => 'team']) }}</h2>
        <button type="submit" class="btn btn-default btn-lg btn-header">{{ trans('label.save') }}</button>
        <button type="button" class="btn btn-default btn-lg btn-header" id="btn-back">{{ trans('label.back') }}</button>
    </div>
    @include('layout.error')
    <div class="col-sm-8">
        <div class="form-group">
            {!! Form::label('name', trans('label.name'), ['class' => 'control-label col-sm-2 required']) !!}
            <div class="col-sm-9">
                {!! Form::text('name', old('name'), ['class' => 'form-control', 'required' => true]) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('description', trans('label.description'), ['class' => 'control-label col-sm-2']) !!}
            <div class="col-sm-9">
                {!! Form::textarea('description', old('description'), ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('leagues', trans('label.leagues'), ['class' => 'control-label col-sm-2']) !!}
            <div class="col-md-9">
                {!! Form::select('league_id', $leagues, null, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group" id="image-preview">
            {!! Form::label('image', trans('label.image'), ['class' => 'control-label']) !!}
            {!! Form::hidden('image_hidden', null, ['class' => 'form-control', 'id' => 'image_hidden']) !!}
            {!! Form::file('image', ['class' => 'form-control']) !!}
            <img class="img img-responsive" id="image-url" src="">
        </div>
    </div>
    <div id="select-players" class="select-players-class">
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
                            {!! Form::checkbox('players[]', $row['id'], false, ['class' => 'select']) !!}
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
    {!! Form::close() !!}
@endsection
