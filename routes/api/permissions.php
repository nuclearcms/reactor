<?php

Route::middleware('permission:superadmin|access_reactor')->group(function() {

	Route::get('permissions/user', 'PermissionsController@user')->name('permissions.user');

});

Route::middleware('permission:superadmin|rw_permissions')->group(function() {

	Route::get('permissions', 'PermissionsController@index')->name('permissions.index');
	
	Route::get('permissions/search', 'PermissionsController@search')->name('permissions.search');
	
	Route::post('permissions', 'PermissionsController@store')->name('permissions.store');
	
	Route::get('permissions/{permission}', 'PermissionsController@show')->name('permissions.show');
	Route::put('permissions/{permission}', 'PermissionsController@update')->name('permissions.update');

	Route::get('permissions/{permission}/users', 'PermissionsController@users')->name('permissions.users');
	Route::delete('permissions/{permission}/users/{user}', 'PermissionsController@revoke')->name('permissions.users.revoke');
	
	Route::delete('permissions/bulk', 'PermissionsController@destroyBulk')->name('permissions.destroy.bulk');
	Route::delete('permissions/{permission}', 'PermissionsController@destroy')->name('permissions.destroy');
	
});
