<?php

use Nook\Statuses\PublishStatusCommand;
use Nook\Statuses\StatusRepository;
use Nook\Forms\PublishStatusForm;
use Nook\Statuses\DeleteStatusCommand;
use Nook\Statuses\HideStatusCommand;
use Nook\Statuses\UpdateStatusCommand;
use Nook\Statuses\LikeStatusCommand;
use Nook\Helpers\Helper;

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

        // Get user's timeline feed
        $statuses = $this->statusRepository->getFeedForUser(Auth::user());

        if (Request::ajax())
        {
            return View::make('statuses.partials.statuses', compact('statuses'));
        }

        return View::make('statuses.index', compact('statuses'));
    }

    /**
     * Save a new status.
     *
     * @return Response
     */
    public function store()
    {
        // Get input
        $input = Input::all();

        if ($input['image'])
        {
            // Validates the image
            if (!Helper::getValidImage($input)['success'])
            {
                // Return error response
                $response = [
                    'success'  => Helper::getValidImage($input)['success'],
                    'message'  => Helper::getValidImage($input)['message']
                ];

                return Response::json($response);
            }
        }

        // Validate the input
        $this->publishStatusForm->validate($input);

        // Executes the command
        $result = $this->execute(PublishStatusCommand::class, $input);

        // Check if an error message has been set
        if (isset($result['message']))
        {
            return Response::json([
                'success' => false,
                'message' => $result['message']
            ]);
        }

        // Store the status to a variable
        $status = $result['status'];

        // Render status view
        $view = View::make('statuses.partials.status', compact('status'))->render();

        // Return response
        $response = [
            'success'  => true,
            'timeline' => $view,
            'message'  => 'Your status has been posted.'
        ];

        return Response::json($response);
    }

    /**
     * Update a status.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Laracasts\Validation\FormValidationException
     */
    public function update($id)
    {
        // Get the input
        $input = [
            'body'     => Input::get('body'),
            'statusId' => $id,
            'userId'   => Auth::id()
        ];

        // Validates the input
        $this->publishStatusForm->validate($input);

        // Executes the command
        $this->execute(UpdateStatusCommand::class, $input);

        // Return response
        $response = [
            'success'  => true,
            'message'  => 'Your status has been updated.'
        ];

        return Response::json($response);
    }

    /**
     * Delete a status.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy()
    {
        // Get input
        $input = Input::all();

        // Execute delete status command with input
        $this->execute(DeleteStatusCommand::class, $input);

        // Return response
        $response = [
            'success'  => true,
            'message'  => 'Your status has been deleted.'
        ];

        return Response::json($response);
    }

    /**
     * Hide a status.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function hide()
    {
        // Get input
        $input = Input::all();

        // Execute hide status command with input
        $this->execute(HideStatusCommand::class, $input);

        // Return response
        $response = [
            'success'  => true,
            'message'  => 'The status has been successfully hidden.'
        ];

        return Response::json($response);
    }

    /**
     * Like a status.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function like()
    {
        // Get the input
        $input = Input::all();

        // Execute like status command with input
        $result = $this->execute(LikeStatusCommand::class, $input);

        // Store the status to a variable
        $status = $result['status'];

        // Render status view
        $view = View::make('statuses.partials.status', compact('status'))->render();


        // Return response
        $response = [
            'success'  => $result['success'],
            'liked'    => $result['liked'],
            'message'  => $result['message'],
            'timeline' => $view
        ];

        return Response::json($response);
    }
}
