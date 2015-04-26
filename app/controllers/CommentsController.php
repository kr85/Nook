<?php

use Laracasts\Commander\CommanderTrait;
use Nook\Statuses\LeaveCommentOnStatusCommand;
use Nook\Forms\LeaveCommentForm;
use Nook\Statuses\DeleteCommentCommand;

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
        $input = Input::all();

        // Validate the input
        $this->leaveCommentFormForm->validate($input);

        // Execute a command to leave a comment
        $comment = $this->execute(LeaveCommentOnStatusCommand::class, $input);

        // Render comment view
        $view = View::make('statuses.partials.comment', compact('comment'))->render();

        // Return response
        $response = [
            'success'  => true,
            'timeline' => $view,
            'message'  => 'Your comment has been posted.'
        ];

        return Response::json($response);
    }

    /**
     * Delete a comment.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
    {
        // Get input
        $input = Input::all();

        // Execute delete comment command with input
        $this->execute(DeleteCommentCommand::class, $input);

        // Return response
        $response = [
            'success'  => true,
            'message'  => 'Your comment has been deleted.'
        ];

        return Response::json($response);
    }
}