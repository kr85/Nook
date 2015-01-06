<?php

/**
 * Class PagesController
 */
class PagesController extends \BaseController
{
    /**
     * Display home page.
     *
     * @return \Illuminate\View\View
     */
    public function home()
    {
        return View::make('pages.home');
    }
}
