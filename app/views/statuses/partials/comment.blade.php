<article class="comments_comment media status-media" id="comment-{{ $comment->id }}">
    <div class="pull-left">
        @include('users.partials.avatar-round', ['user' => $comment->owner, 'class' => 'status-media-object'])
    </div>
    <div class="media-body">
        <h4 class="media-heading">
            <a href="{{ route('profile_route', $comment->owner->username) }}">
                {{ Str::limit($comment->owner->username, 30) }}
            </a>
            <a href="" class="dropdown-toggle delete-comment pull-right" aria-hidden="true" data-toggle="dropdown">
                <i class="fa fa-chevron-down"></i>
            </a>
            @include('statuses.partials.comment-options', ['comment' => $comment])
        </h4>
        <p class="status-media-time">
            {{ $comment->present()->timeSinceCommentPublished() }}
        </p>
        <div class="status-media-body" id="edit-comment-form-box-{{ $comment->id }}">
            {{ Form::open(['id' => 'edit-comment-form-'.$comment->id, 'method' => 'PATCH', 'route' => ['update_comment_route', $status->id, $comment->id]]) }}

                {{ Form::hidden('user_id', $signedIn->id) }}
                {{ Form::hidden('status_id', $status->id) }}
                {{ Form::hidden('comment_id', $comment->id) }}

                <span class="comment-click-hide-show-{{ $comment->id }}" data-show="#edit-comment-input-{{ $comment->id }}">
                    {{ $comment->body }}
                </span>
                @if($currentUser->id == $comment->owner->id)
                    <input
                        type="text"
                        id="edit-comment-input-{{ $comment->id }}"
                        name="body"
                        class="comment-blur-update-hide-show"
                        data-id="{{ $comment->id }}"
                        value="{{ $comment->body }}"
                        style="display: none;"
                    />
                @endif
            {{ Form::close() }}
        </div>
    </div>
</article>