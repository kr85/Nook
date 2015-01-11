<?php

use Nook\Users\UserRepository;

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
     * Constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
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

        return View::make('users.show')->withUser($user);
    }

    /**
     * Edit user's profile.
     *
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $user = $this->userRepository->findById($id);

        return View::make('users.edit')->withUser($user);
    }
}