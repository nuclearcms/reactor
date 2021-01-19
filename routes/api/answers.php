<?php

Route::middleware('permission:superadmin|read_answers')->group(function() {

	Route::get('answers', 'AnswersController@index')->name('answers.index');

	Route::get('answers/search', 'AnswersController@search')->name('answers.search');

	Route::get('answers/{answer}', 'AnswersController@show')->name('answers.show');

});

Route::middleware('permission:superadmin|write_answers')->group(function() {

	Route::put('answers/{answer}', 'AnswersController@update')->name('answers.update');

	Route::delete('answers/bulk', 'AnswersController@destroyBulk')->name('answers.destroy.bulk');
	Route::delete('answers/{answer}', 'AnswersController@destroy')->name('answers.destroy');

});