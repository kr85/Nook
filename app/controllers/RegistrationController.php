<?php

use Nook\Forms\RegistrationForm;
use Nook\Registration\RegisterUserCommand;

/**
 * Class RegistrationController
 */
class RegistrationController extends BaseController
{
    /**
     * @var RegistrationForm
     */
    protected $registrationForm;

    public function __construct(RegistrationForm $registrationForm)
    {
        $this->registrationForm = $registrationForm;

        // Allow only guest users
        $this->beforeFilter('guest');
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
        // Register a user command
        // Inject the user command into the command bus
        $user = $this->execute(RegisterUserCommand::class);

        // Login the user
        Auth::login($user);

        // Welcome message
        Flash::message('Happy to have you as a new Nook member!');

        return Redirect::to('statuses');
    }
}
