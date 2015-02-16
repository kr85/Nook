<?php namespace Nook\Users;

/**
 * Class UnfollowUserCommand
 *
 * @package Nook\Users
 */
class UnfollowUserCommand
{
    /**
     * @var $userId
     */
    public $userId;

    /**
     * @var $userIdToUnfollow
     */
    public $userIdToUnfollow;

    /**
     * Constructor.
     *
     * @param $userId
     * @param $userIdToUnfollow
     */
    public function __construct($userId, $userIdToUnfollow)
    {
        $this->userId = $userId;
        $this->userIdToUnfollow = $userIdToUnfollow;
    }
}