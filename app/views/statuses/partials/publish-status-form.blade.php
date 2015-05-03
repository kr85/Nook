<div class="status-post">
    <div class="status-post-loading-box">
        <div class="status-post-loading-image-background"></div>
        <div class="status-post-loading-image"></div>
    </div>
    {{ Form::open(['route' => 'statuses_route', 'id' => 'post-status-form', 'files' => true]) }}

        {{ Form::hidden('user_id', $signedIn->id) }}

        <!-- Status Form Input -->
        <div class="form-group">
            {{ Form::textarea('body', null, ['id' => 'post-status-textarea', 'class' => 'form-control', 'rows' => 3, 'placeholder' => "What's on your mind?"]) }}
        </div>

        <!-- Button Form Input -->
        <div class="form-group status-post-submit">
            <div class="attach-image-wrapper" title="Attach an Image">
                <input type="file" name="image" id="image"/>
            </div>
            {{ Form::submit('Post Status', ['class' => 'btn btn-default btn-xs', 'id' => 'post-status']) }}
        </div>

    {{ Form::close() }}
</div>