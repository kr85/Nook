<?php namespace Nook\Statuses;

use Eloquent;

/**
 * Class Like
 *
 * @package Nook\Statuses
 */
class Like extends Eloquent
{

    /**
     * Database table name.
     *
     * @var string
     */
    protected  $table = 'status_user_likes';

    /**
     * Attributes that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'status_id'];

    /**
     * Like belongs to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo('Nook\Users\User', 'user_id');
    }

    /**
     * Like belongs to a status.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo('Nook\Statuses\Status', 'status_id');
    }

    /**
     * Like a status.
     *
     * @param $userId
     * @param $statusId
     * @return static
     */
    public static function like($userId, $statusId)
    {
        return new static([
            'user_id' => $userId,
            'status_id' => $statusId
        ]);
    }
}