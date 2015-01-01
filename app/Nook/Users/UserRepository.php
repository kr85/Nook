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
}