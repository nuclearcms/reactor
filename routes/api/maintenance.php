<?php

Route::middleware('permission:superadmin|rw_environment')->group(function() {

	Route::get('environment', 'MaintenanceController@getEnvironment')->name('environment.get');
	Route::put('environment', 'MaintenanceController@putEnvironment')->name('environment.put');

});