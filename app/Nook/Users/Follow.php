<?php namespace Nook\Users;

use Eloquent;

/**
 * Class Follow
 *
 * @package Nook\Users
 */
class Follow extends Eloquent
{
    /**
     * Fields for mass assignment.
     *
     * @var array
     */
    protected $fillable = ['follower_id', 'followed_id'];

    /**
     * Database name.
     *
     * @var string
     */
    protected $table = 'follows';
}