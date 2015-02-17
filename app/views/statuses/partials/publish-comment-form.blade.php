{{ Form::open(['route' => ['comment_route', $status->id], 'class' => 'comments_create-form', 'id' => $status->id . '-' . (count($status->comments) + 1)]) }}

    {{ Form::hidden('status_id', $status->id) }}

    <div class="form-group">

        {{ Form::textarea('body', null, ['id' => 'post-comment-textarea-' . $status->id . '-' . (count($status->comments) + 1), 'class' => 'form-control comment-textarea', 'rows' => 1, 'placeholder' => 'Write a comment and press Enter to post...']) }}

    </div>

{{ Form::close() }}