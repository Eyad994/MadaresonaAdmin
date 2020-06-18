<?php

use Illuminate\Support\Facades\Route;

/**************Auth Routes******************/
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
/***************End Auth Routes*************/
Route::get('/test', function (){
   return view('home');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', 'HomeController@index')->name('home');
    Route::get('/', 'HomeController@index')->name('home');

    Route::prefix('schools')->group(function (){
        Route::get('all', 'SchoolController@index')->name('allSchools');
        Route::get('datable', 'SchoolController@schoolsDatable')->name('schoolsDatable');
        Route::get('show/{id}', 'SchoolController@show')->name('showSchool');
        Route::get('edit/{id}', 'SchoolController@edit')->name('editSchool');
        Route::get('create', 'SchoolController@create')->name('addSchool');
        Route::post('store', 'SchoolController@store')->name('submitSchool');
        Route::put('update', 'SchoolController@update')->name('updateSchool');
        Route::get('gallery/{id}', 'GalleryController@gallery')->name('gallery');
        Route::post('submitGallery', 'GalleryController@store')->name('submitGallery');
        Route::get('removeGallery/{id}', 'GalleryController@destroy')->name('removeGallery');
    });

    Route::get('getRegions/{id}', 'SchoolController@regions')->name('getRegions');
});

