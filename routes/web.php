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
    return view('welcome');
});

Route::get('/reset/{token}', function ($token) {
    return view('auth.passwords.reset',['token'=>$token]);
});


//Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');
Route::get('/home', 'HomeController@index')->name('home');

Route::post('success', 'CMIController@success');
Route::post('failure', 'CMIController@failure');

//Route::get('blurImage', 'Admin\BeneficiaireController@blurImage');

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => '\Admin',
], function () { 
	Route::get('notification', 'NotificationController@indexOne');
	Route::get('notification/{id}', 'NotificationController@sendTo');
	Route::post('push/one', 'NotificationController@pushOne');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
