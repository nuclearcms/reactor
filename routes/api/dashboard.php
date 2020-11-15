<?php

Route::get('dashboard/chronicle', 'DashboardController@chronicle')->name('dashboard.chronicle')->middleware('permission:read_chronicle');