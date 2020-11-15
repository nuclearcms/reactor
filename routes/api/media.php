<?php

Route::middleware('permission:superadmin|read_media')->group(function() {

	Route::get('media', 'MediaController@index')->name('media.index');
	
	Route::get('media/search', 'MediaController@search')->name('media.search');
	
	Route::get('media/{medium}', 'MediaController@show')->name('media.show');
});

Route::middleware('permission:superadmin|write_media')->group(function() {

	Route::post('media', 'MediaController@upload')->name('media.upload');
	Route::post('media/embed', 'MediaController@embed')->name('media.embed');

	Route::put('media/{medium}', 'MediaController@update')->name('media.update');

	Route::put('media/{medium}/image', 'MediaController@updateImage')->name('media.update.image');
	
	Route::delete('media/bulk', 'MediaController@destroyBulk')->name('media.destroy.bulk');
	Route::delete('media/{medium}', 'MediaController@destroy')->name('media.destroy');

});