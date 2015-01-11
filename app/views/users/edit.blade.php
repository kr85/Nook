@extends('layouts.master')

@section('content')

    <div class="row edit-profile-wrapper">
        <!--div class="col-md-4">
            <div class="media">
                <div class="pull-left">
                    @include('users.partials.avatar', ['size' => 50])
                </div>

                <div class="media-body">
                    <h1 class="media-heading">{{ $user->username }}</h1>
                    <ul class="list-inline text-muted">
                        <li>{{ $user->present()->statusCount() }}</li>
                        <li>{{ $user->present()->followerCount() }}</li>
                    </ul>

                    @foreach($user->followers as $follower)
                        @include('users.partials.avatar', ['size' => 25, 'user' => $follower])
                    @endforeach
                </div>

            </div>
        </div-->
        <div class="col-md-6 col-md-offset-3 edit-profile-form-wrapper">

            @include('users.partials.edit-profile-form')

        </div>
    </div>

@stop
