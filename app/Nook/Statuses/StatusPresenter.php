<?php namespace Nook\Statuses;

use Laracasts\Presenter\Presenter;

/**
 * Class StatusPresenter
 *
 * @package Nook\Statuses
 */
class StatusPresenter extends Presenter
{
    /**
     * Display how long it has been since the status was published.
     *
     * @return mixed
     */
    public function timeSincePublished()
    {
        return $this->created_at->diffForHumans();
    }
}