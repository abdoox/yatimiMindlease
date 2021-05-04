<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Association;
use App\Models\Beneficiaire;

class LoginAssociationController extends Controller
{




	public function showLoginForm(){
	
	
	return view('association.login');
	
	
	}



	 public function __construct()
    {

        //$this->middleware('guest')->except('logoutAssociation');
    }



	public function login(Request $request){


		$credentials = [

			"email"=> $request->email,
			"password" =>$request->password
		
			];
		if(auth('associations')->attempt($credentials))
		{

			/*$association = auth('associations')->user();

			$beneficiaires =  Beneficiaire::with(['images_beneficiaire', 'walls_beneficiaire','beneficiaire_translate'])
                    ->join('cities','cities.id','beneficiaires.city_id')
		    ->join('associations','associations.id','beneficiaires.association_id')

		    ->select('beneficiaires.id','beneficiaires.sex','beneficiaires.handicape','cities.label')
		    
		    ->orderBy('beneficiaires.id', 'DESC')
		    ->where('associations.id',$association->id)
		    ->get();*/
		//return auth("associations")->user();	
			return redirect('/beneficiairesAssoc');
			//return view('beneficiaire.list', compact('beneficiaires'));
		
		}



		/*$association = Association::whereEmail($request->email)->first();



		if( $association != null)
		
		{
			if(Hash::check($request->password, $association->password))
		

			{return view('beneficiaire.list');}
			else{return "password check";}*/
		
		else return "false";

	
	
	
	
	
	}



	public function logout(){
	

		auth("associations")->logout();

		return redirect("/loginAssociation");	
	
	
	}
}
