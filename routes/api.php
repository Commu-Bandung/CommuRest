<?php

use Illuminate\Http\Request;

Route::get('admin','AdminController@showAll');
Route::post('admin/add','AdminController@store');
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

Route::post('auth/register','RegistrasiController@register');

Route::post('auth/login','LoginController');

Route::post('anggota/ajukan','ProposalController@ajukan');
Route::get('anggota/pengajuanku/{id}','ProposalController@showPengajuanByUser');
Route::get('pengajuans','ProposalController@showPengajuan');
Route::get('pengajuans/detail/{id}','ProposalController@detailPengajuan');
Route::put('admin/validasi/{id}','ProposalController@validasiPersyaratan');
Route::get('perusahaan/pengajuan','ProposalController@showPengajuanValid');
Route::put('perusahaan/review/{id}','ProposalController@reviewProposal');
Route::get('anggota/hasil/{id}','ProposalController@viewHasilReview');

Route::get('perusahaan/diterima','ProposalController@showProposalDiterima');
Route::post('perusahaan/bantuan','BantuanController@createBantuan');
Route::put('perusahaan/ubahbantuan/{id}','BantuanController@updateBantuan');
Route::get('perusahaan/viewbantuan/{id}','BantuanController@viewBantuan');
