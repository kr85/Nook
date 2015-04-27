<?php namespace Nook\Statuses;

/**
 * Class UpdateCommentCommand
 *
 * @package Nook\Statuses
 */
class UpdateCommentCommand
{
    /**
     * @var $body
     */
    public $body;

    /**
     * @var $status_id
     */
    public $comment_id;

    /**
     * Constructor.
     *
     * @param $body
     * @param $comment_id
     */
    function __construct($body, $comment_id)
    {
        $this->body = $body;
        $this->comment_id = $comment_id;
    }
}