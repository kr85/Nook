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
                        <div id="status-{{ $status->id }}-image-loading" class="status-image-loading"></div>
                        @if(Helper::statusImageExist($status->user->username, $status->image))
                            <img
                                src="{{ Helper::getStatusImagePath($status->user->username, $status->image) }}"
                                alt="{{ $status->image }}"
                                width="{{ Helper::getStatusImageWidth($status->user->username, $status->image) }}"
                                height="{{ Helper::getStatusImageHeight($status->user->username, $status->image) }}"
                                class="status-image"
                                id="status-{{ $status->id }}-image"
                            />
                        @else
                            <img
                                src="{{ $status->image }}"
                                alt="{{ $status->image }}"
                                width="536"
                                class="status-image"
                                id="status-{{ $status->id }}-image"
                            />
                        @endif
                    </div>
                @endif
                <div id="status-{{ $status->id }}-body">
                    @include('statuses.partials.status-body', ['status' => $status])
                </div>
                    <div id="status-options-{{ $status->id }}">
                        @include('statuses.partials.status-likes-options', ['status' => $status])
                    </div>
                    <div>
                        <div class="comments" id="status-{{ $status->id }}-comments">
                            @unless($status->comments->isEmpty())
                                @foreach($status->comments as $comment)
                                    @include('statuses.partials.comment', ['status' => $status])
                                @endforeach
                            @endunless
                        </div>
                    </div>
                @if($signedIn)
                    @include('statuses.partials.publish-comment-form', ['status' => $status])
                @endif
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>