<?php

use Nook\Users\UserRepository;
use Nook\Statuses\StatusRepository;
use Nook\Forms\EditProfileForm;
use Nook\Users\EditProfileCommand;

/**
 * Class UsersController
 */
class UsersController extends BaseController
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var StatusRepository
     */
    protected $statusRepository;

    /**
     * @var EditProfileForm
     */
    protected $editProfileForm;

    /**
     * Constructor.
     *
     * @param UserRepository $userRepository
     * @param StatusRepository $statusRepository
     * @param EditProfileForm $editProfileForm
     */
    public function __construct(
        UserRepository $userRepository,
        StatusRepository $statusRepository,
        EditProfileForm $editProfileForm
    )
    {
        $this->userRepository = $userRepository;
        $this->statusRepository = $statusRepository;
        $this->editProfileForm = $editProfileForm;
    }

	/**
	 * Display a listing of the resource.
	 * GET /users
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = $this->userRepository->getPaginated();

        return View::make('users.index')->withUsers($users);
	}

    /**
     * Show the user's profile.
     *
     * @param $username
     * @return mixed
     */
    public function show($username)
    {
        $user = $this->userRepository->findByUsername($username);
        $statuses = $this->statusRepository->getAllForUser($user);

        return View::make('users.show')
            ->withUser($user)
            ->with('statuses',  $statuses);
    }

    /**
     * Show the form to edit user's profile.
     *
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $user = $this->userRepository->findById($id);

        return View::make('users.edit')->withUser($user);
    }

    /**
     * Update the user's profile.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Laracasts\Validation\FormValidationException
     */
    public function update($id)
    {
        $input = $this->userRepository->checkUpdateProfileInput($id);

        // Fetch the input and add the user id to it
        $input = array_add($input, 'userIdToUpdate', $id);

        // Validate the input
        $this->editProfileForm->validate($input);

        // Execute a command to update the user's profile
        $this->execute(EditProfileCommand::class, $input);

        // Show a flash message and redirect back
        Flash::message('Your profile has been updated!');
        return Redirect::back();
    }
}