<?php

use Nook\Forms\SignInForm;

/**
 * Class SessionsController
 */
class SessionsController extends BaseController
{
    /**
     * @var SignInForm
     */
    protected $signInForm;

    /**
     * Constructor.
     *
     * @param SignInForm $signInForm
     */
    public function __construct(SignInForm $signInForm)
    {
        $this->beforeFilter('guest', ['except' => 'destroy']);

        $this->signInForm = $signInForm;
    }

    /**
     * Show the form for signing in.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('sessions.create');
    }


    /**
     * Store a newly created session.
     *
     * @return Response
     */
    public function store()
    {
        // Fetch the form input
        $input = Input::only('email', 'password');

        // Validate the input
        // If the input is invalid, then go back
        $this->signInForm->validate($input);

        // If the input is not valid, then redirect back
        if (!Auth::attempt($input))
        {
            Flash::message('Please check your credentials and try again.');

            return Redirect::back()->withInput();
        }

        // Otherwise, try to sign in and show a flash message
        Flash::message('Welcome back!');

        // Redirect to statuses
        return Redirect::intended('statuses');

    }

    /**
     * Sign out the user.
     *
     * @return Response
     */
    public function destroy()
    {
        // Logout the user
        Auth::logout();

        Flash::message('You have logged out!');

        return Redirect::home();
    }
}
