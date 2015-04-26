<nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
    <div class="container">
        @if(Route::getCurrentRoute()->getPath() != '/' &&
            Route::getCurrentRoute()->getName() != 'password_reset' &&
            Route::getCurrentRoute()->getName() != 'password_remind')
            <a href="{{ route('statuses_route') }}" class="navbar-desktop">
                <div class="navbar-home-icon-box">
                    <div class="navbar-home-icon"></div>
                </div>
            </a>
        @endif
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            @if(Route::getCurrentRoute()->getPath() == '/' ||
                Route::getCurrentRoute()->getName() == 'password_reset' ||
                Route::getCurrentRoute()->getName() == 'password_remind')
                <a class="navbar-brand" href="{{ route('home') }}">
                    <div class="navbar-logo-box-left">
                        <div class="navbar-logo"></div>
                    </div>
                </a>
            @else
                <a href="{{ route('statuses_route') }}" class="navbar-desktop">
                    <div class="navbar-logo-box-center">
                        <div class="navbar-logo"></div>
                    </div>
                </a>
                <a class="navbar-brand navbar-mobile-logo" href="{{ route('statuses_route') }}">
                    <div class="navbar-logo-box-left">
                        <div class="navbar-logo"></div>
                    </div>
                </a>
            @endif
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                @if($currentUser)
                    <li class="dropdown navbar-dropdown-link navbar-desktop">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="250" data-close-others="false">
                            <div class="navbar-user">
                                <img class="navbar-gravatar" src="{{ $currentUser->present()->gravatar() }}" alt="{{ $currentUser->username }}"/>
                                <strong>{{ Str::limit($currentUser->username, 15) }}</strong>
                            </div>
                        </a>
                        <ul class="dropdown-menu navbar-dropdown" role="menu">
                            <li>{{ link_to_route('profile_route', 'View Profile', $currentUser->username) }}</li>
                            <li>{{ link_to_route('edit_profile_route', 'Edit Profile', $currentUser->id) }}</li>
                            <li class="divider"></li>
                            <li>{{ link_to_route('logout_route', 'Log Out') }}</li>
                        </ul>
                    </li>
                    <li class="navbar-mobile-link">
                        {{ link_to_route('profile_route', 'View Profile', $currentUser->username) }}
                    </li>
                    <li class="navbar-mobile-link">
                        {{ link_to_route('edit_profile_route', 'Edit Profile', $currentUser->id) }}
                    </li>
                    <li class="navbar-mobile-link">
                        {{ link_to_route('logout_route', 'Log Out') }}
                    </li>
                @else
                    @include('pages.home.partials.login')
                @endif
            </ul>
        </div>
    </div>
</nav>