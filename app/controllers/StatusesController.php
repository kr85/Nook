<?php

use Nook\Core\CommandBus;
use Nook\Statuses\PublishStatusCommand;
use Nook\Statuses\StatusRepository;
use Nook\Forms\PublishStatusForm;

/**
 * Class StatusesController
 */
class StatusesController extends BaseController
{
   use CommandBus;

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
   public function __construct(PublishStatusForm $publishStatusForm, StatusRepository $statusRepository)
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
      $statuses = $this->statusRepository->getAllForUser(Auth::user());

		return View::make('statuses.index', compact('statuses'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Save a new status.
	 *
	 * @return Response
	 */
	public function store()
	{
      // Validates the input
      $this->publishStatusForm->validate(Input::only('body'));

      // Executes the command
      $this->execute(
         new PublishStatusCommand(Input::get('body'), Auth::user()->id)
      );

      Flash::message('Your status has been posted!');

      return Redirect::refresh();
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
