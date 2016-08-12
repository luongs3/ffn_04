@extends($layout)
@section('content')
    <div class="page-header">
        <h2>{{ trans('label.schedule') }}</h2>
    </div>
    <div class="col-sm-8 page-content">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="{{ route('leagues.show', ['id' => $schedule['league']['id']]) }}">
                    <span>{{ $schedule['league']['name'] }}</span>
                </a>
                <i class="glyphicon glyphicon-chevron-right"></i>
                    <span>{{ $schedule['season']['name'] }}</span>
                <i class="glyphicon glyphicon-chevron-right"></i>
                <a href="{{ route('leagues.schedule', ['id' => $schedule['league']['id']]) }}">
                    <span>{{ trans('label.schedule') }}</span>
                </a>
            </div>
            <div class='panel-body'>
                <table class="table table-striped table-bordered">
                    @if (!empty($schedule['matches']))
                        @foreach ($schedule['matches'] as $key => $schedule)
                            <thead>
                                <tr>
                                    <td class="schedule-matches-head" colspan="4">{{ $key }}</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schedule as $match)
                                    <tr>
                                        <td>{{ $match['start_time'] }}</td>
                                        <td>{{ $match['team1']['name'] }}</td>
                                        <td>{{ trans('label.vs') }}</td>
                                        <td>{{ $match['team2']['name'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @endforeach
                    @endif
                </table>
            </div>
        </div>
    </div>
@endsection
