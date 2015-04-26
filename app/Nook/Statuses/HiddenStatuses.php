<?php namespace Nook\Statuses;

use Eloquent;

/**
 * Class HiddenStatuses
 *
 * @package Nook\Statuses
 */
class HiddenStatuses extends Eloquent
{

    /**
     * @var string Database table name
     */
    protected $table = 'hidden_statuses';

    /**
     * @var array Fields that can be mass assigned
     */
    protected $fillable = ['user_id', 'status_id'];

    /**
     * A hidden status can belong to many users.
     *
     * @return $this
     */
    public function users()
    {
        return $this->belongsToMany('Nook\Users\User', 'hidden_statuses')
            ->withPivot('user_id', 'status_id');
    }

    /**
     * Hide a status.
     *
     * @param $userId
     * @param $statusId
     * @return static
     */
    public static function hide($userId, $statusId)
    {
        return new static([
            'user_id' => $userId,
            'status_id' => $statusId
        ]);
    }
}