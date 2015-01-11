<article class="media status-media">
    <div class="pull-left">
        @include('users.partials.avatar', ['user' => $status->user])
    </div>

    <div class="media-body">
        <h4 class="media-heading">
            {{ $status->user->username }}
        </h4>

        <p>
            {{ $status->present()->timeSincePublished() }}
        </p>

        {{ $status->body }}
    </div>
    <div class="status-media-dropdown">
        @if($signedIn)
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="250" data-close-others="false">
                <i class="fa fa-chevron-down"></i>
            </a>
            @include('statuses.partials.status-options', ['status' => $status])
        @endif
    </div>
</article>

@if($signedIn)
    {{ Form::open(['route' => ['comment_route', $status->id], 'class' => 'comments_create-form']) }}
        {{ Form::hidden('status_id', $status->id) }}

        <div class="form-group">
            {{ Form::textarea('body', null, ['class' => 'form-control comment-textarea', 'rows' => 1, 'placeholder' => 'Write a comment and press Enter to post...']) }}
        </div>
    {{ Form::close() }}
@endif

@unless($status->comments->isEmpty())
    <div class="comments">
        @foreach($status->comments as $comment)
            @include('statuses.partials.comment')
        @endforeach
    </div>
@endunless