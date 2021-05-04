<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Exceptions\JWTException;
use Mail;
use Carbon\Carbon;
use DateTime;
use DatePeriod;
use DateInterval;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

//---------Models--------
use App\User;
use App\Models\BeneficiaireUser;
use App\Models\Beneficiaire;
use App\Models\Country;
use App\Models\City;
use App\Models\Language;
use App\Models\WallsBeneficiaire;
use App\Models\UserBeneficiaireLike;
use App\Models\Paiement;
use App\Models\Notification;
use App\Models\BeneficiaireNote;
use App\Models\BeneficiaireEcole;

class BeneficiaireController extends Controller
{



	public function getBeneficiaire(Request $request){

 		$label = $request->label;
		
		$language = Language::where('label','=',$label)->first();

                if($language)
                {



                                $beneficiaires = Beneficiaire::with(['images_beneficiaire', 'walls_beneficiaire' , 'notes_beneficiaire' ,'handicape_beneficiaire' => function($q) use($language) {

                                        $q->where('language_id', '=', $language->id);
                                }])
                                        ->join('beneficiaire_translate','beneficiaires.id','=','beneficiaire_translate.beneficaire_id')
                                        ->join('cities','cities.id','=','beneficiaires.city_id')
                                        ->join('cities_translate','cities.id','=','cities_translate.city_id')
                                        //->join("beneficiaire_school_results","beneficiaire_school_results.beneficiaire_id",'beneficiaires.id')
                                        ->select('beneficiaires.id','age','cities_translate.label as city','first_name','image_blur as image','birthday','sex','dream',"beneficiaires.type",'father_name', 'death_date', 'father_birthday', 'isfree','handicape')

        //->select('beneficiaires.id','age',"city",'last_name','first_name','image',"biography","dream",
                                //"father_name","mother_name","leisure","address","school_level","birthday","sex","weight","length","Last_school_note")
                                ->where('beneficiaire_translate.language_id','=',$language->id)
                                ->where('cities_translate.language_id','=',$language->id)
                               // ->where('beneficiaire_school_results.language_id',$language->id)
                                ->find($request->id);

          return response()->json($beneficiaires);




	
		}
	}



	public function getBeneficiaires_genies(Request $request){


	
		
                $label = $request->label;
        	$language = Language::where('label','=',$label)->first();
        	
		if($language)
        	{
		
			
				 
				


				$beneficiaires = Beneficiaire::join('beneficiaire_translate','beneficiaires.id','=','beneficiaire_translate.beneficaire_id')
                                        		      ->join('cities','cities.id','=','beneficiaires.city_id')
                                        		      ->join('cities_translate','cities.id','=','cities_translate.city_id')
							      //->join("beneficiaire_school_results","beneficiaire_school_results.beneficiaire_id",'beneficiaires.id')
							      ->join("beneficiaire_ecole_superieure",'beneficiaire_ecole_superieure.beneficiaire_id','beneficiaires.id')
					 		      ->select('beneficiaires.id','age',"cities_translate.label as city",'last_name','first_name','image_blur as image',"school_level",'last_school_name','beneficiaire_ecole_superieure.noteBac','beneficiaire_ecole_superieure.charges')	
	
                                ->where('beneficiaire_translate.language_id','=',$language->id)
				->where('cities_translate.language_id','=',$language->id)
				->where('beneficiaire_ecole_superieure.noteBac','>=','16')
				->where('isfree',1)
				//->where('beneficiaire_school_results.language_id',$language->id)
				->get();
                               

				

						
          return response()->json(compact('beneficiaires'));
				


			


				
					

	
			 }
		}

		
		
					
		
		//return $beneficiaires;


		

	
	//fin

                                        



	public function numberOfIncomplete(){

		 $data = DB::table("beneficiaire_user")

            ->where('type',1)

            ->where('status','validé')

            ->select( "beneficiaire_id")

            ->distinct()

            ->get();

           // return $data;

            $array = array();

            $beneficiaires = array();

            foreach($data as $item){

                    $count = BeneficiaireUser::where('beneficiaire_id',$item->beneficiaire_id)->where('status','validé')->where('type',1)->count();
                    $temp = ["beneficiaire_id"=>$item->beneficiaire_id, "count"=>$count];
                    if($count < 3 && $count > 0)
                    {array_push($array, $temp);}

            }

             //return sizeof($array);
		return response()->json(["number"=>sizeof($array)]);

	}

