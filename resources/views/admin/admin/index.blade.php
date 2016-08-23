@extends('admin.layout.layout')
@section("content")
    <!-- top tiles -->
    <div class="row tile_count">
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> {{ trans('label.total_users') }}</span>
            <div class="count">{{ $user['user'] }}</div>
            <span class="count_bottom">
                @if ($user['new_user_percent'] > config('common.user.risk_level'))
                    <i class="green">
                        <i class="fa fa-sort-asc"> </i>
                        {{ $user['new_user_percent'] }}
                    </i>% {{ trans('label.from_last_week') }}
                @else
                    <i class="red">
                        <i class="fa fa-sort-desc"> </i>
                        {{ $user['new_user_percent'] }}
                    </i>% {{ trans('label.from_last_week') }}
                @endif
            </span>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-clock-o"></i> {{ trans('label.user_bet') }}</span>
            <div class="count">{{ $user['user_bet'] }}</div>
            <span class="count_bottom">
                @if ($user['new_user_percent'] > config('common.user.risk_level'))
                    <i class="green">
                        <i class="fa fa-sort-asc"> </i>
                        {{ $user['user_bet_percent'] }}
                    </i>% {{ trans('label.users') }}
                @else
                    <i class="red">
                        <i class="fa fa-sort-desc"> </i>
                        {{ $user['user_bet_percent'] }}
                    </i>% {{ trans('label.users') }}
                @endif

            </span>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> {{ trans('label.leagues') }}</span>
            <div class="count green">{{ $user['league'] }}</div>
        </div>
    </div>
    <!-- /top tiles -->

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="dashboard_graph" data-graph="{{ $user['user_bet_per_day'] }}">

                <div class="row x_title">
                    <div class="col-md-6">
                        <h3>{{ trans('label.bet_activities') }}
                            <small>{{ trans('label.bet_per_week') }}</small>
                        </h3>
                    </div>
                </div>

                <div class="col-md-9 col-sm-9 col-xs-12">
                    <div id="placeholder33" class="demo-placeholder"></div>
                    <div class="full-width">
                        <div id="canvas_dahs" class="demo-placeholder"></div>
                    </div>
                </div>
                @if (count($user['top_users']))
                    <div class="col-md-3 col-sm-3 col-xs-12 bg-white">
                        <div class="x_title">
                            <h2>{{ trans('label.top_bet_users') }}</h2>
                            <div class="clearfix"></div>
                        </div>
                        @foreach ($user['top_users'] as $topUser)
                            <div class="col-md-12 col-sm-12 col-xs-6">
                                <div>
                                    <p>{{ $topUser['name'] }}</p>
                                    <div class="">
                                        <div class="progress progress_sm">
                                            <div class="progress-bar bg-green" role="progressbar" aria-valuemin="0"
                                                 aria-valuemax="100"
                                                 data-transitiongoal="{{ $topUser['percent'] }}"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="clearfix"></div>
            </div>
        </div>

    </div>
    <br/>
    <!-- Posts and Google analytic -->
    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{ trans('label.recent_posts') }}
                        <small>{{ trans('label.sessions') }}</small>
                    </h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">{{ trans('label.settings_1') }}</a>
                                </li>
                                <li><a href="#">{{ trans('label.settings_2') }}</a>
                                </li>
                            </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="dashboard-widget-content">

                        <ul class="list-unstyled timeline widget">
                            @if (count($posts))
                                @foreach ($posts as $post)
                                    <li>
                                        <div class="block">
                                            <div class="block_content">
                                                <h2 class="title">
                                                    <a href="{{ action('NewsController@show', ['slug' => $post['slug']]) }}">{{ $post['title'] }}</a>
                                                </h2>
                                                <div class="byline">
                                                    <span>{{ $post['time_ago'] }}</span> {{ trans('general.by') }} <a>{{ $post['user']['name'] }}</a>
                                                </div>
                                                <p class="excerpt">{{ $post['content'] }}
                                                </p>
                                                <br>
                                                <a href="{{ route('admin.posts.edit', ['id' => $post['id']]) }}">{{ trans('label.edit') }}</a>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
