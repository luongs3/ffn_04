<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="single-post">
                    <div class="thumb">
                        <img class="img-responsive" src="{{ $post->imageLink() }}">
                    </div>
                    <div class="post-content">
                        <h1>{{ $post->title }}</h1>
                        <h3>{{ $message }}</h3>
                        <ul class="post-tools">
                            <li><i class="fa fa-clock-o"></i> {{ $post->published_at->format('M jS Y g:ia') }}</li>
                            <li><i class="fa fa-user"></i> {{ $post->user->name }}</li>
                            <li><i class="fa fa-folder-open"></i>{{ trans('label.news') }}</li>
                            <li><i class="fa fa-comments"></i> {{ trans('news.comments', ['comments' => count($comments)]) }}</li>
                            <li>
                                <div class="fb-like" data-href="{{ action('NewsController@show', [$post->slug]) }}" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
                            </li>
                        </ul>
                        <div class="news-post-content">
                            {!! $post->content !!}
                        </div>
                    </div>
                    @if (Auth::check())
                        <div class="row" id="comment">
                            <div class="col-md-2">
                                <img src="{{ url(Auth::user()->avatar) }} " class="img-circle avatar-comment">
                            </div>
                            <div class="col-md-10">
                                <h4>
                                    <a href="{{ route('user.profiles.show', ['id' => Auth::user()->id]) }}">{{ Auth::user()->name }}</a>
                                </h4>
                                <div class="box">
                                    <div class="form-group">
                                        {!! Form::hidden('postId', $post->id, ['id' => 'post-id']) !!}
                                        {!! Form::textarea('content', old('content'), ['class' => 'form-control', 'autofocus', 'rows' => 2, 'id' => 'content']) !!}
                                    </div>
                                    <div class="form-group">
                                        <button id='btn-comment' type="button" class="btn btn-comment" data-url="{{ action('User\CommentController@store') }}">
                                            {{ trans('label.comment') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (Auth::guest())
                        <div class="row">
                            <a href="{{ action('Auth\AuthController@getLogin') }}">{{ trans('message.login_page') }}</a>
                        </div>
                    @endif
                    <div class="row" id="comments">
                        @if (count($comments))
                            @foreach ($comments as $comment)
                                <div class="box-single-comment">
                                    <div class="col-md-2">
                                        <img src="{{ url($comment->user['avatar']) }}" class="img-circle avatar-comment">
                                    </div>
                                    <div class="col-md-10 content-comment">
                                        <h4>
                                            <a href="{{ route('user.profiles.show', ['id' => $comment->user_id]) }}" class="username-comment">
                                                {{ $comment->user['name'] }}
                                            </a>
                                        </h4>
                                        <div class="comment-box">
                                            <div class='hidden comment-edit'>
                                                <div class="box">
                                                    <div class="form-group">
                                                        {!! Form::textarea('content', $comment->content, ['class' => 'form-control content-edit', 'rows' => 2]) !!}
                                                    </div>
                                                    <div class="form-group">
                                                        <button data-id="{{ $comment->id }}" type="button" class="btn btn-update" data-url="{{ action('User\CommentController@update', ['$comment->id']) }}">
                                                            {{ trans('label.comment') }}
                                                        </button>
                                                        <button class="btn btn-info btn-cancel">{{ trans('label.cancel') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='comment-content'>
                                                <p>
                                                    {{ $comment->content }}
                                                </p>
                                                <div class="row feature-comment">
                                                    <ul class="list-inline">
                                                        <li>
                                                            {{ $comment->created_at->diffForHumans() }}
                                                        </li>
                                                        @can ('updateInfo', $comment->user)
                                                            <li>
                                                                <button data-id ="{{ $comment->id }}"
                                                                    type="button"
                                                                    class="btn btn-delete"
                                                                    data-url="{{ action('User\CommentController@destroy', ['id' => $comment->id]) }}">
                                                                    <span class="glyphicon glyphicon-trash"></span>
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button class="btn btn-edit"><span class="glyphicon glyphicon-edit"></span></button>
                                                            </li>
                                                        @endcan
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            {!! $comments->render() !!}
                        @endif
                    </div>
                    <div class="fb-comments" data-href="{{ action('NewsController@show', ['slug' => $post->slug]) }}" data-width="560" data-include-parent="false">
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="sidebar side-bar right-sidebar">

                    <div class="widget latest-posts">
                        <h3 class="side-title">{{ trans('news.latest_posts') }}</h3>
                        <div class="sidebar-content">
                            <ul class="small-grid">
                                @foreach ($latestPosts as $latestPost)
                                    <li>
                                        <div class="small-post">
                                            <div class="thumb">
                                                <img src="{{ $latestPost->imageLink() }}">
                                            </div>
                                            <div class="post-content">
                                                <h3>
                                                    <a href="{{ $latestPost->link() }}">{{ $latestPost->title }}</a>
                                                </h3>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