	 public function getIncompleteBeneficiaires(Request $request)
	 {


        $label = $request->label;
        $language = Language::where('label','=',$label)->first();
        if($language)
        {


	    $data = DB::table("beneficiaire_user")
		
	    ->where('type',1)

	    ->where('status','validé')		    

	    ->select( "beneficiaire_id") 

	    ->distinct()

	    ->get();

	   // return $data;

	    $array = array();

	    $beneficiaires = array();

	    foreach($data as $item){

		    $count = BeneficiaireUser::where('beneficiaire_id',$item->beneficiaire_id)->where('status','validé')->where('type',1)->count();
		    $temp = ["beneficiaire_id"=>$item->beneficiaire_id, "count"=>$count];
		    if($count < 3 && $count > 0)
		    {array_push($array, $temp);}

	    }
		
	    //return $array;

	    $result = array();

	    foreach($array as $item){

		    $beneficiaire = Beneficiaire::with(['images_beneficiaire', 'walls_beneficiaire'  , 'notes_beneficiaire' ,'handicape_beneficiaire'=> function($q) use($language) {
	
                                        $q->where('language_id', '=', $language->id);
                                }])
                                        ->join('beneficiaire_translate','beneficiaires.id','=','beneficiaire_translate.beneficaire_id')
                                        ->join('cities','cities.id','=','beneficiaires.city_id')
                                        ->join('cities_translate','cities.id','=','cities_translate.city_id')
					
				       	->select('beneficiaires.id','age',"cities_translate.label as city",'last_name','first_name','image_blur as image',"biography","dream","beneficiaires.type",
                                "father_name","mother_name","leisure","address","school_level","birthday","sex","weight","length","Last_school_note","nb_likes as like", 'death_date', 'father_birthday', 'isfree','beneficiaires.type','mother_death_date','house_price','handicape')

                               /* ->select('beneficiaires.id','age','cities_translate.label as city','first_name','image_blur as image','birthday','sex','dream','father_name', 'death_date', 'father_birthday', 'isfree')
				*///->select('beneficiaires.id','age',"city",'last_name','first_name','image',"biography","dream",
                                //"father_name","mother_name","leisure","address","school_level","birthday","sex","weight","length","Last_school_note")
                                ->where('beneficiaire_translate.language_id','=',$language->id)
                                ->where('isfree',0)
                                ->where('cities_translate.language_id','=',$language->id)
				->find($item["beneficiaire_id"])
				;
		    if($beneficiaire != null){

			    $beneficiaireArray = $beneficiaire->toArray();
			    $mergedResult = array_merge($beneficiaireArray, ["count"=> $item['count']]);
			   

		    }
    
		    array_push($beneficiaires, $beneficiaireArray);
		    
	    
	    }	
	   

	   return $beneficiaires; 
	   

	
		}

	 }
	
	
	
	
	public function getHandicapsBeneficiaires(Request $request)
  {
        $label = $request->label;
        $language = Language::where('label','=',$label)->first();
        if($language)
        {

                        $beneficiaires = Beneficiaire::with(['images_beneficiaire', 'walls_beneficiaire' , 'notes_beneficiaire' ,'handicape_beneficiaire' => function($q) use($language) {

                                        $q->where('language_id', '=', $language->id);
                                }])
					->join('beneficiaire_translate','beneficiaires.id','=','beneficiaire_translate.beneficaire_id')
					->join('cities','cities.id','=','beneficiaires.city_id')
					->join('cities_translate','cities.id','=','cities_translate.city_id')
					/* ->select('beneficiaires.id','age',"city",'last_name','first_name','image',"biography","dream",
						 "father_name","mother_name","leisure","address","school_level","birthday","sex","weight","length","Last_school_note","nb_likes as like", 'death_date', 'father_birthday', 'isfree','beneficiaires.type','mother_death_date','house_price','handicape')*/
					

					->select('beneficiaires.id','age','cities_translate.label as city','first_name','image_blur as image','birthday','sex','dream',"beneficiaires.type",'father_name', 'death_date', 'father_birthday', 'isfree','handicape')
                                //->select('beneficiaires.id','age',"city",'last_name','first_name','image',"biography","dream",
                                //"father_name","mother_name","leisure","address","school_level","birthday","sex","weight","length","Last_school_note")
                                ->where('beneficiaire_translate.language_id','=',$language->id)
				->where('isfree',1)
				->where('cities_translate.language_id','=',$language->id)
				->where('beneficiaires.handicape',1);
                        if(isset($request->termsearch) && !empty($request->termsearch) ){
                                $term_search = $request->termsearch;
                $beneficiaires = $beneficiaires->where(function ($beneficiaires) use ($term_search) {
                        $beneficiaires->where('first_name', 'like', "%".$term_search."%")
                              ->orWhere('last_name', 'like',"%".$term_search."%")
                              ->orWhere('biography', 'like',"%".$term_search."%")
                              ->orWhere('dream', 'like',"%".$term_search."%")
                              ->orWhere('leisure', 'like',"%".$term_search."%")
                              ->orWhere('address', 'like',"%".$term_search."%")
                              ->orWhere('city', 'like',"%".$term_search."%")
                              ->orWhere('school_level', 'like',"%".$term_search."%")
                              ->orWhere('last_school_name', 'like',"%".$term_search."%")
                              ->orWhere('age', 'like',"%".$term_search."%")
                              ;
                    });
                        }
		$beneficiaires = $beneficiaires->paginate(6);
                        /*
                        foreach ($beneficiaires as $key => $beneficiaire) {

                    $beneficiaires[$key]['like'] = 0;

                                        $paiment = BeneficiaireUser::where('beneficiaire_user.beneficiaire_id','=', $beneficiaire->id)
                                                                ->where('beneficiaire_user.status', '!=', 'annulé')->first();
                    if(!$paiment){
                        $beneficiaires[$key]['isfree'] = 1;
                    }else{
                        $beneficiaires[$key]['isfree'] = 0;
                    }
                        }*/

          return response()->json(compact('beneficiaires'));

      }
  }





