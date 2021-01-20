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

Route::get('/', function () {
    return view('index');
});

Route::get('/info', 'InfoController@index');

Route::get('/race', 'RacePaymentController@showRaceForm');
Route::post('/race/new', 'RacePaymentController@registerRacer');
Route::get('/race/upload', 'RacePaymentController@uploadResult');

Route::get('strava/connect', 'InfoController@stravaAuth');
Route::get('strava/token', 'InfoController@stravaGetToken');
Route::get('strava/activities', 'InfoController@stravaActivityList');
Route::get('strava/submit/{id}', 'InfoController@stravaSubmitActivity');

Route::get('/results', 'ResultsController@index');
Route::get('/results/get_data', 'ResultsController@chartData');

Route::get('/auth/{provider}', 'SocialController@redirectProvider');
Route::get('/auth/callback/{provider}', 'SocialController@handleCallback');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/payment',  'RacePaymentController@payment');
    Route::get('/payment/snap',  'RacePaymentController@requestMidtrans');
    Route::post('/payment/notify', 'RacePaymentController@paymentNotification');
    Route::post('/payment/complete', 'RacePaymentController@payComplete');
    Route::post('/upload', 'RacePaymentController@handleUpload');
});

Auth::routes();

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
