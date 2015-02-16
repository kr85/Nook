<?php namespace Nook\Statuses;

use Laracasts\Presenter\Presenter;

/**
 * Class CommentPresenter
 *
 * @package Nook\Statuses
 */
class CommentPresenter extends Presenter
{
    /**
     * Display how long it has been since the comment was published.
     *
     * @return mixed
     */
    public function timeSinceCommentPublished()
    {
        return $this->created_at->diffForHumans();
    }
}