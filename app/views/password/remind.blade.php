@extends('layouts.master')

@section('content')

    <div class="row">
        <div class="remind-form-wrapper">
            <h1 class="remind-form-header">Reset Your Password?</h1>

            {{ Form::open(['route' => 'password_remind']) }}

            <!-- Email Form Input -->
            <div class="form-group">
                {{ Form::email('email', null, ['class' => 'form-control', 'required', 'placeholder' => 'Email Address']) }}
            </div>

            <!-- Reset Form Input -->
            <div class="form-group">
                {{ Form::submit('Reset Password', ['class' => 'btn btn-primary btn-strong form-control']) }}
            </div>

            {{ Form::close() }}
        </div>
    </div>
@stop