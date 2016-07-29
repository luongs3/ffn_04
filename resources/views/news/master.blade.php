<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ trans('news.news_title') }}</title>
    {!! Html::style('/bower/bootstrap/dist/css/bootstrap.min.css') !!}
    {!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css') !!}
    {!! Html::style('/css/custom.css') !!}
    @yield('head')
</head>

<body>

    @yield('content')

    {!! Html::script('/bower/masonry/dist/masonry.pkgd.min.js') !!}
</body>
</html>
