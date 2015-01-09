<nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ Auth::check() ? route('statuses_route') : route('home') }}">Nook</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            @if($currentUser)
                <ul class="nav navbar-nav">
                    <li class="active">{{ link_to_route('users_route', 'Browse Users', null, ['class' => 'bold']) }}</li>
                </ul>
            @endif
            <ul class="nav navbar-nav navbar-right">
                @if($currentUser)
                    <li class="navbar-profile-link">
                            <a href="{{ route('profile_route', $currentUser->username) }}">
                                <img class="navbar-gravatar" src="{{ $currentUser->present()->gravatar() }}" alt="{{ $currentUser->username }}"/>
                                <strong>{{ $currentUser->username }}</strong>
                            </a>
                    </li>
                    <li>
                        <p class="links-separator">|</p>
                    </li>
                    <li class="navbar-home-link">
                        <a href="{{ route('statuses_route') }}">
                            <strong><i class="fa fa-home fa-1x"></i> Home</strong>
                        </a>
                    </li>
                    <li>
                        <p class="links-separator">|</p>
                    </li>
                    <li class="dropdown navbar-dropdown-link">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="250" data-close-others="false">
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li>{{ link_to_route('profile_route', 'Your Profile', $currentUser->username) }}</li>
                            <li><a href="#">Another action</a></li>
                            <li class="divider"></li>
                            <li>{{ link_to_route('logout_route', 'Log Out') }}</li>
                        </ul>
                    </li>
                @else
                    @include('pages.home.partials.login')
                @endif
            </ul>
        </div>
    </div>
</nav>