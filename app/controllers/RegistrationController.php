<?php

class RegistrationController extends \BaseController
{
	/**
	 * Show a form to register a new user.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('registration.create');
	}

   /**
    * Create a new Nook user.
    *
    * @return string
    */
   public function store()
   {
      return Redirect::home();
   }

}
