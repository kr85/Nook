<?php namespace Nook\Statuses;

use DB;
use Auth;
use Exception;
use Nook\Users\User;
use Intervention\Image\Facades\Image;

/**
 * Class StatusRepository
 *
 * @package Nook\Statuses
 */
class StatusRepository
{

    /**
     * @var string Database table name for hidden statuses
     */
    protected $hiddenStatusesTable = 'hidden_statuses';

    /**
     * @var string Database table name for user status likes
     */
    protected $statusUserLikesTable = 'status_user_likes';

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
     * Get user liked statuses.
     *
     * @param $userId
     * @return array|static[]
     */
    public function getUserLikedStatuses($userId)
    {
        return DB::table($this->statusUserLikesTable)
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
    public function getFeedForUser(User $user, $howMany = 25)
    {
        // Get other users
        $userIds = $user->followedUsers()->lists('followed_id');
        // Append current user
        $userIds[] = $user->id;

        // Get all user's hidden statuses
        $hiddenStatuses = $this->getHiddenForUser($user->id);
        // Get the ids of the hidden statuses
        $hiddenStatusIds = $this->getHiddenStatusIds($hiddenStatuses);

        return Status::with('comments', 'likes')
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

        foreach ($hiddenStatuses as $hiddenStatus) {
            $hiddenStatusIds[] = $hiddenStatus->status_id;
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
     * Update an existing status.
     *
     * @param $statusId
     * @param $data
     * @return bool|int
     */
    public function update($statusId, $data)
    {
        return Status::findOrFail($statusId)->update($data);
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
     * Update a comment.
     *
     * @param $commentId
     * @param $data
     * @return bool|int
     */
    public function updateComment($commentId, $data)
    {
        return Comment::findOrFail($commentId)->update($data);
    }

    /**
     * Like a status.
     *
     * @param $userId
     * @param $statusId
     * @return static
     */
    public function likeStatus($userId, $statusId)
    {
        $like = Like::like($userId, $statusId);

        User::findOrFail($userId)->likes()->save($like);

        return $like;
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
     * Fetch a status like.
     *
     * @param $userId
     * @param $statusId
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function statusLiked($userId, $statusId)
    {
        return Like::where('user_id', '=', $userId, 'and')
            ->where('status_id', '=', $statusId)
            ->first();
    }

    /**
     * Fetch a comment by comment id.
     *
     * @param $id
     * @return \Illuminate\Support\Collection|static
     */
    public function findCommentById($id)
    {
        return Comment::findOrFail($id);
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
     * Delete a comment.
     *
     * @param $id
     * @return int
     */
    public function deleteComment($id)
    {
        return Comment::destroy($id);
    }

    /**
     * Unlike status.
     *
     * @param $id
     * @return int
     */
    public function unlikeStatus($id)
    {
        return Like::destroy($id);
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