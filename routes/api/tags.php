<?php

Route::middleware('permission:superadmin|read_tags')->group(function() {

	Route::get('tags', 'TagsController@index')->name('tags.index');
	
	Route::get('tags/search', 'TagsController@search')->name('tags.search');
	
	Route::get('tags/{tag}', 'TagsController@show')->name('tags.show');
});

Route::middleware('permission:superadmin|write_tags')->group(function() {

	Route::post('tags', 'TagsController@store')->name('tags.store');

	Route::put('tags/{tag}', 'TagsController@update')->name('tags.update');
	
	Route::post('tags/{tag}/translate', 'TagsController@translate')->name('tags.translate');
	Route::delete('tags/{tag}/translate/{locale}', 'TagsController@destroyTranslation')->name('tags.translate.destroy');
	
	Route::delete('tags/bulk', 'TagsController@destroyBulk')->name('tags.destroy.bulk');
	Route::delete('tags/{tag}', 'TagsController@destroy')->name('tags.destroy');

});