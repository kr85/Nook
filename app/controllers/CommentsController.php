<?php

use Laracasts\Commander\CommanderTrait;
use Nook\Statuses\LeaveCommentOnStatusCommand;
use Nook\Forms\LeaveCommentForm;
use Nook\Statuses\DeleteCommentCommand;
use Nook\Statuses\StatusRepository;
use Nook\Statuses\UpdateCommentCommand;

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
     * @var StatusRepository
     */
    protected $statusRepository;

    /**
     * Constructor.
     *
     * @param StatusRepository $statusRepository
     * @param LeaveCommentForm $leaveCommentFormForm
     */
    public function __construct(
        StatusRepository $statusRepository,
        LeaveCommentForm $leaveCommentFormForm
    )
    {
        $this->statusRepository = $statusRepository;
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
        $statusId = Input::get('status_id');

        // Validate the input
        $this->leaveCommentFormForm->validate($input);

        // Execute a command to leave a comment
        $comment = $this->execute(LeaveCommentOnStatusCommand::class, $input);
        // Find the status
        $status = $this->statusRepository->findById($statusId);

        // Render comment view
        $view = View::make('statuses.partials.comment', compact('status', 'comment'))->render();

        // Return response
        $response = [
            'success'   => true,
            'view'      => $view,
            'message'   => 'Your comment has been posted.',
            'commentId' => $comment->id
        ];

        return Response::json($response);
    }

    /**
     * Update a comment.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Laracasts\Validation\FormValidationException
     */
    public function update()
    {
        // Get the input
        $input = Input::all();
        $statusId = $input['status_id'];

        // Validates the input
        $this->leaveCommentFormForm->validate($input);

        // Executes the command to update the comment
        $comment = $this->execute(UpdateCommentCommand::class, $input);

        // Find the status
        $status = $this->statusRepository->findById($statusId);

        // Render comment view
        $view = View::make('statuses.partials.comment', compact('status', 'comment'))->render();

        // Return response
        $response = [
            'success' => true,
            'message' => 'Your comment has been updated.',
            'view'    => $view
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