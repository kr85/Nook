<?php namespace Nook\Statuses;

/**
 * Class DeleteCommentCommand
 *
 * @package Nook\Statuses
 */
class DeleteCommentCommand
{
    /**
     * @var string
     */
    public $comment_id;

    /**
     * @param string $comment_id
     */
    public function __construct($comment_id)
    {
        $this->comment_id = $comment_id;
    }
}