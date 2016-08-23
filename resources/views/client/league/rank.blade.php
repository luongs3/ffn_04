@extends($layout)
@section('content')
    <div class="page-header">
        <h2>{{ trans('label.rank_table') }}</h2>
    </div>
    <div class="col-sm-8 page-content">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="{{ route('leagues.show', ['id' => $rank['league']['id']]) }}">
                    <span>{{ $rank['league']['name'] }}</span>
                </a>
                <i class="glyphicon glyphicon-chevron-right"></i>
                    <span>{{ $rank['season']['name'] }}</span>
                <i class="glyphicon glyphicon-chevron-right"></i>
                <a href="{{ route('leagues.{id}.ranks.index', ['id' => $rank['league']['id']]) }}">
                    <span>{{ trans('label.rank_table') }}</span>
                </a>
            </div>
            <div class='panel-body'>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <td>{{ trans('label.no') }}</td>
                            <td>{{ trans('label.team') }}</td>
                            <td>{{ trans('label.point') }}</td>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($rank['teams']))
                            @foreach ($rank['teams'] as $key => $team)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $team['team'] }}</td>
                                    <td>{{ $team['score'] }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
