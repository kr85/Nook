<?php namespace Nook\Statuses;

/**
 * Class LikeStatusCommand
 *
 * @package Nook\Statuses
 */
class LikeStatusCommand
{
    /**
     * @var $status_id
     */
    public $status_id;

    /**
     * @var $user_id
     */
    public $user_id;

    /**
     * Constructor.
     *
     * @param $status_id
     * @param $user_id
     */
    public function __construct($status_id, $user_id)
    {
        $this->status_id = $status_id;
        $this->user_id = $user_id;
    }
}