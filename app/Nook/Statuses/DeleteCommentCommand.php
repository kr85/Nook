<?php namespace Nook\Statuses;

/**
 * Class DeleteCommentCommand
 *
 * @package Nook\Statuses
 */
class DeleteCommentCommand
{
    /**
     * @var $comment_id
     */
    public $comment_id;

    /**
     * Constructor.
     *
     * @param string $comment_id
     */
    public function __construct($comment_id)
    {
        $this->comment_id = $comment_id;
    }
}