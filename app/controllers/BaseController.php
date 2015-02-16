<?php

use Laracasts\Commander\CommanderTrait;

/**
 * Class BaseController
 */
class BaseController extends Controller
{
    use CommanderTrait;

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if (!is_null($this->layout))
        {
            $this->layout = View::make($this->layout);
        }

        // Share current user
        View::share('currentUser', Auth::user());
        View::share('signedIn', Auth::user());
    }
}
