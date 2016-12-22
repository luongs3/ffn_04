<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <ul class="nav navbar-nav navbar-left">
                <li>
                    <a class="navbar-brand" href="{{ action('HomeController@index') }}">
                        {{ trans('label.home') }}
                    </a>
                </li>
                @if (count($leagues))
                    @foreach ($leagues as $league)
                        <li>
                            <a href="{{ route('leagues.show', ['id' => $league['id']]) }}" title="{{ $league['name'] }}">
                                <img class="league-image-icon" src="{{ asset($league['image']) }}" title="{{ $league['name'] }}">
                            </a>
                        </li>
                    @endforeach
                @endif
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::guest())
                    <li>
                        <a href="{{ action('Auth\AuthController@getLogin') }}">
                            {{ trans('label.login') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ action('Auth\AuthController@getRegister') }}">
                            {{ trans('label.register') }}
                        </a>
                    </li>
                @else
                    {{ \Debugbar::disable() }}
                    <li class="">
                        <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset(Auth::user()->avatar) }}" alt="">
                            {{ Auth::user()->name }}
                            <span class=" fa fa-angle-down"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-usermenu pull-right">
                            <li>
                                <a href="{{ route('user.profiles.show', ['id' => Auth::user()->id]) }}">
                                    <span>{{ trans('label.profile') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user.profiles.edit', ['id' => Auth::user()->id]) }}">
                                    <span>{{ trans('label.edit') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/logout') }}">
                                    <i class="fa fa-sign-out pull-right"></i>
                                    <span>{{ trans('label.logout') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li id="user-message" role="presentation" class="dropdown"
                        data-url="{{ route('users.{id}.messages.index', ['id' => Auth::user()->id]) }}"
                        data-user-id="{{ Auth::user()->id }}"
                        data-messages="{{ trans('label.messages') }}"
                        data-type="{{ json_encode(config('common.message.type')) }}"
                        data-default="{{ asset(config('common.football.default_image')) }}"
                        data-unread-message-number="{{ Auth::user()->unread_message_number }}"
                        data-user-url="{{ route('ajax-users.update', ['id' => Auth::user()->id]) }}"
                    >
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</div>
