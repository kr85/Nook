<?php namespace Nook\Users;

use Input;

/**
 * Class UserRepository
 *
 * @package Nook\Users
 */
class UserRepository 
{

    /**
     * Find by email or create a new user.
     *
     * @param $user
     * @param $userDetails
     * @return mixed
     */
    public function findByEmailOrCreate($user, $userDetails)
    {
        $currUser = $this->findByEmail($userDetails->email);

        if (!isset($currUser))
        {
            $user['email'] = $userDetails->email;
            $user['username'] = $userDetails->firstName.'.'.$userDetails->lastName;
            $user->save();
        }

        return $currUser;
    }

    /**
     * Persist the user.
     *
     * @param User $user
     * @return bool
     */
    public function save(User $user)
    {
        return $user->save();
    }

    /**
     * Get all users.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getUsers()
    {
        return User::orderBy('username', 'asc')->get();
    }

    /**
     * Get a paginated list of all users.
     *
     * @param int $howMany
     * @return \Illuminate\Pagination\Paginator
     */
    public function getPaginated($howMany = 24)
    {
        return User::orderBy('username', 'asc')->simplePaginate($howMany);
    }

    /**
     * Fetch a user by username.
     *
     * @param $username
     * @return mixed
     */
    public function findByUsername($username)
    {
        return User::with('statuses')->whereUsername($username)->first();
    }

    /**
     * Find user by email.
     *
     * @param $email
     * @return mixed
     */
    public function findByEmail($email)
    {
        return User::with('statuses')->whereEmail($email)->first();
    }

    /**
     * Fetch a user by user id.
     *
     * @param $id
     * @return \Illuminate\Support\Collection|static
     */
    public function findById($id)
    {
        return User::findOrFail($id);
    }

    /**
     * Update user's profile.
     *
     * @param array $input
     * @return \Illuminate\Support\Collection|UserRepository|static
     */
    public function updateProfile(array $input)
    {
        $user = $this->findById($input['userIdToUpdate']);

        if (!empty($input['username']))
        {
            $user['username'] = $input['username'];
        }

        if (!empty($input['email']))
        {
            $user['email'] = $input['email'];
        }

        if (!empty($input['password']))
        {
            $user['password'] = $input['password'];
        }

        $this->save($user);

        return $user;
    }

    /**
     * Check if the form input is the same as one saved in the storage.
     *
     * @param $id
     * @return array
     */
    public function checkUpdateProfileInput($id)
    {
        $user = $this->findById($id);
        $input = [];

        if (strcasecmp($user['username'], Input::get('username')))
        {
            $input['username'] = Input::get('username');
        }
        else
        {
            $input['username'] = '';
        }

        if (strcasecmp($user['email'], Input::get('email')))
        {
            $input['email'] = Input::get('email');
        }
        else
        {
            $input['email'] = '';
        }

        $input['password'] = Input::get('password');
        $input['password_confirmation'] = Input::get('password_confirmation');

        return $input;
    }

    /**
     * Follow a Nook user.
     *
     * @param $userIdToFollow
     * @param User $user
     * @return mixed
     */
    public function follow($userIdToFollow, User $user)
    {
        return $user->followedUsers()->attach($userIdToFollow);
    }

    /**
     * Unfollow a Nook user.
     *
     * @param $userIdToUnfollow
     * @param User $user
     * @return int
     */
    public function unfollow($userIdToUnfollow, User $user)
    {
        return $user->followedUsers()->detach($userIdToUnfollow);
    }
}