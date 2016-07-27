<nav id="left-sidebar" class="col-sm-2">
    <ul class="nav nav-pills nav-stacked">
        @foreach ($managements as $management)
            <li><a href="{{ route($management['url']) }}">{{ $management['name'] }}</a></li>
        @endforeach
    </ul>
</nav>
