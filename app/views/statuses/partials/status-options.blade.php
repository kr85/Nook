<ul class="dropdown-menu" role="menu">

    @if($status->user_id == $currentUser->id)
        <li>
            {{Form::open(['class' => 'delete-status', 'id' => 'form-delete-status-' . $status->id, 'method' => 'DELETE', 'route' => ['delete_status_route', $status->id]])}}

                {{ Form::hidden('statusIdToDelete', $status->id) }}
                {{ Form::submit('Delete Status', ['class' => 'link-button']) }}

            {{ Form::close() }}
        </li>
        <!--li>
            {{Form::open(['method' => 'PATCH', 'route' => ['update_status_route', $status->id]])}}

                {{ Form::hidden('statusIdToUpdate', $status->id) }}

                <input class="link-button" type="submit" value="Edit Status"/>

            {{ Form::close() }}
        </li-->
    @else
        <li>
            <p>Hide Status</p>
        </li>
    @endif
</ul>
