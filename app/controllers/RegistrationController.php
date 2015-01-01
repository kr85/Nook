<?php

use Nook\Forms\RegistrationForm;
use Nook\Registration\RegisterUserCommand;
use Nook\Core\CommandBus;

/**
 * Class RegistrationController
 */
class RegistrationController extends BaseController
{

   use CommandBus;

   /**
    * @var RegistrationForm
    */
   protected $registrationForm;

   public function __construct(RegistrationForm $registrationForm)
   {
      $this->registrationForm = $registrationForm;
   }

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
      // Validate the input
      $this->registrationForm->validate(Input::all());

      // Extract the input
      extract(Input::only('username', 'email', 'password'));

      // Register a user command
      $command = new RegisterUserCommand($username, $email, $password);

      // Inject the user command into the command bus
      $user = $this->execute($command);

      // Login the user
      Auth::login($user);

      // Welcome message
      Flash::message('Happy to have you as a new Nook member!');

      return Redirect::home();
   }

}
