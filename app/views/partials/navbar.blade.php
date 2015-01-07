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
            <ul class="nav navbar-nav">
                <li class="active">{{ link_to_route('users_route', 'Browse Users') }}</li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                @if($currentUser)
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <img class="navbar-gravatar" src="{{ $currentUser->present()->gravatar() }}" alt="{{ $currentUser->username }}"/>
                            {{ $currentUser->username }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li>{{ link_to_route('profile_route', 'Your Profile', $currentUser->username) }}</li>
                            <li><a href="#">Another action</a></li>
                            <li class="divider"></li>
                            <li>{{ link_to_route('logout_route', 'Log Out') }}</li>
                        </ul>
                    </li>
                @else
                    <li>{{ link_to_route('register_route', 'Register') }}</li>
                    <li>{{ link_to_route('login_route', 'Log In') }}</li>
                @endif
            </ul>
        </div>
    </div>
</nav>