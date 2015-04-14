<?php namespace Nook\Statuses;

use DB;
use Nook\Users\User;

/**
 * Class StatusRepository
 *
 * @package Nook\Statuses
 */
class StatusRepository
{

    protected $hiddenStatusesTable = 'hidden_statuses';

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
     * Get all hidden statuses for a user.
     *
     * @param $userId
     * @return mixed
     */
    public function getHiddenForUser($userId)
    {
        return DB::table($this->hiddenStatusesTable)
            ->select('status_id')
            ->where('user_id', '=', $userId)
            ->get();
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

        // Get all user's hidden statuses
        $hiddenStatuses = $this->getHiddenForUser($user->id);
        // Get the ids of the hidden statuses
        $hiddenStatusIds = $this->getHiddenStatusIds($hiddenStatuses);

        return Status::with('comments')
            ->whereIn('user_id', $userIds)
            ->whereNotIn('id', $hiddenStatusIds)
            ->latest()
            ->simplePaginate($howMany);
    }

    /**
     * Get hidden statuses' ids
     *
     * @param $hiddenStatuses
     * @return array
     */
    private function getHiddenStatusIds($hiddenStatuses)
    {
        $hiddenStatusIds = [];

        foreach ($hiddenStatuses as $hs) {
            $hiddenStatusIds[] = $hs->status_id;
        }

        return $hiddenStatusIds;
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

    /**
     * Hide a status from a user.
     *
     * @param $userId
     * @param $statusId
     * @return static
     */
    public function hide($userId, $statusId)
    {
        $status = HiddenStatuses::hide($userId, $statusId);

        User::findOrFail($userId)->hiddenStatuses()->save($status);

        return $status;
    }
}