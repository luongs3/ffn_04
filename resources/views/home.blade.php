@extends($clientLayout)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-7">
            @foreach ($posts as $post)
                <div class="news-border row">
                    <div class="single-post col-md-4">
                        <div class="hover-effect">
                            <img class="img-responsive" src="{{ $post->imageLink() }}">
                            <div class="overlay">
                                <p>
                                    <a href="{{ $post->link() }}">{{ trans('news.read_more') }}</a>
                                </p>
                            </div>
                        </div>
                        <div class="post-content">
                            <ul class="post-tools list-inline">
                                <li><i class="fa fa-clock-o"></i> {{ $post->published_at->format('M jS Y g:ia') }}</li>
                                <li><i class="fa fa-user"></i> {{ $post->user->name }}</li>
                                <li>
                                    <a href="{{ route('leagues.show', [$post->league_id]) }}">
                                        <i class="glyphicon glyphicon-globe"></i> {{ $post->league->name }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <a href="{{ $post->link() }}">
                            <h3>{{ $post->title }}</h3>
                        </a>
                        <div class="news-post-content">
                            {!! $post->content !!}
                        </div>
                    </div>
                </div>
            @endforeach
            {{ $posts->render() }}
        </div>
        <div class="col-md-5 recent-matches">
            <div class="bg-purple recent-matches-title">{{ trans('label.next_matches') }}</div>
            <div class="recent-matches-content">
                @if (count($recentMatches))
                    @foreach ($recentMatches as $match)
                        <div class="match-box">
                            <span>
                                <img class="match-image pull-left" src="{{ asset(config('common.football.default_image')) }}">
                            </span>
                            <span class="match-content pull-left">
                                <span>
                                    <a href="{{ route('matches.show', ['id' => $match['id']]) }}">
                                        {{ $match['name'] }}
                                    </a>
                                </span><br>
                                <span>{{ $match['start_time'] }}</span>
                            </span>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
