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
    protected $fillable = ['body'];

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
     * @return static
     */
    public static function publish($body)
    {
        $status = new static(compact('body'));

        $status->raise(new StatusWasPublished($body));

        return $status;
    }
}