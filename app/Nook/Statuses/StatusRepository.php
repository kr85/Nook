<?php namespace Nook\Statuses;

use Nook\Users\User;

/**
 * Class StatusRepository
 *
 * @package Nook\Statuses
 */
class StatusRepository
{
    /**
     * Get all statuses for a user.
     *
     * @param User $user
     * @return mixed
     */
    public function getAllForUser(User $user)
    {
        return $user->statuses()->with('user')->latest()->get();
    }

    /**
     * Get the feed for a user.
     *
     * @param User $user
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getFeedForUser(User $user)
    {
        // Get other users
        $userIds = $user->followedUsers()->lists('followed_id');
        // Append current user
        $userIds[] = $user->id;

        return Status::whereIn('user_id', $userIds)->latest()->get();
    }

    /**
     * Save a new status.
     *
     * @param Status $status
     * @param $userId
     * @return mixed
     */
    public function save(Status $status, $userId)
    {
        return User::findOrFail($userId)->statuses()->save($status);
    }
}