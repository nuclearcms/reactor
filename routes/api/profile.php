<?php

Route::get('profile/info', 'ProfileController@info')->name('profile.info');

Route::get('profile', 'ProfileController@get')->name('profile.get');
Route::put('profile', 'ProfileController@put')->name('profile.put');

Route::get('profile/chronicle', 'ProfileController@chronicle')->name('profile.chronicle')->middleware('permission:superadmin|read_chronicle');

Route::post('profile/password', 'ProfileController@password')->name('profile.password');
