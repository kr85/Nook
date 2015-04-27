<?php namespace Nook\Statuses;

/**
 * Class DeleteStatusCommand
 *
 * @package Nook\Statuses
 */
class DeleteStatusCommand
{
    /**
     * @var $status_id
     */
    public $status_id;

    /**
     * Constructor.
     *
     * @param string $status_id
     */
    public function __construct($status_id)
    {
        $this->status_id = $status_id;
    }
}