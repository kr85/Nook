{{ Form::open(['route' => ['like_status_route', $status->id], 'class' => 'like-status-form', 'id' => 'form-like-status-' . $status->id, 'data-id' => $status->id]) }}

    {{ Form::hidden('status_id', $status->id) }}
    {{ Form::hidden('user_id', $signedIn->id) }}

    <span class="status-like-button-wrapper">
        @if($status->present()->didLike($signedIn->id))
            <input type="submit" value="" class="status-like-button status-liked" id="status-like-button-{{ $status->id }}"/>
        @else
            <input type="submit" value="" class="status-like-button" id="status-like-button-{{ $status->id }}"/>
        @endif
    </span>

{{ Form::close() }}