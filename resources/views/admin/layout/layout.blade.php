<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <title>{{ $title or trans('label.football_news') }}</title>
    @include('admin.layout.styles')
</head>
<body class="nav-md">
    <div id="fb-root"></div>
    <div class="container body">
        <div class="main_container">
            @include('admin.layout.left-sidebar')
            @include('admin.layout.navigation')
            <div class="right_col" role="main">
                @yield('content')
            </div>
        </div>
    </div>
    @include('admin.layout.scripts')
    @yield('script')
</body>
</html>
