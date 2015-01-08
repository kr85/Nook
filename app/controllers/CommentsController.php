<?php

use Laracasts\Commander\CommanderTrait;
use Nook\Statuses\LeaveCommentOnStatusCommand;

class CommentsController extends BaseController
{
    use CommanderTrait;
	/**
     * Leave a new comment.
	 *
	 * @return Response
	 */
	public function store()
	{
        // Fetch the input
        $input = array_add(Input::all(), 'user_id', Auth::id());

        // Execute a command to leave a comment
        $this->execute(LeaveCommentOnStatusCommand::class, $input);

        // Go back
        return Redirect::back();
	}
}