	 public function getAllHandicapsBeneficiaires(Request $request)
  {
        $label = $request->label;
        $language = Language::where('label','=',$label)->first();
        if($language)
        {

                        $beneficiaires = Beneficiaire::with(['images_beneficiaire', 'walls_beneficiaire' , 'notes_beneficiaire' ,'handicape_beneficiaire' => function($q) use($language) {

                                        $q->where('language_id', '=', $language->id);
                                }])
                                        ->join('beneficiaire_translate','beneficiaires.id','=','beneficiaire_translate.beneficaire_id')
                                        ->join('cities','cities.id','=','beneficiaires.city_id')
                                        ->join('cities_translate','cities.id','=','cities_translate.city_id')
                                        /* ->select('beneficiaires.id','age',"city",'last_name','first_name','image',"biography","dream",
                                                 "father_name","mother_name","leisure","address","school_level","birthday","sex","weight","length","Last_school_note","nb_likes as like", 'death_date', 'father_birthday', 'isfree','beneficiaires.type','mother_death_date','house_price','handicape')*/


                                        ->select('beneficiaires.id','age','cities_translate.label as city','first_name','image_blur as image','birthday','sex','dream',"beneficiaires.type",'father_name', 'death_date', 'father_birthday', 'isfree','handicape')
                                //->select('beneficiaires.id','age',"city",'last_name','first_name','image',"biography","dream",
                                //"father_name","mother_name","leisure","address","school_level","birthday","sex","weight","length","Last_school_note")
                                ->where('beneficiaire_translate.language_id','=',$language->id)
                                ->where('isfree',1)
                                ->where('cities_translate.language_id','=',$language->id)
                                ->where('beneficiaires.handicape',1);
                        if(isset($request->termsearch) && !empty($request->termsearch) ){
                                $term_search = $request->termsearch;
                $beneficiaires = $beneficiaires->where(function ($beneficiaires) use ($term_search) {
                        $beneficiaires->where('first_name', 'like', "%".$term_search."%")
                              ->orWhere('last_name', 'like',"%".$term_search."%")
                              ->orWhere('biography', 'like',"%".$term_search."%")
                              ->orWhere('dream', 'like',"%".$term_search."%")
                              ->orWhere('leisure', 'like',"%".$term_search."%")
                              ->orWhere('address', 'like',"%".$term_search."%")
                              ->orWhere('city', 'like',"%".$term_search."%")
                              ->orWhere('school_level', 'like',"%".$term_search."%")
                              ->orWhere('last_school_name', 'like',"%".$term_search."%")
                              ->orWhere('age', 'like',"%".$term_search."%")
                              ;
                    });
                        }
                $beneficiaires = $beneficiaires->paginate(100);
                        /*
                        foreach ($beneficiaires as $key => $beneficiaire) {

                    $beneficiaires[$key]['like'] = 0;

                                        $paiment = BeneficiaireUser::where('beneficiaire_user.beneficiaire_id','=', $beneficiaire->id)
                                                                ->where('beneficiaire_user.status', '!=', 'annulé')->first();
                    if(!$paiment){
                        $beneficiaires[$key]['isfree'] = 1;
                    }else{
                        $beneficiaires[$key]['isfree'] = 0;
                    }
                        }*/

          return response()->json(compact('beneficiaires'));

      }
  }



















