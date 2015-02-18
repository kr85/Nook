<?php

use Laracasts\Commander\CommanderTrait;
use Nook\Statuses\LeaveCommentOnStatusCommand;
use Nook\Forms\LeaveCommentForm;

/**
 * Class CommentsController
 */
class CommentsController extends BaseController
{
    use CommanderTrait;

    /**
     * @var LeaveCommentForm
     */
    protected $leaveCommentFormForm;

    /**
     * Constructor.
     *
     * @param LeaveCommentForm $leaveCommentFormForm
     */
    public function __construct(LeaveCommentForm $leaveCommentFormForm)
    {
        $this->leaveCommentFormForm = $leaveCommentFormForm;
    }

	/**
     * Leave a new comment.
	 *
	 * @return Response
	 */
	public function store()
	{
        // Fetch the input
        $input = array_add(Input::all(), 'user_id', Auth::id());

        // Validate the input
        $this->leaveCommentFormForm->validate($input);

        // Execute a command to leave a comment
        $this->execute(LeaveCommentOnStatusCommand::class, $input);

        Flash::message('Your comment has been posted!');

        // Return response
        $response = [
            'success' => true,
            'message' => 'The comment has been successfully posted.'
        ];

        return Response::json($response);
	}
}