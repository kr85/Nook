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
        return User::simplePaginate($howMany);
    }
}