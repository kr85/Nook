<?php namespace Nook\Statuses;

/**
 * Class LeaveCommentOnStatusCommand
 *
 * @package Nook\Statuses
 */
class LeaveCommentOnStatusCommand
{
    /**
     * @var $user_id
     */
    public $user_id;

    /**
     * @var $status_id
     */
    public $status_id;

    /**
     * @var $body
     */
    public $body;

    /**
     * Constructor.
     *
     * @param user_id
     * @param status_id
     * @param body
     */
    public function __construct($user_id, $status_id, $body)
    {
        $this->user_id = $user_id;
        $this->status_id = $status_id;
        $this->body = $body;
    }
}