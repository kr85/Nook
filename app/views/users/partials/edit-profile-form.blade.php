<h1 class="edit-profile-header">Edit Profile</h1>

@include('partials.errors')

{{ Form::model($user, ['route' => ['update_profile_route', $user->id], 'method' => 'PATCH']) }}

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

    <div class="form-group">
        {{ Form::submit('Save', ['class' => 'btn btn-primary btn-strong form-control']) }}
    </div>

{{ Form::close() }}