	 public function getBeneficiaires_auth2(Request $request)
	 {
		 
        	$label = $request->label;
		
		$language = Language::where('label','=',$label)->first();
		
		if($language)
        {

                        $beneficiaires = Beneficiaire::with(['images_beneficiaire', 'walls_beneficiaire', 'notes_beneficiaire','handicape_beneficiaire' => function($q) use($language) {

                                        $q->where('language_id', '=', $language->id);
                                }])
                                        ->join('beneficiaire_translate','beneficiaires.id','=','beneficiaire_translate.beneficaire_id')
                                        ->join('cities','cities.id','beneficiaires.city_id')
                                        ->join('cities_translate','cities_translate.city_id','cities.id')
                                        ->select('beneficiaires.id','age',"last_name",'first_name','cities_translate.label as city','image_blur as image',"beneficiaires.type","birthday","sex","dream","father_name","nb_likes as like", 'death_date', 'father_birthday', 'isfree','handicape')
                                        /*->select('beneficiaires.id','age','cities_translate.label as city','first_name','image_blur as image','birthday','sex','dream','father_name', 'death_date', 'father_birthday', 'isfree','handicape')*/
                                //->select('beneficiaires.id','age',"city",'last_name','first_name','image',"biography","dream",
                                        //"father_name","mother_name","leisure","address","school_level","birthday","sex","weight","length","Last_school_note")
                                /*->select('beneficiaires.id','age',"city",'last_name','first_name','image',"biography","dream",
                                        "father_name","mother_name","leisure","address","school_level","birthday","sex","weight","length","Last_school_note","nb_likes as like", 'death_date', 'father_birthday', 'isfree','beneficiaires.type','mother_death_date','house_price','handicape')*/
                                ->where('beneficiaire_translate.language_id','=',$language->id)
                                ->where('cities_translate.language_id',$language->id)
                                ->where('beneficiaires.handicape',0)
                                ->where('isfree',1);
                        if(isset($request->termsearch) && !empty($request->termsearch) ){
                                $term_search = $request->termsearch;
                $beneficiaires = $beneficiaires->where(function ($beneficiaires) use ($term_search) {
                        $beneficiaires->where('first_name', 'like', "%".$term_search."%")
                              ->orWhere('last_name', 'like',"%".$term_search."%")
                              ->orWhere('biography', 'like',"%".$term_search."%")
                              ->orWhere('dream', 'like',"%".$term_search."%")
                              ->orWhere('leisure', 'like',"%".$term_search."%")
                              ->orWhere('address', 'like',"%".$term_search."%")
                              ->orWhere('city', 'like',"%".$term_search."%")
                              ->orWhere('school_level', 'like',"%".$term_search."%")
                              ->orWhere('last_school_name', 'like',"%".$term_search."%")
                              ->orWhere('age', 'like',"%".$term_search."%")
                              ;
                    });
                        }
                        /*if(isset($request->like) && $request->like == 1 ){
                                $beneficiaires = $beneficiaires->where('isfree', '=', 0);
                        }
                        else{
                                $beneficiaires = $beneficiaires->where('isfree', '=', 1);
                                $beneficiaires = $beneficiaires->inRandomOrder();
                                //$beneficiaires = $beneficiaires->orderBy('beneficiaires.created_at', 'desc');
                        }*/

                        $beneficiaires = $beneficiaires->paginate(100);
                        /*
                        foreach ($beneficiaires as $key => $beneficiaire) {

                    $beneficiaires[$key]['like'] = 0;

                                        $paiment = BeneficiaireUser::where('beneficiaire_user.beneficiaire_id','=', $beneficiaire->id)
                                                                ->where('beneficiaire_user.status', '!=', 'annulé')->first();
                    if(!$paiment){
                        $beneficiaires[$key]['isfree'] = 1;
                    }else{
    	                    $beneficiaires[$key]['isfree'] = 0;
                    }
                        }*/

          return response()->json(compact('beneficiaires'));

      }
   }









