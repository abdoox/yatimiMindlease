<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('beneficiaire','Api\BeneficiaireController@getBeneficiaire');
Route::get('getBeneficiairesBySchoolResults','Api\AuthController@getBeneficiairesBySchoolResults');
Route::get('getBeneficiairesByBrothersNumber','Api\AuthController@getBeneficiairesByBrothersNumber');
Route::get('distance','Api\AuthController@distanceBetween');
Route::get('byAge','Api\AuthController@getBeneficiairesByAge');
Route::get('getBeneficiairesBySexe','Api\AuthController@getBeneficiairesBySexe');
//Route::post('distancee','Api\AuthController@distance');
Route::post('sendVerificationEmailTo','Api\AuthController@sendVerificationEmailTo');
Route::get('verifyemail/{token}','Api\AuthController@verifyEmail');
Route::post('resetpass','Api\AuthController@reset');
Route::post('forgot','Api\AuthController@forgot');
Route::post('register','Api\AuthController@register');
Route::post('login','Api\AuthController@authenticate');
Route::post('reset-pass', 'Api\AuthController@resetpass');
Route::post('facebook_google_LoginRegister','Api\AuthController@facebook_google_LoginRegister');
Route::get('numberOfIncomplete', 'Api\BeneficiaireController@numberOfIncomplete');
Route::get('stats', 'Api\StatsController@index');
Route::get('metiers','Api\AuthController@getMetiers');
Route::get('cities','Api\AuthController@get_cities');
Route::get('getBeneficiaires','Api\BeneficiaireController@getBeneficiaires');
Route::get('detailsBeneficiaire','Api\BeneficiaireController@detailsBeneficiaire');
Route::get('news','Api\ContentController@news');
Route::get('activities','Api\ContentController@activities');
Route::get('page','Api\ContentController@page');
Route::get('allprojects','Api\ContentController@allprojects');
Route::get('projects','Api\ContentController@projects');
Route::get('getWallBeneficiaire','Api\BeneficiaireController@getWallBeneficiaire');
Route::get('incompleteBeneficiaires','Api\BeneficiaireController@getIncompleteBeneficiaires');
Route::post('callback/paiement','Api\AuthController@approve_paiement');
Route::post('callback/donation','Api\AuthController@approve_donation');
Route::get('test_notification','Api\AuthController@testNotification');
Route::get('payment_reminder','Api\AuthController@paymentReminder');
Route::post('resetpass','Api\AuthController@reset');
//Route::post('cancelKafala','Api\BeneficiaireController@cancelKafala');
//Route::get('Beneficiaires','Api\BeneficiaireController@getBeneficiaires_auth');
//Route::post('notifNotReadedNumber','Api\BeneficiaireController@getNumberAlertsNotReaded');
Route::get('getHandicapsBeneficiaires','Api\BeneficiaireController@getHandicapsBeneficiaires');
Route::get('getAllHandicapsBeneficiaires','Api\BeneficiaireController@getAllHandicapsBeneficiaires');
        //Route::post('save-device', 'Api\AuthController@saveDevice');
//    Route::post('sendToYatim', 'Api\AuthController@sendToYatim');
//Route::post('checklike','Api\BeneficiaireController@checkLike');
//        Route::get('beneficiaires/prise_en_charge','Api\BeneficiaireController@getBeneficiaires_pris_en_charge');
Route::post('benevoleInconnu', 'Api\AuthController@benevoleInconnu');
Route::get('genies', 'Api\BeneficiaireController@getBeneficiaires_genies');
Route::get('test', 'Api\AuthController@test');
Route::get('Beneficiaires','Api\BeneficiaireController@getBeneficiaires_auth2');
        //Route::post('getTypeKafala','Api\AuthController@getKafalaType');

Route::post('sendSMS','Api\AuthController@sendSMS');
Route::post('checkOtp','Api\AuthController@checkOtp');
//Route::get('profile','Api\AuthController@profile');
Route::group(['middleware' => ['jwt.auth']], function(){

	//Route::get('sendSMS','Api\AuthController@sendSMS');
	Route::post('getTypeKafala','Api\AuthController@getKafalaType');
	Route::post('cancelKafala','Api\BeneficiaireController@cancelKafala');
	Route::post('changeKafala','Api\BeneficiaireController@changeKafala');
	Route::post('benevole', 'Api\AuthController@benevole');	
	Route::post('sendToYatim', 'Api\AuthController@sendToYatim');	
	Route::post('collabsWithMe','Api\AuthController@getCollabsWithMe');
	Route::post('verifyAccount', 'Api\AuthController@verify');
	Route::post('save-device', 'Api\AuthController@saveDevice');
	Route::post('add/like', 'Api\BeneficiaireController@addLike');
   	Route::post('dislike', 'Api\BeneficiaireController@dislike');
   	Route::post('checklike','Api\BeneficiaireController@checkLike');
	Route::get('favoris', 'Api\BeneficiaireController@favoris');
	//Route::get('Beneficiaires','Api\BeneficiaireController@getBeneficiaires_auth');
	Route::get('paiement','Api\BeneficiaireController@paiement');
	Route::post('add/paiement','Api\AuthController@add_paiement');
	Route::post('pre/paiement','Api\AuthController@pre_paiement');
	Route::get('beneficiaires/prise_en_charge','Api\BeneficiaireController@getBeneficiaires_pris_en_charge');
	Route::get('historique/paiement','Api\BeneficiaireController@historiquePaiement');
	Route::get('notifications','Api\BeneficiaireController@getAlerts');
        Route::post('deleteNotification','Api\BeneficiaireController@deleteAlert');
	Route::get('profile','Api\AuthController@profile');
	Route::post('update/profile','Api\AuthController@update_profile');
	Route::post('update/image','Api\AuthController@editPicture');
	Route::post('prise_en_charge','Api\AuthController@prise_en_charge');
	Route::post('logout','Api\AuthController@logout');
	Route::post('updatepass','Api\AuthController@updatepass');
	Route::post('notifNotReadedNumber','Api\BeneficiaireController@getNumberAlertsNotReaded');
	Route::post('readNotifications','Api\BeneficiaireController@readNotifications');
});
