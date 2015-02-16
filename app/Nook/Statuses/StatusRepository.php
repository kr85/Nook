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
     * @param int $howMany
     * @return mixed
     */
    public function getAllForUser(User $user, $howMany = 10)
    {
        return $user->statuses()->with('user')->latest()->simplePaginate($howMany);
    }

    /**
     * Get the feed for a user.
     *
     * @param User $user
     * @param int $howMany
     * @return mixed
     */
    public function getFeedForUser(User $user, $howMany = 10)
    {
        // Get other users
        $userIds = $user->followedUsers()->lists('followed_id');
        // Append current user
        $userIds[] = $user->id;

        return Status::with('comments')
            ->whereIn('user_id', $userIds)
            ->latest()
            ->simplePaginate($howMany);
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

    /**
     * Leave comment to a status.
     *
     * @param $userId
     * @param $statusId
     * @param $body
     * @return static
     */
    public function leaveComment($userId, $statusId, $body)
    {
        $comment = Comment::leave($body, $statusId);

        User::findOrFail($userId)->comments()->save($comment);

        return $comment;
    }

    /**
     * Fetch a status by status id.
     *
     * @param $id
     * @return \Illuminate\Support\Collection|static
     */
    public function findById($id)
    {
        return Status::findOrFail($id);
    }

    /**
     * Delete a status.
     *
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return Status::destroy($id);
    }
}