   public function getBeneficiaires(Request $request)
  {
     	$label = $request->label;
     	$language = Language::where('label','=',$label)->first();
     	if($language)
     	{

			$beneficiaires = Beneficiaire::with(['images_beneficiaire', 'walls_beneficiaire', 'notes_beneficiaire','handicape_beneficiaire' => function($q) use($language) {

					$q->where('language_id', '=', $language->id);
				}])
					->join('beneficiaire_translate','beneficiaires.id','=','beneficiaire_translate.beneficaire_id')
					->join('cities','cities.id','beneficiaires.city_id')
					->join('cities_translate','cities_translate.city_id','cities.id')
					->select('beneficiaires.id','age',"last_name",'first_name','cities_translate.label as city','image_blur as image',"beneficiaires.type","birthday","sex","dream","father_name","nb_likes as like", 'death_date', 'father_birthday', 'isfree','handicape')
					/*->select('beneficiaires.id','age','cities_translate.label as city','first_name','image_blur as image','birthday','sex','dream','father_name', 'death_date', 'father_birthday', 'isfree','handicape')*/
				//->select('beneficiaires.id','age',"city",'last_name','first_name','image',"biography","dream",
					//"father_name","mother_name","leisure","address","school_level","birthday","sex","weight","length","Last_school_note")
				/*->select('beneficiaires.id','age',"city",'last_name','first_name','image',"biography","dream",
					"father_name","mother_name","leisure","address","school_level","birthday","sex","weight","length","Last_school_note","nb_likes as like", 'death_date', 'father_birthday', 'isfree','beneficiaires.type','mother_death_date','house_price','handicape')*/
				->where('beneficiaire_translate.language_id','=',$language->id)
				->where('cities_translate.language_id',$language->id)
				->where('beneficiaires.handicape',0)
				->where('isfree',1);
			if(isset($request->termsearch) && !empty($request->termsearch) ){
				$term_search = $request->termsearch;
                $beneficiaires = $beneficiaires->where(function ($beneficiaires) use ($term_search) {
                        $beneficiaires->where('first_name', 'like', "%".$term_search."%")
                              ->orWhere('last_name', 'like',"%".$term_search."%")
                              ->orWhere('biography', 'like',"%".$term_search."%")
                              ->orWhere('dream', 'like',"%".$term_search."%")
                              ->orWhere('leisure', 'like',"%".$term_search."%")
                              ->orWhere('address', 'like',"%".$term_search."%")
			      ->orWhere('city', 'like',"%".$term_search."%")
			      ->orWhere('school_level', 'like',"%".$term_search."%")
                              ->orWhere('last_school_name', 'like',"%".$term_search."%")
			      ->orWhere('age', 'like',"%".$term_search."%")	
			      ;
                    });
			}
			/*if(isset($request->like) && $request->like == 1 ){
				$beneficiaires = $beneficiaires->where('isfree', '=', 0);
			}
			else{
				$beneficiaires = $beneficiaires->where('isfree', '=', 1);
				$beneficiaires = $beneficiaires->inRandomOrder();
				//$beneficiaires = $beneficiaires->orderBy('beneficiaires.created_at', 'desc');
			}*/

			$beneficiaires = $beneficiaires->paginate(100);
			/*
			foreach ($beneficiaires as $key => $beneficiaire) {

                    $beneficiaires[$key]['like'] = 0;

					$paiment = BeneficiaireUser::where('beneficiaire_user.beneficiaire_id','=', $beneficiaire->id)
								->where('beneficiaire_user.status', '!=', 'annulé')->first();
                    if(!$paiment){
                        $beneficiaires[$key]['isfree'] = 1;
                    }else{
                        $beneficiaires[$key]['isfree'] = 0;
                    }
			}*/

          return response()->json(compact('beneficiaires'));

      }
   }


  public function cancelKafala(Request $request){
  
	  $beneficiaire_id = $request->id;
	  
	  $user_id = auth()->user()->id;

	  //$user_id = $request->user_id;

	  $userBeneficiaire = BeneficiaireUser::where('user_id',$user_id)
		  			->where('beneficiaire_id',$beneficiaire_id)
					->where('status','validé')
					->first();
		
	  if($userBeneficiaire == null){


		  return response()->json(["message"=>"kafala not found"],404);


	  }else{
		  
		  
		  if($userBeneficiaire->type == 0){

			  
			  $beneficiaire = Beneficiaire::find($beneficiaire_id);

			  if($beneficiaire){

			  	$beneficiaire->isfree = 1;

				$beneficiaire->save();

				//return response()->json(["message"=>"success"],200);
			  
			  }else{

			       return response()->json(["message"=>"beneficiaire not found"],404);
			  
			  }	
			                 

		  }else{
		  

		  $count = BeneficiaireUser::where('beneficiaire_id',$beneficiaire_id)->where('status','validé')->where('type',1)->count();
		  //return $count;	
		  if($count == 1 ){




			  $beneficiaire = Beneficiaire::find($beneficiaire_id);

			   if($beneficiaire){

                          	$beneficiaire->isfree = 1;

                          	$beneficiaire->save();

			   //return response()->json(["message"=>"success"],200);

                          }else{

                               return response()->json(["message"=>"beneficiaire not found"],404);

                          }
		  }


		 
		  
		  
		  
		  
		  }

		  $userBeneficiaire->status = "terminé";

		  $userBeneficiaire->date_fin = Carbon::now();
		  
                  $userBeneficiaire->save();

                  return response()->json(["message"=>"success"],200);

	  }
  
  
  }
	
  public function changeKafala(Request $request){

          $beneficiaire_id = $request->id;

          $user_id = auth()->user()->id;

          $montant = $request->montant;

          $userBeneficiaire = BeneficiaireUser::where('user_id',$user_id)
                                        ->where('beneficiaire_id',$beneficiaire_id)
                                        ->where('status','validé')
                                        ->first();

          if($userBeneficiaire == null){


                  return response()->json(["message"=>"kafala not found"],404);


          }else{


             

                  $userBeneficiaire->montant = $montant;

                  $userBeneficiaire->save();

                  return response()->json(["message"=>"success"],200);

          }


  }






