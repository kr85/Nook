{{ Form::open(['route' => 'login_route', 'id' => 'login_form', 'class' => 'navbar-form navbar-right']) }}

    <!-- Email Form Input -->
    <div class="form-group">
        {{ Form::email('email', null, ['class' => 'form-control login-field', 'required' => 'required', 'placeholder' => 'Email Address']) }}
    </div>

    <!-- Password Form Input -->
    <div class="form-group">
        {{ Form::password('password', ['class' => 'form-control login-field', 'required' => 'required', 'placeholder' => 'Password']) }}
    </div>

    <!-- Reset Password Link -->
    <div class="form-group dropdown">
        <span class="glyphicon glyphicon-question-sign forgot-password-icon dropdown-toggle" aria-hidden="true" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="false"></span>
        <p class="forgot-password-text">{{ link_to_route('password_remind', 'Forgot your password?') }}</p>
        <ul class="dropdown-menu" role="menu">
            <li class="forgot-password-text">{{ link_to_route('password_remind', 'Forgot Your Password?') }}</li>
        </ul>
    </div>

    <!-- Submit Form Input -->
    <div class="form-group">
        {{ Form::submit('Log In', ['class' => 'btn btn-primary btn-strong btn-login']) }}
    </div>

{{ Form::close() }}