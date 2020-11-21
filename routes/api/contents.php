<?php

Route::middleware('permission:superadmin|read_contents')->group(function() {

	Route::get('contents', 'ContentsController@index')->name('contents.index');
	
	Route::get('contents/roots', 'ContentsController@roots')->name('contents.roots');
	
	Route::get('contents/search', 'ContentsController@search')->name('contents.search');

	Route::get('contents/precreate/{parent?}', 'ContentsController@precreate')->name('contents.precreate');

	Route::get('contents/{content}', 'ContentsController@show')->name('contents.show');

});

Route::middleware('permission:superadmin|write_contents')->group(function() {

	Route::post('contents/{parent?}', 'ContentsController@store')->name('contents.store');

	Route::put('contents/{content}', 'ContentsController@update')->name('contents.update');
	Route::put('contents/{content}/settings', 'ContentsController@updateSettings')->name('contents.update.settings');
	Route::put('contents/{content}/state', 'ContentsController@updateState')->name('contents.update.state');
	
	Route::post('contents/{content}/translate', 'ContentsController@translate')->name('contents.translate');
	Route::delete('contents/{content}/translate/{locale}', 'ContentsController@destroyTranslation')->name('contents.translate.destroy');

	Route::delete('contents/bulk', 'ContentsController@destroyBulk')->name('contents.destroy.bulk');
	Route::delete('contents/{content}', 'ContentsController@destroy')->name('contents.destroy');
});