  public function getBeneficiaires_auth(Request $request)
  {
	  $label = $request->label;

	  $user = auth()->user();
	  
	//  $user = User::find(2333);
	  	
	  
	  $language = Language::where('label','=',$label)->first();
	  
	  if($language)
     	{

			/*$beneficiaires = Beneficiaire::with(['images_beneficiaire', 'walls_beneficiaire' => function($q) use($language) {

	          $user = auth()->user();				$q->where('language_id', '=', $language->id);
				}])
				->join('beneficiaire_translate','beneficiaires.id','=','beneficiaire_translate.beneficaire_id')
				->select('beneficiaires.id','age',"city",'last_name','first_name','image_blur as image',"birthday","sex","dream","father_name","nb_likes as like", 'death_date', 'father_birthday', 'isfree')
				->where('beneficiaire_translate.language_id','=',$language->id)
				->where('isfree',1);*/
	
			$beneficiaires = Beneficiaire::with(['images_beneficiaire', 'walls_beneficiaire' , 'notes_beneficiaire' ,'handicape_beneficiaire'=> function($q) use($language) {

                                        $q->where('language_id', '=', $language->id);
                                }])
                                        ->join('beneficiaire_translate','beneficiaires.id','=','beneficiaire_translate.beneficaire_id')
                                        ->join('cities','cities.id','beneficiaires.city_id')
                                        ->join('cities_translate','cities_translate.city_id','cities.id')
					->select('beneficiaires.id','age',"last_name",'first_name','cities_translate.label as city',"beneficiaires.type",'image_blur as image',"birthday","sex","dream","father_name","nb_likes as like", 'death_date', 'father_birthday', 'isfree','handicape')
					/*->select('beneficiaires.id','age',"city",'last_name','first_name','image',"biography","dream",
						"father_name","mother_name","leisure","address","school_level","birthday","sex","weight","length","Last_school_note","nb_likes as like", 'death_date', 'father_birthday', 'isfree','beneficiaires.type','mother_death_date','house_price','handicape')*/
                                ->where('beneficiaire_translate.language_id','=',$language->id)
                                ->where('cities_translate.language_id',$language->id)
				->where('isfree',1)
				->where('beneficiaires.handicape',0)
				/*->orWhere("beneficiaire_translate.dream",'like',"%".$user->description."%")
				->sortByDesc()*/;
	
	
		if(isset($request->termsearch) && !empty($request->termsearch) ){

				$term_search = $request->termsearch;
                $beneficiaires = $beneficiaires->where(function ($beneficiaires) use ($term_search) {
                        $beneficiaires->where('first_name', 'like', "%".$term_search."%")
                              ->orWhere('last_name', 'like',"%".$term_search."%")
                              ->orWhere('biography', 'like',"%".$term_search."%")
                              ->orWhere('dream', 'like',"%".$term_search."%")
                              ->orWhere('leisure', 'like',"%".$term_search."%")
                              ->orWhere('address', 'like',"%".$term_search."%")
			      ->orWhere('city', 'like',"%".$term_search."%")
			      ->orWhere('school_level', 'like',"%".$term_search."%")
			      ->orWhere('last_school_name', 'like',"%".$term_search."%")
			      ->orWhere('age', 'like',"%".$term_search."%")
			      
			      
			      ;
                    });
			}
			
			/*if(isset($request->like) && $request->like == 1 ){
				$beneficiaires = $beneficiaires->where('isfree', '=', 0);
			}
			else{
				$beneficiaires = $beneficiaires->where('isfree', '=', 1);
				$beneficiaires = $beneficiaires->inRandomOrder();
				//$beneficiaires = $beneficiaires->orderBy('beneficiaires.created_at', 'desc');
			}*/




			/*
			if(isset($request->likes) && $request->likes == 1 ){
				$beneficiaires = $beneficiaires->orderBy('nb_likes', 'desc');
			}else{
				$beneficiaires = $beneficiaires->orderBy('beneficiaires.created_at', 'desc');
			}*/
			$beneficiaires = $beneficiaires->paginate(100);
			/*
			foreach ($beneficiaires as $key => $beneficiaire) {
					$beneficiaire_user = UserBeneficiaireLike::where('user_id','=',auth()->user()->id)->where('beneficiaire_id','=',$beneficiaire->id)->first();
                    if(!$beneficiaire_user){
                        $beneficiaires[$key]['like'] = 0;
                    }else{
                        $beneficiaires[$key]['like'] = 1;
                    }

					$paiment = BeneficiaireUser::where('beneficiaire_user.beneficiaire_id','=', $beneficiaire->id)
						->where('beneficiaire_user.status', '!=', 'annulé')->first();
                    if(!$paiment){
                        $beneficiaires[$key]['isfree'] = 1;
                    }else{
                        $beneficiaires[$key]['isfree'] = 0;
                    }

			}*/

          return response()->json(compact('beneficiaires'));

      }
  }
  public function historiquePaiement(Request $request)
  {
	$paiements = Paiement::select('id','montant',"date_paiement",'type')
				->where('user_id','=',auth()->user()->id)
				->where('status','=','approved')
				->orderBy('paiements.created_at', 'desc');

	$paiements = $paiements->paginate(5);


    return response()->json(compact('paiements'));
  }

  public function paiement(/*Request $request*/)
  {
    $paiment = BeneficiaireUser::where('beneficiaire_user.user_id','=',auth()->user()->id)
				->where('beneficiaire_user.status','=','validé')
				->where('beneficiaire_user.date_fin','<=',Carbon::now())
				->sum('montant');

	return response()->json(compact('paiment'));
  }

