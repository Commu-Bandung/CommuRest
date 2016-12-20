<?php

use Illuminate\Http\Request;

Route::get('admin','AdminController@showAll');
Route::post('add/admin','AdminController@store');
Route::get('admin/profile/{id}','AdminController@showById');
Route::put('admin/update/{id}','AdminController@updateAdmin');
Route::delete('admin/delete/{id}','AdminController@deleteAdmin');

Route::get('perusahaan','PerusahaanController@showAll');
Route::get('perusahaan/profile/{id}','PerusahaanController@profileId');
Route::post('perusahaan/add','PerusahaanController@add');
Route::put('perusahaan/update/{id}','PerusahaanController@updatePerusahaan');
Route::delete('perusahaan/del/{id}','PerusahaanCOntroller@deletePerusahaan');

Route::post('anggota/add','AnggotaController@addAnggota');
Route::put('anggota/update/{id}','AnggotaController@updateAnggota');
Route::delete('anggota/del/{id}','AnggotaController@deleteAnggota');
Route::get('anggota','AnggotaController@showAll');
Route::get('anggota/profile/{id}','AnggotaController@profileId');
