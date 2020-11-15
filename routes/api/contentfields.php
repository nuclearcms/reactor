<?php

Route::middleware('permission:superadmin|read_contenttypes')->group(function() {

	Route::get('contenttypes/{content_type}/fields/{content_field}', 'ContentFieldsController@show')->name('contentfields.show');

});

Route::middleware('permission:superadmin|write_contenttypes')->group(function() {

	Route::post('contenttypes/{content_type}/fields', 'ContentFieldsController@store')->name('contentfields.store');

	Route::put('contenttypes/{content_type}/fields/{content_field}', 'ContentFieldsController@update')->name('contentfields.update');

	Route::delete('contenttypes/{content_type}/fields/{content_field}', 'ContentFieldsController@destroy')->name('contentfields.destroy');

});