<?php

Route::middleware('permission:superadmin|rw_permissions')->group(function() {

	Route::get('roles', 'RolesController@index')->name('roles.index');
	
	Route::get('roles/search', 'RolesController@search')->name('roles.search');
	
	Route::post('roles', 'RolesController@store')->name('roles.store');
	
	Route::get('roles/{role}', 'RolesController@show')->name('roles.show');
	Route::put('roles/{role}', 'RolesController@update')->name('roles.update');

	Route::get('roles/{role}/users', 'RolesController@users')->name('roles.users');
	Route::delete('roles/{role}/users/{user}', 'RolesController@revoke')->name('roles.users.revoke');
	
	Route::delete('roles/bulk', 'RolesController@destroyBulk')->name('roles.destroy.bulk');
	Route::delete('roles/{role}', 'RolesController@destroy')->name('roles.destroy');
	
});
