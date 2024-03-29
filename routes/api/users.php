<?php

Route::middleware('permission:superadmin|read_users')->group(function() {

	Route::get('users', 'UsersController@index')->name('users.index');
	
	Route::get('users/search', 'UsersController@search')->name('users.search');
	
	Route::get('users/{user}', '\Nuclear\Reactor\Http\Controllers\UsersController@showExtended')->name('users.show');

	Route::get('users/{user}/chronicle', 'UsersController@chronicle')->name('users.chronicle')->middleware('permission:superadmin|read_chronicle');
});

Route::middleware('permission:superadmin|write_users')->group(function() {

	Route::post('users', 'UsersController@store')->name('users.store');

	// We have an override/extension here
	Route::put('users/{user}', '\Nuclear\Reactor\Http\Controllers\UsersController@updateWithExtensions')->name('users.update');
	
	Route::put('users/password/{user}', 'UsersController@password')->name('users.password');
	
	Route::delete('users/bulk', 'UsersController@destroyBulk')->name('users.destroy.bulk');
	Route::delete('users/{user}', 'UsersController@destroy')->name('users.destroy');

});