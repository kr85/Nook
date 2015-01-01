<?php namespace Nook\Users;

use Hash;
use Eloquent;
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

/**
 * Class User
 *
 * @package Nook\Users
 */
class User extends Eloquent implements UserInterface, RemindableInterface
{

	use UserTrait, RemindableTrait;

   /**
    * The fields that can be mass assigned.
    *
    * @var array
    */
   protected $fillable = ['username', 'email', 'password'];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

   /**
    * Hash the user password.
    *
    * @param $password
    */
   public function setPasswordAttribute($password)
   {
      $this->attributes['password'] = Hash::make($password);
   }

   /**
    * Register a new user.
    *
    * @param $username
    * @param $email
    * @param $password
    * @return static
    */
   public static function register($username, $email, $password)
   {
      $user = new static(compact('username', 'email', 'password'));

      // raise an event

      return $user;
   }
}