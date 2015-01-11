<div class="status-comments-wrapper">
    <article class="media status-media">
        <div class="pull-left">
            @include('users.partials.avatar', ['user' => $status->user])
        </div>

        <div class="media-body">
            <h4 class="media-heading">
                {{ $status->user->username }}
            </h4>

            <p class="status-media-time">
                {{ $status->present()->timeSincePublished() }}
            </p>

            <div class="status-media-body">
                {{ $status->body }}
            </div>
        </div>
        <div class="status-media-dropdown">
            @if($status->user_id == $currentUser->id)
                <a href="" class="dropdown-toggle" aria-hidden="true" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="false">
                    <i class="fa fa-chevron-down"></i>
                </a>
                @include('statuses.partials.status-options', ['status' => $status])
            @endif
        </div>
    </article>

    @unless($status->comments->isEmpty())
        <div class="comments">
            @foreach($status->comments as $comment)
                @include('statuses.partials.comment')
            @endforeach
        </div>
    @endunless

    @if($signedIn)
        {{ Form::open(['route' => ['comment_route', $status->id], 'class' => 'comments_create-form']) }}
        {{ Form::hidden('status_id', $status->id) }}

        <div class="form-group">
            {{ Form::textarea('body', null, ['class' => 'form-control comment-textarea', 'rows' => 1, 'placeholder' => 'Write a comment and press Enter to post...']) }}
        </div>
        {{ Form::close() }}
    @endif
</div>