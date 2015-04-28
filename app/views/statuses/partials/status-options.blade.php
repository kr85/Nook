@if($status->user_id == $currentUser->id)
<ul class="dropdown-menu status-dropdown-user" role="menu">
    <li id="{{ $status->id }}" class="link-button edit-status" title="Edit Status"><i class="fa fa-pencil-square-o"></i></li>
    <li>
        {{ Form::open(['class' => 'delete-status', 'id' => 'form-delete-status-' . $status->id, 'data-id' => $status->id, 'method' => 'DELETE', 'route' => ['delete_status_route', $status->id]]) }}

            {{ Form::hidden('status_id', $status->id) }}

            <button type="submit" class="link-button" title="Delete Status" name="Delete Status">
                <i class="fa fa-trash-o"></i>
            </button>

        {{ Form::close() }}
    </li>
</ul>
@else
<ul class="dropdown-menu" role="menu">
    <li>
        {{ Form::open(['class' => 'hide-status', 'id' => 'form-hide-status-' . $status->id, 'data-id' => $status->id, 'method' => 'POST', 'route' => ['hide_status_route', $status->id]]) }}

            {{ Form::hidden('status_id', $status->id) }}
            {{ Form::hidden('user_id', $signedIn->id) }}

            {{ Form::submit('I don\'t want to see this.', ['class' => 'link-button']) }}

        {{ Form::close() }}
    </li>
</ul>
@endif
