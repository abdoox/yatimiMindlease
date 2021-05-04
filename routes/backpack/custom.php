<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.


/*Route::post('login', 'AuthController@login');
Route::get('authenticate', 'AuthController@authenticate');*/


Route::group([
    //'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web'],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { 
Route::get('loginAssociation','LoginAssociationController@showLoginForm');
Route::post('authenticateAssociation','LoginAssociationController@login');
Route::get('beneficiairesAssoc', 'AssociationConnectedController@index');
Route::get('beneficiairesAssocNonParraine', 'AssociationConnectedController@index2');
Route::get('beneficiairesAssocHandicape', 'AssociationConnectedController@index4');
Route::get('beneficiairesAssocParraine', 'AssociationConnectedController@index3');
Route::get('association/beneficiaire/create', 'AssociationConnectedController@create');


	Route::get('association/beneficiaire/parrainages/excelParrainage/{id}', 'AssociationConnectedController@exportParrainages');
	Route::get('association/beneficiaire/parrainages/{id}', 'AssociationConnectedController@parrainages');
	Route::get('association/prise_en_charge_termine/excel','AssociationConnectedController@exportPriseEnChargeTermine');
        Route::get('association/prise_en_charge/excel','AssociationConnectedController@exportPriseEnCharge');
	Route::get('priseEnChargeAssoc', 'AssociationConnectedController@prise_en_charge');
        Route::get('priseEnChargeAssocTermine', 'AssociationConnectedController@prise_en_charge_termine');
	Route::post('association/beneficiaire/store', 'AssociationConnectedController@store');
        Route::get('association/beneficiaire/edit/{id}', 'AssociationConnectedController@edit');
        Route::get('association/beneficiaire/delete/{id}', 'AssociationConnectedController@destroy');
        //Route::get('beneficiaire/create', 'BeneficiaireController@create');
        Route::post('association/beneficiaire/update', 'AssociationConnectedController@update');

	Route::get('association/beneficiaire/excel','AssociationConnectedController@export');
	Route::get('association/beneficiaire/excel2','AssociationConnectedController@export2');
	Route::get('association/beneficiaire/excel3','AssociationConnectedController@export3');                
	Route::get('association/beneficiaire/excel4','AssociationConnectedController@export4');

        Route::post('association/image/store', 'AssociationConnectedController@store_image');
        Route::get('association/image/delete/{id}', 'AssociationConnectedController@destroy_image');
        Route::get('association/create/image/{id}', 'AssociationConnectedController@create_image');


        Route::post('association/wall/store', 'AssociationConnectedController@store_wall');
        Route::get('association/wall/delete/{id}', 'AssociationConnectedController@destroy_wall');
        Route::get('association/create/wall/{id}', 'AssociationConnectedController@create_wall');
	Route::post('logouut','LoginAssociationController@logout');

});

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
	//Route::get('login', 'LoginController@login');
	//Route::post('authenticate', 'LoginController@authenticate');
	//CRUD::resource('news', 'NewsCrudController');
	CRUD::resource('page', 'PageCrudController');
	//CRUD::resource('paiement', 'PaiementCrudController');
	//CRUD::resource('utilisateur', 'UtilisateurCrudController');	
	//CRUD::resource('association', 'AssociationCrudController');
	//CRUD::resource('donation', 'DonationCrudController');
	//CRUD::resource('project', 'ProjectCrudController');

