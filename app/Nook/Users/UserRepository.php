<?php  namespace Nook\Users;

/**
 * Class UserRepository
 *
 * @package Nook\Users
 */
class UserRepository 
{
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
     * Get a paginated list of all users.
     *
     * @param int $howMany
     * @return \Illuminate\Pagination\Paginator
     */
    public function getPaginated($howMany = 25)
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