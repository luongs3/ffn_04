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
                            <li><i class="fa fa-folder-open"></i> News</li>
                            <li><i class="fa fa-comments"></i> {{ trans('news.comments', ['comments' => 69]) }}</li>
                        </ul>

                        <div class="news-post-content">
                            {!! $post->content !!}
                        </div>

                    </div>

                    <div class="author m50">
                        <div class="author-thumb"><img src="{{ $post->user->gravatar }}" alt=""></div>
                        <div class="author-details">
                            <h3>
                                <a href="#">{{ $post->user->name }}</a>
                            </h3>
                            <p>At vero eos et accusamus et iusto odio ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio.</p>
                        </div>
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
