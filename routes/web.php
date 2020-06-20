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

        // Gallery
        Route::get('gallery/{id}', 'GalleryController@gallery')->name('gallery');
        Route::post('submitGallery', 'GalleryController@store')->name('submitGallery');
        Route::get('removeGallery/{id}', 'GalleryController@destroy')->name('removeGallery');
        /**************************************************************************/

        // Transportation
        Route::get('transportation/{id}/create', 'TransportationController@create')->name('transportationCreate');
        Route::get('transportation/{id}/edit', 'TransportationController@edit')->name('transportationEdit');
        Route::put('transportation/update', 'TransportationController@update')->name('transportationUpdate');
        Route::get('transportation/removeTransportation/{id}', 'TransportationController@destroy')->name('removeTransportation');
        Route::post('transportation', 'TransportationController@store')->name('transportationStore');
        Route::get('transportation/{id}', 'TransportationController@index')->name('transportation');
        Route::get('transportationDatable', 'TransportationController@transportationDatatble')->name('transportationDatatble');
        /*************************************************************************/


        // Premiums
        Route::get('premium/{id}', 'PremiumController@index');
        Route::get('premium/{id}/create', 'PremiumController@create')->name('premiumCreate');
        Route::get('premium/{id}/edit', 'PremiumController@edit')->name('premiumEdit');
        Route::put('premium/update', 'PremiumController@update')->name('premiumUpdate');
        Route::get('premium/removePremium/{id}', 'PremiumController@destroy')->name('removePremium');
        Route::post('premium', 'PremiumController@store')->name('premiumStore');
        Route::get('premiumDatable', 'PremiumController@premiumDatatble')->name('premiumDatatble');
        /*************************************************************************/

        // News
        Route::get('news/{id}', 'NewsController@index');
        Route::get('news/{id}/create', 'NewsController@create')->name('newsCreate');
        Route::get('news/{id}/edit', 'NewsController@edit')->name('newsEdit');
        Route::put('news/update', 'NewsController@update')->name('newsUpdate');
        Route::get('news/removeNews/{id}', 'NewsController@destroy')->name('removeNews');
        Route::post('news', 'NewsController@store')->name('newsStore');
        Route::get('newsDatable', 'NewsController@newsDatatble')->name('newsDatatble');
        /*************************************************************************/

    });

    Route::get('getRegions/{id}', 'SchoolController@regions')->name('getRegions');
});

