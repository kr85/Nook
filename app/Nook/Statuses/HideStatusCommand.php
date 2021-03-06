<?php namespace Nook\Statuses;

/**
 * Class HideStatusCommand
 *
 * @package Nook\Statuses
 */
class HideStatusCommand
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
     * @param $user_id
     * @param $status_id
     */
    public function __construct($user_id, $status_id)
    {
        $this->user_id = $user_id;
        $this->status_id = $status_id;
    }
}