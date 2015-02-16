@extends('layouts.master')

@section('content')

    <div class="row">
        <div class="col-md-4">
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
        </div>
        <div class="col-md-6">
            @unless($user->is($currentUser))
                @include('users.partials.follow-form')
            @endunless

            @if($user->is($currentUser))
                @include('statuses.partials.publish-status-form')
            @endif

            <div class="scroller">
                @include('statuses.partials.statuses', ['statuses' => $statuses])
            </div>
        </div>
    </div>

@stop

@section('page-scripts')
    <script type="text/javascript">
        $(function() {
            $('ul.pagination:visible:first').hide();

            $('.scroller').jscroll({
                loadingHtml: '',
                debug: true,
                autoTrigger: true,
                nextSelector: '.pagination li.active + li a',
                contentSelector: 'div.scroller',
                callback: function() {
                    $('ul.pagination:visible:first').hide();
                }
            });
        });
    </script>
@stop