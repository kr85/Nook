<?php use Nook\Helpers\Helper; ?>
@if($status->body)
    <article class="media status-media">
@else
    <article class="media status-media-mobile" id="timeline-status-text-{{ $status->id }}">
@endif
        <div class="pull-left timeline-mobile">
            @include('users.partials.avatar-round', ['user' => $status->user])
        </div>
        <div class="media-body">
            <h4 class="media-heading timeline-mobile">
                <a href="{{ route('profile_route', $status->user->username) }}">
                    {{ Str::limit($status->user->username, 15) }}
                </a>
            </h4>
            <p class="status-media-time timeline-mobile">
                {{ $status->present()->timeSincePublished() }}
            </p>
            <div class="status-media-body" id="edit-status-form-box-{{ $status->id }}">
                {{ Form::open(['id' => 'edit-status-form-'.$status->id, 'method' => 'PATCH', 'route' => ['update_status_route', $status->id]]) }}
                    <span class="click-hide-show-{{ $status->id }}" data-show="#edit-status-input-{{ $status->id }}">
                        {{ Helper::getStatus($status->body) }}
                    </span>
                    @if($currentUser->id == $status->user->id)
                        <input
                            type="text"
                            id="edit-status-input-{{ $status->id }}"
                            name="body"
                            class="blur-update-hide-show"
                            data-id="{{ $status->id }}"
                            value="{{ $status->body }}"
                            style="display: none;"
                        />
                    @endif
                {{ Form::close() }}
            </div>
        </div>
    </article>