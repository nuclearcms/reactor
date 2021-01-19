<?php

Route::middleware('permission:superadmin|read_forms')->group(function() {

	Route::get('forms', 'FormsController@index')->name('forms.index');

	Route::get('forms/search', 'FormsController@search')->name('forms.search');

	Route::get('forms/{form}', 'FormsController@show')->name('forms.show');

	Route::get('forms/{form}/fields', 'FormsController@fields')->name('forms.fields');

});

Route::middleware('permission:superadmin|write_forms')->group(function() {

	Route::post('forms', 'FormsController@store')->name('forms.store');

	Route::put('forms/{form}', 'FormsController@update')->name('forms.update');

	Route::put('forms/{form}/fields/sort', 'FormsController@sort')->name('forms.sort');

	Route::delete('forms/bulk', 'FormsController@destroyBulk')->name('forms.destroy.bulk');
	Route::delete('forms/{form}', 'FormsController@destroy')->name('forms.destroy');

	Route::post('forms/{form}/duplicate', 'FormsController@duplicate')->name('forms.duplicate');

});