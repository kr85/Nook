<?php namespace Nook\Users;

use Hash;
use Eloquent;
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Laracasts\Presenter\PresentableTrait;
use Nook\Registration\Events\UserRegistered;
use Laracasts\Commander\Events\EventGenerator;

/**
 * Class User
 *
 * @package Nook\Users
 */
class User extends Eloquent implements UserInterface, RemindableInterface
{

    use UserTrait, RemindableTrait, EventGenerator, PresentableTrait;

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
     * Path to the presenter for a user.
     *
     * @var string
     */
    protected $presenter = 'Nook\Users\UserPresenter';

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
     * A user has many statuses.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function statuses()
    {
        return $this->hasMany('Nook\Statuses\Status');
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

        // Raise an event
        $user->raise(new UserRegistered($user));

        return $user;
    }

    /**
     * Determine if the given user is the same as the current user.
     *
     * @param $user
     * @return bool
     */
    public function is($user)
    {
        if (is_null($user))
        {
            return false;
        }

        return $this->username == $user->username;
    }
}
