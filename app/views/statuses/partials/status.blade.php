<?php use Nook\Helpers\Helper; ?>
<div id="timeline-status-{{ $status->id }}" class="timeline-status">
    <div class="timeline-sidebar timeline-desktop">
        <div class="timeline-sidebar-user-image">
            @include('users.partials.avatar-round', ['user' => $status->user, 'size' => 40])
        </div>
        <ul>
            <li class="timeline-sidebar-username">
                <h4 class="media-heading">
                    <a href="{{ route('profile_route', $status->user->username) }}">
                        {{ Str::limit($status->user->username, 15) }}
                    </a>
                </h4>
            </li>
            <li class="timeline-sidebar-status-time status-media-time">
                {{ $status->present()->timeSincePublished() }}
            </li>
        </ul>
    </div>
    <div class="col-md-6_5">
        <div class="timeline-wrapper">
            <div class="status-comments-wrapper">
                @if($status->image)
                    <div class="status-image-box">
                        @if(Helper::statusImageExist($status->user->username, $status->image))
                            <img src="../media/profiles/{{ $status->user->username }}/statuses/{{ $status->image }}" alt="{{ $status->image }}" width="536" class="status-image"/>
                        @else
                            <img src="{{ $status->image }}" alt="{{ $status->image }}" width="536" class="status-image"/>
                        @endif
                    </div>
                @endif
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
                                {{ $status->user->username }}
                            </h4>
                            <p class="status-media-time timeline-mobile">
                                {{ $status->present()->timeSincePublished() }}
                            </p>
                            <div class="status-media-body" id="edit-status-form-box-{{ $status->id }}">
                                {{ Form::open(['id' => 'edit-status-form-'.$status->id, 'method' => 'PATCH', 'route' => ['update_status_route', $status->id]]) }}
                                    <span class="click-hide-show-{{ $status->id }}" data-show="#edit-status-input-{{ $status->id }}">
                                        {{ $status->body }}
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
                    <div class="status-likes-options">
                        <div class="status-options-box">
                            @include('statuses.partials.status-like', ['status' => $status])
                            <a href="" class="dropdown-toggle status-more-options" aria-hidden="true" data-toggle="dropdown"></a>
                            @include('statuses.partials.status-options', ['status' => $status])
                        </div>
                    </div>
                    <div class="comments" id="status-{{ $status->id }}-comments">
                        @unless($status->comments->isEmpty())
                            @foreach($status->comments as $comment)
                                @include('statuses.partials.comment', ['status' => $status])
                            @endforeach
                        @endunless
                    </div>
                @if($signedIn)
                    @include('statuses.partials.publish-comment-form', ['status' => $status])
                @endif
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>