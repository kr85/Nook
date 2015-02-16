<?php namespace Nook\Statuses;

use Eloquent;
use Laracasts\Presenter\PresentableTrait;

/**
 * Class Comment
 *
 * @package Nook\Statuses
 */
class Comment extends Eloquent
{
    use PresentableTrait;

    /**
     * Attributes that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'status_id', 'body'];

    /**
     * Path to the presenter to a comment.
     *
     * @var string
     */
    protected $presenter = 'Nook\Statuses\CommentPresenter';

    /**
     * Comment belongs to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo('Nook\Users\User', 'user_id');
    }

    /**
     * Leave a new comment.
     *
     * @param $body
     * @param $statusId
     * @return static
     */
    public static function leave($body, $statusId)
    {
        return new static([
            'body' => $body,
            'status_id' => $statusId
        ]);
    }
}