<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ trans('news.news_title') }}</title>
    {!! Html::style('/bower/bootstrap/dist/css/bootstrap.min.css') !!}
    {!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css') !!}
    {!! Html::style('/css/custom.css') !!}
    {!! Html::style('/bower/sweetalert/dist/sweetalert.css') !!}
    @yield('style')
</head>

<body>

    @yield('content')

    @include('layout.scripts')
    {!! Html::script('/bower/masonry/dist/masonry.pkgd.min.js') !!}
    {!! Html::script('/bower/sweetalert/dist/sweetalert.min.js') !!}
    @include('sweet::alert')
    @yield('script')
</body>
</html>
