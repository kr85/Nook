@extends('layouts.master')

@section('content')
    <h1 class="browser-users-header">All Users</h1>

    @foreach($users->chunk(4) as $userSet)
        <div class="row users">
            @foreach($userSet as $user)
                <li class="col-lg-3 col-md-3 col-sm-3 col-xs-5 col-lg-offset-0 col-md-offset-0 col-sm-offset-0 col-xs-offset-1 user-block">
                    @include('users.partials.avatar', ['size' => 70])

                    <h4 class="user-block-username">
                        {{ link_to_route('profile_route', $user->username, $user->username) }}
                    </h4>
                </li>
            @endforeach
        </div>
    @endforeach

    <div class="text-center">
        {{ $users->links() }}
    </div>
@stop