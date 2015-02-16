<?php

use Nook\Users\FollowUserCommand;
use Nook\Users\UnfollowUserCommand;

/**
 * Class FollowsController
 */
class FollowsController extends BaseController
{
	/**
	 * Follow a user.
	 *
	 * @return Response
	 */
	public function store()
	{
		// Get input and add user id to it
        $input = array_add(Input::all(), 'userId', Auth::id());

        // Execute follow user command with the input
        $this->execute(FollowUserCommand::class, $input);

        // Show a flash message and redirect back
        Flash::message('You are now following this user.');
        return Redirect::back();
	}


	/**
	 * Unfollow a user.
	 *
	 * @param  int  $userIdToUnfollow
	 * @return Response
	 */
	public function destroy($userIdToUnfollow)
	{
        // Get input and add user id to it
        $input = array_add(Input::all(), 'userId', Auth::id());

        // Execute follow user command with the input
		$this->execute(UnfollowUserCommand::class, $input);

        // Show a flash message and redirect back
        Flash::message('You have now unfollowed this user.');
        return Redirect::back();
	}

}