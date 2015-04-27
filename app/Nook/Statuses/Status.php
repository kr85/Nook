<?php namespace Nook\Statuses;

use Eloquent;
use Laracasts\Presenter\PresentableTrait;
use Nook\Statuses\Events\StatusWasPublished;
use Laracasts\Commander\Events\EventGenerator;

/**
 * Class Status
 *
 * @package Nook\Statuses
 */
class Status extends Eloquent
{
    use EventGenerator, PresentableTrait;

    /**
     * Fillable fields for a new status.
     *
     * @var array
     */
    protected $fillable = ['body', 'image'];

    /**
     * Path to the presenter for a status.
     *
     * @var string
     */
    protected $presenter = 'Nook\Statuses\StatusPresenter';

    /**
     * A status belongs to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Nook\Users\User');
    }

    /**
     * Publish a new status.
     *
     * @param $body
     * @param $image
     * @return static
     */
    public static function publish($body, $image)
    {
        $status = new static(compact('body', 'image'));

        $status->raise(new StatusWasPublished($status));

        return $status;
    }

    /**
     * Status has many comments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('Nook\Statuses\Comment');
    }

    /**
     * Status has many likes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes()
    {
        return $this->hasMany('Nook\Statuses\Like');
    }
}