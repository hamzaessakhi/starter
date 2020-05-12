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
########## End Authentication and guard ################



#################### Begin relations routes #############
 /*
  *  start one to one
  */

Route::get('has-one','Relation\RelationsController@hasOneRelation');
Route::get('has-one-reverse','Relation\RelationsController@hasOneRelationReverse');
Route::get('get-user-has-phone','Relation\RelationsController@getUserHasPhone');
Route::get('get-user-not-has-phone','Relation\RelationsController@getUserNotHasPhone');
Route::get('get-user-has-phone-with-condition','Relation\RelationsController@getUserWhereHasPhoneWithCondition');

 /*
 * end one to one
 */

 /*
  * start one to many
  */

Route::get('hospital-has-many','Relation\RelationsController@gethospitalDoctors');

Route::get('hospitals','Relation\RelationsController@hospitals')->name('hospital.all');

Route::get('hospitals/{hospital_id}','Relation\RelationsController@deleteHospital')->name('hospital.delete');


Route::get('doctors/{hospital_id}','Relation\RelationsController@doctors')->name('hospital.doctors');

Route::get('hospitals_has_doctors','Relation\RelationsController@hospitalsHasDoctor');

Route::get('hospitals_has_doctors_male','Relation\RelationsController@hospitalHasonlyMaleDoctors');

Route::get('hospitals_not_has_not_doctors','Relation\RelationsController@hospitalhasNotdoctors');




/*
 * end one to many
 */

/*
 * start many to many
  */

Route::get('doctors-services','Relation\RelationsController@getDoctorServices');

Route::get('services-doctors','Relation\RelationsController@getServicesdoctors');

Route::get('doctors/services/{doctor_id}','Relation\RelationsController@getDoctorsServiceByID')->name('doctors.services');

Route::post('saveServices-to-doctor','Relation\RelationsController@saveServicesToDoctors')->name('save.doctors.services');


/*
 *end many to namy
 */

/*
 * has one through
 */
Route::get('has-one-through','Relation\RelationsController@getPatientDoctors');

Route::get('has-many-through','Relation\RelationsController@getCountryDoctors');


/*
 * has one through
 *
 */




#################### End relations routes #############