  public function getBeneficiaires_pris_en_charge(Request $request)
  {
     	$label = $request->label;
     	$language = Language::where('label','=',$label)->first();
     	if($language)
     	{

			$beneficiaires = Beneficiaire::with(['images_beneficiaire', 'walls_beneficiaire', 'notes_beneficiaire','handicape_beneficiaire' => function($q) use($language) {
					$q->where('language_id', '=', $language->id);
				}])
				->join('beneficiaire_translate','beneficiaires.id','=','beneficiaire_translate.beneficaire_id')
				->join('beneficiaire_user','beneficiaires.id','=','beneficiaire_user.beneficiaire_id')
				->join('cities','cities.id','=','beneficiaires.city_id')
                                ->join('cities_translate','cities.id','=','cities_translate.city_id')
				->select('beneficiaires.id','age',"cities_translate.label as city",'last_name','first_name','image',"biography","dream","beneficiaires.type",
				"father_name","mother_name","leisure","address","school_level","birthday","sex","weight","length","Last_school_note","nb_likes as like","status", 'death_date', 'father_birthday', 'isfree','beneficiaires.type','mother_death_date','house_price','handicape')
				->where('beneficiaire_translate.language_id', '=', $language->id)
				->where('beneficiaire_user.user_id', '=',auth()->user()->id)
				->where('cities_translate.language_id',$language->id)
				->where('beneficiaire_user.status', '=', 'validé')
				->orderBy('beneficiaires.created_at', 'desc');

			$beneficiaires = $beneficiaires->paginate(1000);
			/*
			foreach ($beneficiaires as $key => $beneficiaire) {
					$beneficiaire_user = UserBeneficiaireLike::where('user_id','=',auth()->user()->id)->where('beneficiaire_id','=',$beneficiaire->id)->first();
                    if(!$beneficiaire_user){
                        $beneficiaires[$key]['like'] = 0;
                    }else{
                        $beneficiaires[$key]['like'] = 1;
                    }


					$paiment = BeneficiaireUser::where('beneficiaire_user.beneficiaire_id','=', $beneficiaire->id)->first();
                    if(!$paiment){
                        $beneficiaires[$key]['isfree'] = 1;
                    }else{
                        $beneficiaires[$key]['isfree'] = 0;
                    }
			}*/

          return response()->json(compact('beneficiaires'));
      }
  }
  public function favoris(Request $request)
  {
     	$label = $request->label;
		$user = auth()->user();
     	$language = Language::where('label','=',$label)->first();
     	if($language)
     	{

			$beneficiaires = Beneficiaire::with(['images_beneficiaire', 'walls_beneficiaire'  , 'notes_beneficiaire' ,'handicape_beneficiaire'=> function($q) use($language) {

					$q->where('language_id', '=', $language->id);
				}])
				->join('beneficiaire_translate','beneficiaires.id','=','beneficiaire_translate.beneficaire_id')
				->join('user_beneficiaire_like','beneficiaires.id','=','user_beneficiaire_like.beneficiaire_id')
				->select('beneficiaires.id','age',"city",'last_name','first_name','image_blur as image',"biography","dream","beneficiaires.type",
				"father_name","mother_name","leisure","address","school_level","birthday","sex","weight","length","Last_school_note","nb_likes as like", 'death_date', 'father_birthday', 'isfree','handicape')
				->where('beneficiaire_translate.language_id','=',$language->id)
				->where('user_beneficiaire_like.user_id','=',$user->id);
			if(isset($request->likes) && $request->likes == 1 ){
				$beneficiaires = $beneficiaires->orderBy('nb_likes', 'desc');
			}else{
				$beneficiaires = $beneficiaires->orderBy('beneficiaires.created_at', 'desc');
			}
			$beneficiaires = $beneficiaires->paginate(10);
			/*
			foreach ($beneficiaires as $key => $beneficiaire) {
					$beneficiaire_user = UserBeneficiaireLike::where('user_id','=',auth()->user()->id)->where('beneficiaire_id','=',$beneficiaire->id)->first();
                    if(!$beneficiaire_user){

                        $beneficiaires[$key]['like'] = 0;
                    }else{
                        $beneficiaires[$key]['like'] = 1;
                    }


			}
				*/
          return response()->json(compact('beneficiaires'));

      }
  }

  public function addLike(Request $request)
  {
     	    $user = auth()->user();

			$beneficiaire = Beneficiaire::where("id","=",$request->id)->first();
			$user_beneficiaire = UserBeneficiaireLike::where("beneficiaire_id","=",$request->id)->where("user_id","=",$user->id)->first();
			if($beneficiaire && !$user_beneficiaire){
				$beneficiaire->nb_likes = ($beneficiaire->nb_likes)+1;
				$beneficiaire->save();
				$user_beneficiaire = new UserBeneficiaireLike;
				$user_beneficiaire->beneficiaire_id = $request->id;
				$user_beneficiaire->user_id = $user->id;
				$user_beneficiaire->save();
				$status = TRUE;
				$message = 'like added successfully';

			}else{
				$status = False;
				$message = 'beneficiaire not found';
			}

			$data = array('status' => $status, 'message' => $message);
			return response()->json(compact('data'));


  }

