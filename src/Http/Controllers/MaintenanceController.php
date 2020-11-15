<?php

namespace Nuclear\Reactor\Http\Controllers;

use Umomega\Foundation\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{

    /**
	 * Retrieves the contents of the environment file
	 *
	 * @return text
	 */
	public function getEnvironment()
	{
		return file_get_contents(base_path('.env'));
	}

	/**
	 * Saves the contents of the environment file
	 *
	 * @param Request $request
	 * @return json
	 */
	public function putEnvironment(Request $request)
	{
		file_put_contents(base_path('.env'), $request->get('code'));

		return ['message' => __('foundation::general.saved_changes')];
	}

}