/*	Route::get('login','LoginController@login');
	Route::post('authenticate','LoginController@authenticate');
*/
	//Route::get('loginAssociation','LoginAssociationController@showLoginForm');


	//Route::get('beneficiairesAssoc', 'AssociationConnectedController@index');
	//Route::post('authenticateAssociation','LoginAssociationController@login');
	
	Route::get('association', 'AssociationCrudController@index');
        Route::get('association/edit/{id}', 'AssociationCrudController@edit');
        Route::get('association/delete/{id}', 'AssociationCrudController@destroy');
        Route::get('association/create', 'AssociationCrudController@create');
        Route::post('association/update', 'AssociationCrudController@update');
        Route::post('association/store','AssociationCrudController@store');

	Route::get('benevoles2', 'ActivityController@benevoles2');
	Route::get('benevoles', 'ActivityController@benevoles');
	Route::get('activities', 'ActivityController@index');
        Route::get('activities/edit/{id}', 'ActivityController@edit');
        Route::get('activities/delete/{id}', 'ActivityController@destroy');
        Route::get('activities/create', 'ActivityController@create');
        Route::post('activities/update', 'ActivityController@update');
        Route::post('activities/store','ActivityController@store');
        //Route::get('activities/benevoles/{id}','ActivityController@benevoles');



	Route::get('project', 'ProjectCrudController@index');
	Route::get('projectInProgress', 'ProjectCrudController@inProgress');
	Route::get('projectCollected', 'ProjectCrudController@collected');
	Route::get('projectClosed', 'ProjectCrudController@closed');



        Route::get('project/edit/{id}', 'ProjectCrudController@edit');
        Route::get('project/delete/{id}', 'ProjectCrudController@destroy');
        Route::get('project/create', 'ProjectCrudController@create');
        Route::post('project/update', 'ProjectCrudController@update');
        Route::post('project/store','ProjectCrudController@store');
	Route::get('project/benevoles/{id}','ProjectCrudController@benevoles');



	Route::get('news', 'NewsCrudController@index');
        Route::get('news/edit/{id}', 'NewsCrudController@edit');
        Route::get('news/delete/{id}', 'NewsCrudController@destroy');
        Route::get('news/create', 'NewsCrudController@create');
        Route::post('news/update', 'NewsCrudController@update');
        Route::post('news/store','NewsCrudController@store');
	
	Route::get('dashboard', 'StatsController@index');
	Route::get('donation', 'DonationCrudController@index');
        Route::get('donation/edit/{id}', 'DonationCrudController@edit');
        Route::get('donation/delete/{id}', 'DonationCrudController@destroy');
        Route::get('donation/create', 'DonationCrudController@create');
        Route::post('donation/update', 'DonationCrudController@update');
        Route::post('donation/store','DonationCrudController@store');
        Route::get('donation/excel','DonationCrudController@export');
	Route::get('donation/pdf','DonationCrudController@pdf');

	Route::get('paiement', 'PaiementCrudController@index');
        Route::get('paiement/edit/{id}', 'PaiementCrudController@edit');
        Route::get('paiement/delete/{id}', 'PaiementCrudController@destroy');
        Route::get('paiement/create', 'PaiementCrudController@create');
        Route::post('paiement/update', 'PaiementCrudController@update');
	Route::post('paiement/store','PaiementCrudController@store');
	Route::get('paiement/excel','PaiementCrudController@export');
	Route::get('paiement/pdf','PaiementCrudController@pdf');
	
	Route::get('beneficiaire/pdf','BeneficiaireController@pdf');
	Route::get('beneficiaire/pdf2','BeneficiaireController@pdf2');
	Route::get('beneficiaire/pdf3','BeneficiaireController@pdf3');
	Route::get('beneficiaire/excel','BeneficiaireController@export');
	Route::get('beneficiaire/excel2','BeneficiaireController@export2');
	Route::get('beneficiaire/excel3','BeneficiaireController@export3');
	
	Route::get('beneficiairenonparraine', 'BeneficiaireController@index2');
	Route::get('beneficiaireparraine', 'BeneficiaireController@index3');
	Route::get('beneficiairehandicaps', 'BeneficiaireController@index4');

	
	
	
	
	Route::get('nouveautesValides', 'BeneficiaireController@nouveautesvalides');
	Route::get('nouveautesencours', 'BeneficiaireController@nouveautesencours');

	Route::get('nouveauteWalls/validate/{id}', 'BeneficiaireController@wallsvalidate');
	Route::get('nouveauteWalls/edit/{id}', 'BeneficiaireController@wallsedit');
	Route::get('nouveauteWalls/delete/{id}', 'BeneficiaireController@wallsdelete');
        Route::post('nouveauteWalls/update', 'BeneficiaireController@wallsupdate');

	Route::get('nouveauteMedia/validate/{id}', 'BeneficiaireController@mediavalidate');
        Route::get('nouveauteMedia/edit/{id}', 'BeneficiaireController@mediaedit');
        Route::get('nouveauteMedia/delete/{id}', 'BeneficiaireController@mediadelete');


	Route::get('beneficiaireencours/validate/{id}', 'BeneficiaireController@beneficiairevalidate');
        Route::get('beneficiaireencours/edit/{id}', 'BeneficiaireController@beneficiairedit');
        Route::get('beneficiaireencours/delete/{id}', 'BeneficiaireController@beneficiairedelete');



	Route::get('beneficiairesencours', 'BeneficiaireController@beneficiairesencours');
	Route::get('beneficiairesvalides', 'BeneficiaireController@beneficiairesvalides');
	
	
	
	
	Route::get('beneficiaire', 'BeneficiaireController@index');
	Route::post('beneficiaire/store', 'BeneficiaireController@store');
	Route::get('beneficiaire/edit/{id}', 'BeneficiaireController@edit');
	Route::get('beneficiaire/delete/{id}', 'BeneficiaireController@destroy');
	Route::get('beneficiaire/create', 'BeneficiaireController@create');
	Route::post('beneficiaire/update', 'BeneficiaireController@update');

	Route::post('image/store', 'BeneficiaireController@store_image');
	Route::get('image/delete/{id}', 'BeneficiaireController@destroy_image');
	Route::get('create/image/{id}', 'BeneficiaireController@create_image');


	Route::post('wall/store', 'BeneficiaireController@store_wall');
	Route::get('wall/delete/{id}', 'BeneficiaireController@destroy_wall');
	Route::get('create/wall/{id}', 'BeneficiaireController@create_wall');
	
	
	Route::post('media/store', 'ProjectCrudController@store_media');
        Route::get('media/delete/{id}', 'ProjectCrudController@destroy_media');
        Route::get('create/media/{id}', 'ProjectCrudController@create_media');


        Route::post('advancement/store', 'ProjectCrudController@store_advancement');
        Route::get('advancement/delete/{id}', 'ProjectCrudController@destroy_advancement');
        Route::get('create/advancement/{id}', 'ProjectCrudController@create_advancement');


	Route::post('media/storeActivity', 'ActivityController@store_media');
        Route::get('mediaActivity/delete/{id}', 'ActivityController@destroy_media');
        Route::get('createActivity/media/{id}', 'ActivityController@create_media');

	Route::get('prise_en_charge_partage/pdf', 'UserBeneficiaireCrudController@pdf2');
	Route::get('prise_en_charge/pdf', 'UserBeneficiaireCrudController@pdf');
	Route::get('prise_en_charge_partage/export', 'UserBeneficiaireCrudController@export2');
	Route::get('prise_en_charge_partage', 'UserBeneficiaireCrudController@index2');
	Route::get('prise_en_charge', 'UserBeneficiaireCrudController@index');
	Route::get('prise_en_charge/export', 'UserBeneficiaireCrudController@export');
	Route::get('prise_en_charge/edit', 'UserBeneficiaireCrudController@edit');
        Route::get('prise_en_charge/delete/{id}', 'UserBeneficiaireCrudController@destroy');
        Route::get('prise_en_charge/create', 'UserBeneficiaireCrudController@create');
        Route::post('prise_en_charge/update', 'UserBeneficiaireCrudController@update');
	Route::post('prise_en_charge/store', 'UserBeneficiaireCrudController@store');

	Route::get('parrains', 'UtilisateurCrudController@index2');	
	//Route::get('utilisateur/pdf2', 'UtilisateurCrudController@pdf2');
	Route::get('utilisateur/pdf', 'UtilisateurCrudController@pdf');
	Route::get('utilisateur/excel2', 'UtilisateurCrudController@export2');
	Route::get('utilisateur/excel', 'UtilisateurCrudController@export');
	Route::get('utilisateur', 'UtilisateurCrudController@index');
        Route::get('utilisateur/edit/{id}', 'UtilisateurCrudController@edit');
        Route::get('utilisateur/delete/{id}', 'UtilisateurCrudController@destroy');
        Route::get('utilisateur/create', 'UtilisateurCrudController@create');
        Route::post('utilisateur/update', 'UtilisateurCrudController@update');
        Route::post('utilisateur/store','UtilisateurCrudController@store');


}); // this should be the absolute last line of this file