  public function checkLike(Request $request)
  {
     	    $beneficiaire_user_like = UserBeneficiaireLike::where("user_id","=",auth()->user()->id)
            ->where("beneficiaire_id","=", $request->beneficiaire_id)
            ->first();

		if($beneficiaire_user_like){
                $status = true;
                $message = 'yes';
			}else{
				$status = false;
				$message = 'no';
			}

            //return $beneficiaire_user_like;
			$data = array('status' => $status, 'message' => $message);
			return response()->json(compact('data'));


  }

  public function dislike(Request $request)
  {
     	    $user = auth()->user();

			$beneficiaire = Beneficiaire::where("id","=",$request->id)->first();
			$user_beneficiaire = UserBeneficiaireLike::where("beneficiaire_id","=",$request->id)->where("user_id","=",$user->id)->first();
			if($beneficiaire && $user_beneficiaire){
				$beneficiaire->nb_likes = ($beneficiaire->nb_likes)-1;
				$beneficiaire->save();
				$user_beneficiaire->delete();
				$status = TRUE;
				$message = 'dislike successfully';

			}else{
				$status = False;
				$message = 'beneficiaire not found';
			}

			$data = array('status' => $status, 'message' => $message);
			return response()->json(compact('data'));


  }

   public function detailsBeneficiaire(Request $request)
   	{
   	$label = $request->label;
   	$beneficiaire_id = $request->beneficiaire_id;
   	$language = Language::where('label','=',$label)->first();
   	if($language)
   	{

   		$beneficiaire = DB::table('beneficiaires')
   			->join('beneficiaire_translate','beneficiaires.id','=','beneficiaire_translate.beneficaire_id')
   			->join("cities","cities.id",'beneficiaires.city_id')
   			->join('cities_translate','cities_translate.city_id','=','cities.id')
   			->select('beneficiaires.age',"cities_translate.label",'beneficiaire_translate.last_name','beneficiaire_translate.first_name','beneficiaires.image_blur as image','beneficiaire_translate.father_name','beneficiaire_translate.mother_name','beneficiaire_translate.biography','beneficiaire_translate.school_level','beneficiaire_translate.leisure','beneficiaire_translate.address','beneficiaires.Last_school_note','beneficiaires.length','beneficiaires.weight','beneficiaire_translate.dream', 'death_date', 'father_birthday', 'isfree')
   			->where("cities_translate.language_id","=",$language->id)
   			->where("beneficiaire_translate.language_id","=",$language->id)
   			->where('beneficiaires.id','=',$beneficiaire_id)->get();
/*

					$paiment = BeneficiaireUser::where('beneficiaire_user.beneficiaire_id','=', $beneficiaire->id)
						->where('beneficiaire_user.status', '!=', 'annulé')->first();
                    if(!$paiment){
                        $beneficiaire->isfree = 1;
                    }else{
                        $beneficiaire->isfree = 0;
                    }
             */
                 return response()->json(compact('beneficiaire'));

	}

   	}


	public function getWallBeneficiaire(Request $request) {
		$walls=WallsBeneficiaire::where('beneficiaire_id','=',$request->beneficiaire_id)->get();
		return response()->json(compact('walls'));
	}

	 public function getNumberAlertsNotReaded(Request $request) {
		 $notifications = Notification::where('user_id','=',auth()->user()->id)
			 ->where('lu',0)
			 ->orderBy('created_at','desc')->paginate(15)->count();
                return response()->json(compact('notifications'));
	 }
	public function readNotifications(Request $request) {
		$notifications = Notification::where('user_id','=',auth()->user()->id)->orderBy('created_at','desc')->get();
		foreach($notifications as $notif){

			$notif->lu = 1;
			$notif->save();
		}
                //return response()->json(compact('notifications'));
        }

	public function getAlerts(Request $request) {
		$notifications = Notification::where('user_id','=',auth()->user()->id)->orderBy('created_at','desc')->paginate(15);
		return response()->json(compact('notifications'));
	}

	 public function deleteAlert(Request $request) {
		 
		 $notification = Notification::find($request->notification_id);
		 if($notification!=null)
		 {
			 /*return response()->json([
                                        'value' => 'yes'
				], 200);*/
				$check = $notification->delete();
		 		if($check)
		 		
				{	return response()->json([
    					'value' => 'yes'
					], 200);
		 		
				}	
			
		 }else{

			 return response()->json([
                                        'value' => 'no'
                                        ], 404);
		 }
        }






}
