<?php

Route::get('dashboard/chronicle', '\Nuclear\Reactor\Http\Controllers\DashboardController@chronicle')->name('dashboard.chronicle')->middleware('permission:read_chronicle');