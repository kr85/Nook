<?php

/**
 * Class PagesController
 */
class PagesController extends BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->beforeFilter('guest', ['except' => '']);
    }

    /**
     * Display home page.
     *
     * @return \Illuminate\View\View
     */
    public function home()
    {
        if (Auth::check())
        {
            return Redirect::to('statuses_route');
        }

        return View::make('pages.home.home');
    }
}
