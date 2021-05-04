<?php

namespace App\Http\Controllers\admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\Beneficiaire;
use App\Models\Beneficiairetranslate;
use App\Models\Photo;
use App\Models\Association;
use App\Models\WallsBeneficiaire;
use PDF;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
use LaravelFCM\Message\Topics;
use App\Models\Notification;
use App\Models\Media;
//use Intervention\Image\Image;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\BeneficiaireUser;
use App\User;
use App\Models\City;
use App\Models\Project;
use App\Models\ProjectTranslate;
use App\Models\AssociationTranslate;


class AssociationCrudController extends Controller
{









    public function index(Request $request)
    {
		
	    $associations = Association::join('association_translate','association_translate.association_id','=','associations.id')
		    ->join('cities','cities.id','=','associations.city_id')
		    ->join('cities_translate','cities.id','=','cities_translate.city_id')
		    ->where('cities_translate.language_id',2)
		    ->where('association_translate.language_id',2)
		    ->select('associations.id','cities_translate.label','associations.email','association_translate.name','association_translate.address')			    
		    ->get();
	  //return response()->json(['associations'=>$associations]); 
	    	
	    return view('association.list', compact('associations'));
 	    
        
    }


    
     public function store(Request $request) {
		

	     $association = new Association;
	        
	        $association->email = $request->post('email');
                $association->password = bcrypt($request->post('password'));
                $association->phone = $request->post('phone');
		$association->city_id = $request->post('ville');

		$association->save();	
		
		$association_ar = new AssociationTranslate;
		$association_ar->association_id = $association->id;
                $association_ar->name= $request->name_ar;
                $association_ar->address= $request->address_ar;
		$association_ar->language_id = 2;
		$association_ar->save();

                $association_fr = new AssociationTranslate;
                $association_fr->association_id = $association->id;
                $association_fr->name= $request->name_fr;
                $association_fr->address= $request->address_fr;
		$association_fr->language_id = 1;

		$association_fr->save();


                

                return redirect('/admin/association');









        return redirect('/admin/paiement');
    }

    public function create()
    
    {
	    $cities = City::join('cities_translate','cities.id','=','cities_translate.city_id')
		    ->where('language_id',2)
		    ->select('cities.id','cities_translate.label')
		    ->get();
	    
		     	return view('association.add',compact('cities'));
    }



    public function edit($id)
    {    
        $association = Association::with('association_translate')
                    //->join('cities','cities.id','=','associations.city_id')
                    //->join('cities_translate','cities.id','=','cities_translate.city_id')                   
		    ->where('associations.id',$id)
		    ->first();
	$city = City::join('cities_translate','cities.id','=','cities_translate.city_id')
		->where('language_id',2)
		->where('cities.id',$association->city_id)
		->first();
	
	$cities = City::join('cities_translate','cities.id','=','cities_translate.city_id')
		->where('language_id',2)->get();
//	return $paiement;
        return view('association.edit', compact(['association','cities','city']));
    }
	
	public function destroy($id)
    {
    	
	
	    $paiement = Association::find($id);
	    
	    $paiement->delete();

        
        return redirect('/admin/association');
    }

   
    
    public function update(Request $request)
    {
		
		$association = Association::find($request->post('id'));
		
		if($association){

		
		 $associationCheck = Association::whereEmail($request->email)->where('id', '<>', $request->id)->first();
                 if($associationCheck == null){

			 $association->email = $request->email;

                   if(!empty($request->password)){
				    
		$association->password = bcrypt($request->password);}
		$association->email = $request->post('email');

                $association->phone = $request->post('phone');
                $association->city_id = $request->post('ville');

                $association_ar = AssociationTranslate::where('association_id',$request->post('id'))->where('language_id',2)->first();

                $association_ar->name= $request->name_ar;
                $association_ar->address= $request->address_ar;
                $association_ar->save();

                $association_fr = AssociationTranslate::where('association_id',$request->post('id'))->where('language_id',1)->first();

                $association_fr->name= $request->name_fr;
                $association_fr->address= $request->address_fr;
                $association_fr->save();


                $association->save();
 
			   }else{


			   return ('email existant');
			   
			   }
			
		return redirect('/admin/association');
		
		}
		
       return redirect('/admin');
    }

    
    
}
