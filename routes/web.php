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

Route::get('/Dashboard',function (){
    return 'Not Adult';
})->name('not.adult');
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

#########  Begin Ajax routes ##############

Route::group(['prefix'=>'ajax-offers'],function(){
    Route::get('create','OfferController@create');
    Route::post('store','OfferController@store')->name('ajax.offers.store');
    Route::get('all','OfferController@all')->name('ajax.offers.all');
    Route::post('delete','OfferController@delete')->name('ajax.offers.delete');
    Route::get('edit/{offer_id}','OfferController@edit')->name('ajax.offers.edit');
    Route::post('update','OfferController@update')->name('ajax.offers.update');

});

########  End Ajax routes   ###############


######### Begin Authentication && guard ############

Route::group(['middleware'=>'CheckAge','namespace'=>'Auth'],function(){

Route::get('adults','CustomAuthController@adult')->name('adult');

});

Route::get('site','Auth\CustomAuthController@site')->middleware('auth:web')->name('site');
Route::get('admin','Auth\CustomAuthController@admin')->middleware('auth:admin')->name('admin');

Route::get('admin/login','Auth\CustomAuthController@adminLogin')->name('admin.login');
Route::post('admin/login','Auth\CustomAuthController@checkAdminLogin')->name('save.admin.login');
 // video 72 minute 19:21
########## End Authentication and guard #########"

