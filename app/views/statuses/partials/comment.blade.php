<article class="comments_comment media status-media">
    <div class="pull-left">
        @include('users.partials.avatar', ['user' => $comment->owner, 'class' => 'status-media-object'])
    </div>

    <div class="media-body">
        <h4 class="media-heading">{{ $comment->owner->username }}</h4>

        <p class="status-media-time">
            {{ $comment->present()->timeSinceCommentPublished() }}
        </p>

        {{ $comment->body }}

    </div>
</article>