<?php namespace Nook\Forms;

use Laracasts\Validation\FormValidator;

/**
 * Class LeaveCommentForm
 *
 * @package Nook\Forms
 */
class LeaveCommentForm extends FormValidator
{
    /**
     * Validation rules for the leave comment form.
     *
     * @var array
     */
    protected $rules = [
        'body' => 'required',
        'user_id' => 'required',
        'status_id' => 'required'
    ];
}