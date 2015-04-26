@if($comment->owner->id == $currentUser->id)
    <span class="delete-comment pull-right">
        {{ Form::open(['route' => ['delete_comment_route', $comment->id], 'method' => 'DELETE', 'class' => 'delete-comment-form', 'id' => 'delete-comment-form-' . $comment->id, 'data-id' => $comment->id]) }}

            {{ Form::hidden('comment_id', $comment->id) }}

            <button type="submit" title="Delete Comment">
                <i class="fa fa-times"></i>
            </button>

        {{ Form::close() }}
    </span>
@endif