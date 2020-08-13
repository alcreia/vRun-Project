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

Route::get('/info', function () {
    return view('pages.info');
});

Route::get('/results', function () {
    return view('pages.results');
});

Route::get('/register', 'Auth\RegisterController@showRegistrationForm');
Route::post('/register', 'Auth\RegisterController@register')->name('register');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/payment',  'RacePaymentController@payment');
    Route::get('/payment/snap',  'RacePaymentController@requestMidtrans');
    Route::post('/payment/notify', 'RacePaymentController@paymentNotification');
    Route::post('/payment/complete', 'RacePaymentController@payComplete');
    Route::post('/upload', 'RacePaymentController@handleUpload');
});

Auth::routes(['register' => 'false']);

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
