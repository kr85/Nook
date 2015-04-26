{{ Form::open(['route' => ['comment_route', $status->id], 'class' => 'comments_create-form', 'id' => 'comment-form-' . $status->id, 'data-id' => $status->id]) }}

    {{ Form::hidden('status_id', $status->id) }}
    {{ Form::hidden('user_id', $signedIn->id) }}

    <div class="form-group">

        {{ Form::textarea('body', null, ['class' => 'form-control comment-textarea', 'rows' => 1, 'placeholder' => 'Write a comment...']) }}

    </div>

{{ Form::close() }}