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

	/**
	 * Retrieves the contents of the log file
	 *
	 * @return text
	 */
	public function getLogs()
	{
		return file_get_contents(storage_path('logs/laravel.log'));
	}

	/**
	 * Saves the contents of the environment file
	 *
	 * @return json
	 */
	public function clearLogs()
	{
		file_put_contents(storage_path('logs/laravel.log'), '');

		return [
			'message' => __('reactor::general.cleared_logs'),
			'log' => ''
		];
	}

}
