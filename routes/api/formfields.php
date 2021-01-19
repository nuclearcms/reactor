<?php

Route::middleware('permission:superadmin|read_forms')->group(function() {

	Route::get('forms/{form}/fields/{form_field}', 'FormFieldsController@show')->name('formfields.show');

});

Route::middleware('permission:superadmin|write_forms')->group(function() {

	Route::post('forms/{form}/fields', 'FormFieldsController@store')->name('formfields.store');

	Route::put('forms/{form}/fields/{form_field}', 'FormFieldsController@update')->name('formfields.update');

	Route::delete('forms/{form}/fields/{form_field}', 'FormFieldsController@destroy')->name('formfields.destroy');

});