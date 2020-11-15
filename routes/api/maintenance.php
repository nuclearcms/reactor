<?php

Route::middleware('permission:superadmin|rw_environment')->group(function() {

	Route::get('environment', 'MaintenanceController@getEnvironment')->name('environment.get');
	Route::put('environment', 'MaintenanceController@putEnvironment')->name('environment.put');

});

Route::middleware('permission:superadmin|rw_logs')->group(function() {

	Route::get('logs', 'MaintenanceController@getLogs')->name('logs.get');
	Route::delete('logs', 'MaintenanceController@clearLogs')->name('logs.clear');

});