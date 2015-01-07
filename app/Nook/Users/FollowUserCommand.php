<?php namespace Nook\Users;

/**
 * Class FollowUserCommand
 *
 * @package Nook\Users
 */
class FollowUserCommand 
{
    /**
     * @var $userId
     */
    public $userId;

    /**
     * @var $userIdToFollow
     */
    public $userIdToFollow;

    /**
     * Constructor.
     *
     * @param $userIdToFollow
     * @param $userId
     */
    function __construct($userIdToFollow, $userId)
    {
        $this->userIdToFollow = $userIdToFollow;
        $this->userId = $userId;
    }
}