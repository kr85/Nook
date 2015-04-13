@extends('layouts.master')

@section('content')

    <div class="container">
        <div class="row">
            <div class="remind-form-wrapper">
                <h1 class="remind-form-header">Reset Your Password</h1>

                {{ Form::open(['route' => 'password_reset']) }}

                    {{ Form::hidden('token', $token) }}

                    <!-- Disable Remember Me -->
                    <div style="display: none;">
                        <input type="email" id="email" name="email" style="width: 0; height: 0;"/>
                        <input type="password" id="password" name="password" style="width: 0; height: 0;"/>
                    </div>

                    <!-- Email Form Input -->
                    <div class="form-group">
                        {{ Form::email('email', null, ['class' => 'form-control', 'required', 'placeholder' => 'Email Address']) }}
                    </div>

                    <!-- Password Form Input -->
                    <div class="form-group">
                        {{ Form::password('password', ['class' => 'form-control', 'required', 'placeholder' => 'Password']) }}
                    </div>

                    <!-- Password Confirmation Form Input -->
                    <div class="form-group">
                        {{ Form::password('password_confirmation', ['class' => 'form-control', 'required', 'placeholder' => 'Password Confirmation']) }}
                    </div>

                    <!-- Submit Form Input -->
                    <div class="form-group">
                        {{ Form::submit('Submit', ['class' => 'btn btn-primary btn-strong form-control']) }}
                    </div>

                {{ Form::close() }}
            </div>
        </div>
    </div>

@stop