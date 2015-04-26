<article class="comments_comment media status-media" id="comment-{{ $comment->id }}">
    <div class="pull-left">
        @include('users.partials.avatar-round', ['user' => $comment->owner, 'class' => 'status-media-object'])
    </div>

    <div class="media-body">
        <h4 class="media-heading">
            <a href="{{ route('profile_route', $comment->owner->username) }}">
                {{ Str::limit($comment->owner->username, 30) }}
            </a>
            @include('statuses.partials.comment-options', ['comment' => $comment])
        </h4>

        <p class="status-media-time">
            {{ $comment->present()->timeSinceCommentPublished() }}
        </p>

        {{ $comment->body }}

    </div>
</article>