<?php

use Illuminate\Http\Request;

Route::get('admin','AdminController@showAll');
Route::post('add/admin','AdminController@store');
Route::get('admin/profile/{id}','AdminController@showById');
Route::put('admin/update/{id}','AdminController@updateAdmin');
Route::delete('admin/delete/{id}','AdminController@deleteAdmin');