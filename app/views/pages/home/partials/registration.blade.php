{{ Form::open(['route' => 'register_route', 'id' => 'registration_form', 'class' => 'registration-form']) }}

    <!-- Disable Remember Me -->
    <div style="display: none;">
        <input type="email" id="email" name="email" style="width: 0; height: 0;"/>
        <input type="password" id="password" name="password" style="width: 0; height: 0;"/>
    </div>

    <!-- Username Form Input -->
    <div class="form-group">
        {{ Form::text('username', null, ['class' => 'form-control', 'placeholder' => 'Username']) }}
    </div>

    <!-- Email Form Input -->
    <div class="form-group">
        {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email Address']) }}
    </div>

    <!-- Password Form Input -->
    <div class="form-group">
        {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) }}
    </div>

    <!-- Password Confirmation Form Input -->
    <div class="form-group">
        {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Password Confirmation']) }}
    </div>

    <!-- Form Submit -->
    <div class="form-group">
        {{ Form::submit('Sign Up', ['class' => 'btn btn-primary btn-strong form-control']) }}
    </div>

{{ Form::close() }}