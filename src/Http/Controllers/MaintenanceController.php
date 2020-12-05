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

	/**
	 * Runs an artisan command
	 *
	 * @param string $command
	 * @return json
	 */
	public function runCommand($command)
	{
		if(!in_array($command, ['down', 'optimize', 'route_cache', 'config_cache', 'view_cache', 'package_discover', 'route_clear', 'cache_clear', 'config_clear', 'view_clear', 'optimize_clear', 'clear-compiled', 'activitylog_clean', 'permission_cache-reset', 'key_generate', 'sitemap_generate'])) {
			return [
				'success' => false,
				'message' => __('reactor::general.maintenance_command_not_found')
			];
		}

		if($command == 'key_generate') {
			\Artisan::call(str_replace('_', ':', $command));
			\Artisan::call('config:cache');
		} elseif($command == 'activitylog_clean') {
			\Artisan::call('activitylog:clean', ['--days' => 0]);
		} else {
			\Artisan::call(str_replace('_', ':', $command));
		}

		return [
			'success' => true,
			'message' => __('reactor::general.maintenance_command_run_successfully')
		];
	}

}
