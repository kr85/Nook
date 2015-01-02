<?php namespace Nook\Forms;

use Laracasts\Validation\FormValidator;

/**
 * Class SignInForm
 *
 * @package Nook\Forms
 */
class SignInForm extends FormValidator
{
   /**
    * Validation rules for the sign in form.
    *
    * @var array
    */
   protected $rules = [
      'email'    => 'required',
      'password' => 'required'
   ];
}