<?php

use Illuminate\Support\Facades\Route;

/**************Auth Routes******************/
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
/***************End Auth Routes*************/
Route::get('/test', function () {
    return view('home');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', 'HomeController@index')->name('home');
    Route::get('/', 'HomeController@index')->name('home');

    Route::prefix('schools')->group(function () {
        Route::get('all', 'SchoolController@index')->name('allSchools');
        Route::get('datable', 'SchoolController@schoolsDatable')->name('schoolsDatable');
        Route::get('show/{id}', 'SchoolController@show')->name('showSchool');
        Route::get('edit/{id}', 'SchoolController@edit')->name('editSchool');
        Route::get('create', 'SchoolController@create')->name('addSchool');
        Route::post('store', 'SchoolController@store')->name('submitSchool');
        Route::put('update', 'SchoolController@update')->name('updateSchool');
        Route::get('{id}/destroy', 'SchoolController@destroy');
        /**************************************************************************/

        // Gallery
        Route::get('gallery/{id}', 'GalleryController@gallery')->name('gallery');
        Route::post('submitGallery', 'GalleryController@store')->name('submitGallery');
        Route::get('removeGallery/{id}', 'GalleryController@destroy')->name('removeGallery');

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

        // Note
        Route::get('note/{id}/create', 'NoteController@create')->name('noteCreate');
        Route::get('note/{id}/edit', 'NoteController@edit')->name('noteEdit');
        Route::put('note/update', 'NoteController@update')->name('noteUpdate');
        Route::get('note/removeNote/{id}', 'NoteController@destroy')->name('removeNote');
        Route::post('note', 'NoteController@store')->name('noteStore');
        Route::get('note/{id}', 'NoteController@index')->name('note');
        Route::get('noteDatable', 'NoteController@noteDatatble')->name('noteDatatble');
        /*************************************************************************/

    });

    //Gallery Supplier
    Route::get('gallery/supplier/{id}', 'GalleryController@gallerySupplier');
    Route::post('/submitGallerySupplier', 'GalleryController@storeGallerySupplier')->name('submitGallerySupplier');
    Route::get('removeGallerySupplier/{id}', 'GalleryController@destroyGallerySupplier')->name('removeGallerySupplier');
    /**************************************************************************/

    Route::prefix('finance')->group(function () {
        Route::get('all', 'FinanceController@index')->name('allFinance');
        Route::get('datable', 'FinanceController@financeDatable')->name('FinanceDatable');

        // note
        Route::get('note/{id}', 'NoteController@note');
        Route::post('note', 'NoteController@store_note_finance')->name('noteStoreFinance');
        Route::get('note/removeNote/{id}', 'NoteController@destroy')->name('removeNote');

        // Subscription
        Route::get('subscription/{id}', 'FinanceController@subscription');
        Route::post('subscription', 'FinanceController@store')->name('subscriptionStore');
        Route::get('removeSubscription/{id}', 'FinanceController@destroy')->name('removeSubscription');

        // Payment
        Route::get('payment/{id}', 'FinanceController@payment');
        Route::post('payment', 'FinanceController@storePayment')->name('paymentStore');
        Route::get('removePayment/{id}', 'FinanceController@destroyPayment')->name('removePayment');

        Route::get('getSubscription/{id}', 'FinanceController@getSubscription');
        Route::get('editSubscription/{id}/{uid}', 'FinanceController@editSubscription');
    });
    Route::prefix('news')->group(function () {
        Route::get('all', 'NewsController@indexMain')->name('allMainNews');
        Route::get('newsMainDatatable', 'NewsController@newsMainDatatable')->name('newsMainDatatable');
        Route::get('create', 'NewsController@createMainNews')->name('createMainNews');
        Route::post('store', 'NewsController@storeMainNews')->name('MainNewsStore');
        Route::get('{id}/edit', 'NewsController@editMainNews')->name('mainNewsEdit');
        Route::put('/main/update', 'NewsController@updateMainNews')->name('newsMainUpdate');
        Route::get('main/remove/{id}', 'NewsController@destroyMainNews');

    });
    Route::prefix('advertisement')->group(function () {
        Route::get('all', 'AdvertisementController@index')->name('allAdvertisement');
        Route::get('datable', 'AdvertisementController@advertisementDatatable')->name('advertisementDatable');
        Route::get('create', 'AdvertisementController@create')->name('createAdvertisement');
        Route::post('store', 'AdvertisementController@store')->name('storeAdvertisement');
        Route::get('{id}/edit', 'AdvertisementController@edit')->name('EditAdvertisement');
        Route::put('update', 'AdvertisementController@update')->name('UpdateAdvertisement');
        Route::get('destroy/{id}', 'AdvertisementController@destroy')->name('destroyAdvertisement');
    });

    Route::get('mainAdvertisement/all', 'MainAdvertisementController@index')->name('allMainAdvertisement');

    // Registration
    Route::resource('registration', 'RegistrationController');
    Route::get('registrationDatatable', 'RegistrationController@registrationDatatable')->name('registrationDatatable');
    Route::prefix('registration')->group(function () {
        Route::get('note/{id}', 'RegistrationController@note');
        Route::get('note/destroy/{id}', 'RegistrationController@destroyNote');
        Route::post('note', 'RegistrationController@storeNote')->name('noteStoreRegistration');
    });
    /************************************************************************************/

    // FAQ'S
    Route::resource('faq', 'FaqController');
    Route::get('faqDatatable', 'FaqController@faqDatatable')->name('faqDatatble');
    /************************************************************************************/
    // Sales
    Route::resource('sale', 'SaleController');
    Route::get('saleDatatable', 'SaleController@datatable')->name('saleDatatable');
    Route::get('sale/target/{id}', 'SaleController@targets');
    Route::post('sale/storeTarget', 'SaleController@storeTarget')->name('storeTarget');
    Route::get('sale/targetRemove/{id}', 'SaleController@destroyTarget')->name('destroyTarget');
    /************************************************************************************/

    // Sales Finances
    Route::prefix('salesFinances')->group(function () {
        Route::get('user/{id}', 'SaleFinancesController@index');
        Route::get('salesFinancesDatable', 'SaleFinancesController@datatable')->name('salesFinancesDatatable');
        Route::put('update', 'SaleFinancesController@update')->name('saleFinance.update');
        Route::post('store', 'SaleFinancesController@store')->name('saleFinance.store');
        Route::get('create/{id}', 'SaleFinancesController@create')->name('saleFinance.create');
        Route::get('edit/{userId}/{month}/{year}', 'SaleFinancesController@edit')->name('saleFinance.edit');
        Route::get('destroy/{id}', 'SaleFinancesController@destroy')->name('saleFinance.destroy');
    });
    /************************************************************************************/

    //Suggestions
    Route::prefix('suggestions')->group(function () {
        Route::get('all', 'SuggestionsController@index')->name('allSuggestions');
        Route::get('Datatable', 'SuggestionsController@suggestionsDatatable')->name('suggestionsDatatable');
        Route::get('{id}/edit', 'SuggestionsController@edit');
        Route::get('{id}/destroy', 'SuggestionsController@destroy');
    });
    /************************************************************************************/

    //subscribes email
    Route::prefix('subscribes_email')->group(function () {
        Route::get('all', 'SubscribesEmailController@index')->name('allSubscribesEmail');
        Route::get('EmailDatatable', 'SubscribesEmailController@subscribesEmailDatatable')->name('SubscribesEmailDatatable');
        Route::get('destroy/{id}', 'SubscribesEmailController@destroy');
    });
    /************************************************************************************/

    //subscribes email
    Route::prefix('discount')->group(function () {
        Route::get('all', 'DiscountController@index')->name('allDiscount');
        Route::get('DiscountDatatable', 'DiscountController@discountDatatable')->name('DiscountDatatable');
        Route::get('destroy/{id}', 'DiscountController@destroy');
    });
    /************************************************************************************/

    //requests
    Route::prefix('requests')->group(function () {
        Route::get('all', 'RequestsController@index')->name('allRequests');
        Route::get('requestsDatatable', 'RequestsController@requestsDatatable')->name('requestsDatatable');
        Route::get('destroy/{id}', 'RequestsController@destroy');
    });
    /************************************************************************************/

    Route::get('getRegions/{id}', 'SchoolController@regions')->name('getRegions');

    // Supplier
    Route::resource('supplier', 'SupplierController');
    Route::get('supplierDatatable', 'SupplierController@datatable')->name('supplierDatatatble');
    /************************************************************************************/

    Route::prefix('supplier')->group(function () {
        Route::get('all/{id}', 'SupplierMessageController@index');
        Route::get('message/datatable', 'SupplierMessageController@messagesDatatable')->name('messageDatatable');
        Route::get('message/{id}/edit', 'SupplierMessageController@edit');
        Route::get('message/{id}/destroy', 'SupplierMessageController@destroy');
    });

    // User
    Route::resource('user', 'UserController');
    Route::get('userDatatable', 'UserController@userDatatable')->name('userDatatable');
    /************************************************************************************/

});

