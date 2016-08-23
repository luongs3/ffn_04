<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
                <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
                <!-- Branding Image -->
            <a class="navbar-brand" href="{{ action('HomeController@index') }}">
                {{ trans('label.home') }}
            </a>
        </div>
        <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ action('Auth\AuthController@getLogin') }}">{{ trans('label.login') }}</a></li>
                    <li><a href="{{ action('Auth\AuthController@getRegister') }}">{{ trans('label.register') }}</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <i class="fa fa-user fa-fw"></i>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li>
                                <a href="{{ action('User\UserController@show', [Auth::user()->id]) }}">
                                    <i class="fa fa-user fa-fw"></i> {{ trans('label.my_profile') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ action('User\UserController@edit', [Auth::user()->id]) }}">
                                    <i class="fa fa-gear fa-fw"></i> {{ trans('label.setting') }}
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="{{ action('HomeController@getLogout') }}">
                                    <i class="fa fa-btn fa-sign-out"></i> {{ trans('label.logout') }}
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
