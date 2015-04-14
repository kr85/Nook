<?php

use Nook\Statuses\PublishStatusCommand;
use Nook\Statuses\StatusRepository;
use Nook\Forms\PublishStatusForm;
use Nook\Statuses\DeleteStatusCommand;
use Nook\Statuses\HideStatusCommand;

/**
 * Class StatusesController
 */
class StatusesController extends BaseController
{
    /**
     * @var PublishStatusForm
     */
    protected $publishStatusForm;

    /**
     * @var StatusRepository
     */
    protected $statusRepository;

    /**
     * Constructor.
     *
     * @param PublishStatusForm $publishStatusForm
     * @param StatusRepository $statusRepository
     */
    public function __construct(
        PublishStatusForm $publishStatusForm,
        StatusRepository $statusRepository
    )
    {
        $this->publishStatusForm = $publishStatusForm;
        $this->statusRepository = $statusRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if (!Auth::check())
        {
            return Redirect::home();
        }

        $statuses = $this->statusRepository->getFeedForUser(Auth::user());

        return View::make('statuses.index', compact('statuses'));
    }

    /**
     * Save a new status.
     *
     * @return Response
     */
    public function store()
    {
        $input = array_add(Input::all(), 'userId', Auth::id());

        // Validates the input
        $this->publishStatusForm->validate($input);

        // Executes the command
        $this->execute(PublishStatusCommand::class, $input);

        Flash::message('Your status has been posted!');

        $response = [
            'success' => true,
            'message' => 'The status has been successfully posted.'
        ];

        return Response::json($response);
    }

    /**
     * Delete a status.
     *
     * @param $statusIdToDelete
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($statusIdToDelete)
    {
        // Get input and add status id to it
        $input = array_add(Input::all(), 'status_id', $statusIdToDelete);

        // Execute delete status command with input
        $this->execute(DeleteStatusCommand::class, $input);

        // Show flash message and refresh
        Flash::message('Your status has been deleted!');

        $response = [
            'success' => true,
            'message' => 'The status has been successfully deleted.'
        ];

        return Response::json($response);
    }

    /**
     * Hide a status.
     *
     * @param $statusIdToHide
     * @return \Illuminate\Http\JsonResponse
     */
    public function hide($statusIdToHide)
    {
        // Get input and add status id to it
        $input = [
            'user_id' => Auth::id(),
            'status_id' => $statusIdToHide
        ];

        // Execute delete status command with input
        $this->execute(HideStatusCommand::class, $input);

        // Show flash message and refresh
        Flash::message('The status has been successfully hidden.');

        $response = [
            'success' => true,
            'message' => 'The status has been successfully hidden.'
        ];

        return Response::json($response);
    }
}
