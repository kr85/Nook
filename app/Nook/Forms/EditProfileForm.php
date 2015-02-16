<?php namespace Nook\Forms;

use Laracasts\Validation\FormValidator;

/**
 * Class EditProfileForm
 *
 * @package Nook\Forms
 */
class EditProfileForm extends FormValidator
{
    /**
     * Validation rules for the edit profile form.
     *
     * @var array
     */
    protected $rules = [
        'username' => 'unique:users',
        'email'    => 'email|unique:users',
        'password' => 'confirmed'
    ];
}