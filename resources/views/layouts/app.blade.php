<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ trans('label.title') }}</title>
    <!-- Fonts -->
    {!! Html::style('/bower/bootstrap/dist/css/bootstrap.min.css') !!}
    {!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css') !!}
    {!! Html::style('/css/app.css') !!}
    {!! Html::style('/css/comment.css') !!}
    {!! Html::style('/css/custom.css') !!}
</head>
<body id="app-layout">
    @include('news.partials.header')
    @yield('content')
    {!! Html::script('/bower/jquery/dist/jquery.min.js') !!}
    {!! Html::script('/bower/bootstrap/dist/js/bootstrap.min.js') !!}
    {!! Html::script('/bower/jquery-validation/dist/jquery.validate.min.js') !!}
    {!! Html::script('js/validate.js') !!}
</body>
</html>
