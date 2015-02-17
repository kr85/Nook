<div class="status-post">
    {{ Form::open(['route' => 'statuses_route', 'id' => 'post-status-form']) }}

        {{ Form::hidden('userId', $signedIn->id) }}

        <!-- Status Form Input -->
        <div class="form-group">
            {{ Form::textarea('body', null, ['id' => 'post-status-textarea', 'class' => 'form-control', 'rows' => 3, 'placeholder' => "What's on your mind?"]) }}
        </div>

        <!-- Button Form Input -->
        <div class="form-group status-post-submit">
            {{ Form::submit('Post Status', ['class' => 'btn btn-default btn-xs', 'id' => 'post-status']) }}
        </div>

    {{ Form::close() }}
</div>