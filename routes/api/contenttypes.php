<?php

Route::middleware('permission:superadmin|read_contenttypes')->group(function() {

	Route::get('contenttypes', 'ContentTypesController@index')->name('contenttypes.index');

	Route::get('contenttypes/search', 'ContentTypesController@search')->name('contenttypes.search');

	Route::get('contenttypes/{content_type}', 'ContentTypesController@show')->name('contenttypes.show');

	Route::get('contenttypes/{content_type}/fields', 'ContentTypesController@fields')->name('contenttypes.fields');

	Route::get('contenttypes/{content_type}/contents', 'ContentTypesController@contents')->name('contenttypes.contents');

});

Route::middleware('permission:superadmin|write_contenttypes')->group(function() {

	Route::post('contenttypes', 'ContentTypesController@store')->name('contenttypes.store');

	Route::put('contenttypes/{content_type}', 'ContentTypesController@update')->name('contenttypes.update');

	Route::put('contenttypes/{content_type}/fields/sort', 'ContentTypesController@sort')->name('contenttypes.sort');

	Route::delete('contenttypes/bulk', 'ContentTypesController@destroyBulk')->name('contenttypes.destroy.bulk');
	Route::delete('contenttypes/{content_type}', 'ContentTypesController@destroy')->name('contenttypes.destroy');

	Route::post('contenttypes/{content_type}/duplicate', 'ContentTypesController@duplicate')->name('contenttypes.duplicate');

});