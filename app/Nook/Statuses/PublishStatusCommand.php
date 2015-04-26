<?php namespace Nook\Statuses;

/**
 * Class PublishStatusCommand
 *
 * @package Nook\Statuses
 */
class PublishStatusCommand
{
    /**
     * @var $body
     */
    public $body;

    /**
     * @var $user_id
     */
    public $user_id;

    /**
     * @var $image
     */
    public $image;

    /**
     * Constructor.
     *
     * @param $body
     * @param $user_id
     * @param $image
     */
    function __construct($body, $user_id, $image)
    {
        $this->body = $body;
        $this->user_id = $user_id;
        $this->image = $image;
    }
}