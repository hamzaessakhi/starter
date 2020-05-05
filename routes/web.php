<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify'=>true]);


Route::get('/home','HomeController@index')->name('home')->middleware('verified');

Route::get('/',function (){
    return 'Home';
});

Route::get('/redirect/{service}','SocialController@redirect');

Route::get('/callback/{service}','SocialController@callback');

Route::get('fillable','CrudController@getOffers');


Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {

    Route::group(['prefix' => 'offers'], function () {
        //   Route::get('store', 'CrudController@store');
        Route::get('create', 'CrudController@create');
        Route::post('store', 'CrudController@store')->name('offers.store');

        Route::get('edit/{offer_id}','CrudController@editOffer');
        Route::post('update/{offer_id}','CrudController@updateOffer')->name('offers.update');
        Route::get('delete/{offer_id}','CrudController@deleteOffer')->name('offers.delete');
        Route::get('all', 'CrudController@getAllOffers')->name('offers.all');
    });

    Route::get('youtube','CrudController@getVideo');
});

######## Begin Ajax routes ##############

Route::group(['prefix'=>'ajax-offers'],function(){
    Route::get('create','OfferController@create');
    Route::post('store','OfferController@store')->name('ajax.offers.store');

});

######## End Ajax routes   ###############

