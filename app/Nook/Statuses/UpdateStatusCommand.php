<?php namespace Nook\Statuses;

/**
 * Class UpdateStatusCommand
 *
 * @package Nook\Statuses
 */
class UpdateStatusCommand
{
    /**
     * @var $body
     */
    public $body;

    /**
     * @var $statusId
     */
    public $statusId;

    /**
     * Constructor.
     *
     * @param $body
     * @param $statusId
     */
    function __construct($body, $statusId)
    {
        $this->body = $body;
        $this->statusId = $statusId;
    }
}