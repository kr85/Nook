<?php namespace Nook\Forms;

use Laracasts\Validation\FormValidator;

/**
 * Class PublishStatusForm
 *
 * @package Nook\Forms
 */
class PublishStatusForm extends FormValidator
{
    /**
     * Validation rules for the status form.
     *
     * @var array
     */
    protected $rules = [
        'body' => 'required'
    ];
}