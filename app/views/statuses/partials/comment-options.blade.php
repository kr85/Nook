@if($comment->owner->id == $currentUser->id)
<ul class="dropdown-menu comment-dropdown-user" role="menu">
    <li id="{{ $comment->id }}" class="link-button edit-comment" title="Edit Comment"><i class="fa fa-pencil-square-o"></i></li>
    <li>
        {{ Form::open(['route' => ['delete_comment_route', $comment->id], 'method' => 'DELETE', 'class' => 'delete-comment-form', 'id' => 'delete-comment-form-' . $comment->id, 'data-id' => $comment->id]) }}

            {{ Form::hidden('comment_id', $comment->id) }}

            <button type="submit" class="link-button" title="Delete Comment">
                <i class="fa fa-trash-o"></i>
            </button>

        {{ Form::close() }}
    </li>
</ul>
@endif