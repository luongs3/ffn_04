<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="news-grid-style">
                    <div class="section-title blue-border">

                        <h2>{{ trans('news.news_index_title') }}</h2>

                        <div class="row">
                            <ul class="grid" data-masonry='{ "itemSelector": ".grid-item" }'>

                                @foreach ($posts as $post)
                                    <li class="grid-item col-md-6 col-sm-6">
                                        <div class="news-post-excerpt">
                                            <div class="hover-effect">
                                                <img class="img-responsive" src="{{ $post->imageLink() }}">
                                                <div class="overlay">
                                                    <p>
                                                        <a href="{{ $post->link() }}">{{ trans('news.read_more') }}</a>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="post-content">
                                                <div class="catname">
                                                    <a class="catname-btn btn-gray waves-effect waves-button" href="#">NEWS</a>
                                                </div>

                                                <h3>
                                                    <a href="{{ $post->link() }}">{{ $post->title }}</a>
                                                </h3>
                                                <ul class="post-tools">
                                                    <li><i class="fa fa-clock-o"></i> {{ $post->published_at->format('M jS Y g:ia') }}</li>
                                                    <li><i class="fa fa-user"></i> {{ $post->user->name }}</li>
                                                    <li><i class="fa fa-comments"></i> {{ trans('news.comments', ['comments' => 69]) }}</li>
                                                </ul>
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
        {!! $posts->render() !!}
    </div>
</div><!-- End Main Content -->
