<?php namespace Nook\Registration\Events;

use Nook\Users\User;

/**
 * Class UserRegistered
 *
 * @package Nook\Registration\Events
 */
class UserRegistered 
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