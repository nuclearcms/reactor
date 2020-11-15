<?php

namespace Nuclear\Reactor\Http\Controllers;

use Umomega\Foundation\Http\Controllers\Controller;

class ReactorController extends Controller
{

    /**
     * Shows the dashboard
     *
     * @return View
     */
    public function index()
    {
    	return view('reactor::app');
    }

}
