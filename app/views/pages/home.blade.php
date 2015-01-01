@extends('layouts.master')

@section('content')

    <div class="jumbotron">
        <h1>Welcome to Nook!</h1>
        <p>Welcome to the new generation networking website. Why don't you sign up?</p>
        <p>
            {{ link_to_route('register_route', 'Sign Up!', null, ['class' => 'btn btn-lg btn-primary']) }}
        </p>
    </div>

@stop