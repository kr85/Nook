<?php namespace Nook\Registration\Events;

use Nook\Users\User;

/**
 * Class UserHasRegistered
 *
 * @package Nook\Registration\Events
 */
class UserHasRegistered
{
    /**
     * @var User
     */
    public $user;

    /**
     * Constructor
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}