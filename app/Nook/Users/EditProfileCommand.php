<?php namespace Nook\Users;

/**
 * Class EditProfileCommand
 *
 * @package Nook\Users
 */
class EditProfileCommand
{
    /**
     * @var $userIdToUpdate
     */
    public $userIdToUpdate;

    /**
     * @var $username
     */
    public $username;

    /**
     * @var $email
     */
    public $email;

    /**
     * @var $password
     */
    public $password;

    /**
     * Constructor.
     *
     * @param userIdToUpdate
     * @param username
     * @param email
     * @param password
     */
    public function __construct($userIdToUpdate, $username, $email, $password)
    {
        $this->userIdToUpdate = $userIdToUpdate;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

}