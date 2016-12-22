<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <title>{{ $title or trans('label.football_news') }}</title>
    @include('layout.styles')
</head>
<body>
<div id="fb-root"></div>
@include('layout.navigation')
<div>
    <div class="col-sm-2"></div>
    <div class="col-sm-10">
        <section>
            @include('layout.result')
            @yield('content')
        </section>
    </div>
</div>
@include('layout.scripts')
@yield('script')
</body>
</html>