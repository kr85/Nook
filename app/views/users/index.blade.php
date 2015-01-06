@extends('layouts.master')

@section('content')
    <h1>All Users</h1>

    @foreach($users->chunk(4) as $userSet)
        <div class="row users">
            @foreach($userSet as $user)
                <li class="col-md-3 user-block">
                    @include('partials.avatar', ['size' => 70])

                    <h4 class="user-block-username">{{ $user->username }}</h4>
                </li>
            @endforeach
        </div>
    @endforeach

    {{ $users->links() }}
@stop