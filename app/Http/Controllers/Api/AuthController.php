<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use \Mailjet\Resources;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
//use Illuminate\Http\Response;
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
use Illuminate\Support\Facades\Log;


//---------Models--------
use App\User;
use App\Models\UserBeneficiaireMessage;
use App\Models\BeneficiaireUser;
use App\Models\Beneficiairetranslate;
use App\Models\Beneficiaire;
use App\Models\Country;
use App\Models\City;
use App\Models\Language;
use App\Models\Paiement;
use App\Models\Donation;
use App\Models\Project;
use App\Models\ActivityBenevoleInconnu;
use App\Models\ActivityBenevole;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
use LaravelFCM\Message\Topics;
use App\Models\Notification;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\PhoneVerification;

class AuthController extends Controller
{


	public function sendSMS(Request $request){


		

		//$MessageBird = new \MessageBird\Client('5RinFng4aYLMVG1l8Up9N7pxn');
		$MessageBird = new \MessageBird\Client('zXdNEh0oHO7e6E2Ep6BACjn4e');
		$Message = new \MessageBird\Objects\Message();
  		$Message->originator = 'Yatimi';
		$Message->recipients = array($request->phone);
		
		$otp = rand(11111,99999);
		
		$Message->body = 'Your verification code is : '. $otp;
		
		$phoneVerify =  new PhoneVerification;
		$phoneVerify->otp = $otp;
		$phoneVerify->number = $request->phone;
		$phoneVerify->created_at = Carbon::now();
		$phoneVerify->updated_at = Carbon::now();
                $phoneVerify->expired_at = Carbon::now()->addMinutes(10);

		
		$phoneVerify->save();


	 	$MessageBird->messages->create($Message);
		
		
	
	}
	
	public function checkOtp(Request $request){
	
		$phoneVerification = PhoneVerification::where('number',$request->phone)
			->where('expired_at','>',Carbon::now())
			->where('used',0)
			->first();

		if($phoneVerification == null){

				return response()->json(["message"=>"failed"]);

		}else{
			if($phoneVerification->otp == $request->otp){

				$phoneVerification->used = 1;
				$phoneVerification->save();
				return response()->json(["message"=>"success"]);
		
			}else{

				return response()->json(["message"=>"failed"]);
		    
			}
		
	
	             }
	
	}



	public function paginate($items, $perPage, $page, $options)
	
	{
		$page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
	
		$items = $items instanceof Collection ? $items : Collection::make($items);

		return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
	}




	

	
	
	private function distance($lat1, $lon1, $lat2, $lon2, $unit="K") {
	       
	if (($lat1 == $lat2) && ($lon1 == $lon2)) {
    		return 0;
 	 }else {
    	$theta = $lon1 - $lon2;
    	$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    	$dist = acos($dist);
    	$dist = rad2deg($dist);
    	$miles = $dist * 60 * 1.1515;
    	$unit = strtoupper($unit);

    	if ($unit == "K") {
      	return ($miles * 1.609344);
    	} else if ($unit == "N") {
      	return ($miles * 0.8684);
    	} else {
      	return $miles;
    	}
  	}
	}    

	
   public function distanceBetween(Request $request){

	   $label = $request->label;
	   $max = $request->max;
	   $lat = $request->lat;
	   $lng = $request->lng;

        $language = Language::where('label','=',$label)->first();
        if($language)
        {

                        $benef = Beneficiaire::with(['images_beneficiaire', 'walls_beneficiaire', 'notes_beneficiaire' ,'handicape_beneficiaire' => function($q) use($language) {

                                        $q->where('language_id', '=', $language->id);
                                }])
					->join('beneficiaire_translate','beneficiaires.id','=','beneficiaire_translate.beneficaire_id')
					->join('cities','cities.id','beneficiaires.city_id')
                                ->select('beneficiaires.id','age','city','first_name','image_blur as image','birthday','sex','dream','father_name', 'death_date', 'father_birthday', 'isfree','cities.lat','cities.lng')
                                //->select('beneficiaires.id','age',"city",'last_name','first_name','image',"biography","dream",
                                //"father_name","mother_name","leisure","address","school_level","birthday","sex","weight","length","Last_school_note")
				->where('beneficiaire_translate.language_id','=',$language->id)
				->where('isfree',1)
				->get();
		
	//return $benef;	
			
		$beneficiaires = collect();
		
		foreach ($benef as $b){ 
		
			
			if($this->distance($lat, $lng, $b->lat, $b->lng, 'K') < $max){
				
				$beneficiaires->push($b);

			}else{
		//					echo 'superieure';
			}
			
			
		}
		//$beneficiaires = $beneficiaires->getQuery();
		$beneficiaires = $this->paginate($beneficiaires,800,null, []);

		return response()->json(compact('beneficiaires'));
	} 
	
   }	
        public function getBeneficiairesByBrothersNumber(Request $request){

                $number = $request->number;

                $label = $request->label;



                $language = Language::where('label','=',$label)->first();
        if($language)
        {


                        $beneficiaires = Beneficiaire::with(['images_beneficiaire', 'walls_beneficiaire' , 'notes_beneficiaire' ,'handicape_beneficiaire'=> function($q) use($language) {

                                        $q->where('language_id', '=', $language->id);
                                }])
                                ->join('beneficiaire_translate','beneficiaires.id','=','beneficiaire_translate.beneficaire_id')
                                ->select('beneficiaires.id','age','city','first_name','image_blur as image','birthday','sex','dream','father_name', 'death_date', 'father_birthday', 'isfree','lat','lng')
                                //->select('beneficiaires.id','age',"city",'last_name','first_name','image',"biography","dream",
                                //"father_name","mother_name","leisure","address","school_level","birthday","sex","weight","length","Last_school_note")
				->where('beneficiaire_translate.language_id','=',$language->id)
				->where('brothers_number',$number)
				->where('isfree',1)
				;

		$beneficiaires = $beneficiaires->paginate(800);
			
              

                return response()->json(compact('beneficiaires'));
        }
	}



	public function getBeneficiairesBySchoolResults(Request $request){

	$noteMin = $request->noteMin;

        $noteMax = $request->noteMax;

	$label   = $request->label;

	//$level 	 = $request->level;
	
                $language = Language::where('label','=',$label)->first();
        if($language)
        {

                        $beneficiaires = Beneficiaire::with(['images_beneficiaire', 'walls_beneficiaire' , 'notes_beneficiaire' ,'handicape_beneficiaire'=> function($q) use($language) {

                                        $q->where('language_id', '=', $language->id);
                                }])
				->join('beneficiaire_school_results','beneficiaire_school_results.beneficiaire_id','=','beneficiaires.id')
				->join('beneficiaire_translate','beneficiaires.id','=','beneficiaire_translate.beneficaire_id')
                                ->select('beneficiaires.id','age','city','first_name','image_blur as image','birthday','sex','dream','father_name', 'death_date', 'father_birthday', 'isfree','lat','lng')
                                ->where('beneficiaire_translate.language_id','=',$language->id)
				->where('note','<=',$noteMax)
				->where('note','>=',$noteMin)
				//->where('level_categorie','=',$level)
				->where('isfree',1)
                                ;

		$beneficiaires = $beneficiaires->paginate(800);

                return response()->json(compact('beneficiaires'));
        }

	
	}


	public function getBeneficiairesBySexe(Request $request){

                $sexe = $request->sexe;

                $label = $request->label;



                $language = Language::where('label','=',$label)->first();
        if($language)
        {

                        $beneficiaires = Beneficiaire::with(['images_beneficiaire', 'walls_beneficiaire' , 'notes_beneficiaire' ,'handicape_beneficiaire'=> function($q) use($language) {

                                        $q->where('language_id', '=', $language->id);
                                }])
                                ->join('beneficiaire_translate','beneficiaires.id','=','beneficiaire_translate.beneficaire_id')
                                ->select('beneficiaires.id','age','city','first_name','image_blur as image','birthday','sex','dream','father_name', 'death_date', 'father_birthday', 'isfree','lat','lng')
                                //->select('beneficiaires.id','age',"city",'last_name','first_name','image',"biography","dream",
                                //"father_name","mother_name","leisure","address","school_level","birthday","sex","weight","length","Last_school_note")
                                ->where('beneficiaire_translate.language_id','=',$language->id)
				->where('sex',$sexe)       
				->where('isfree',1)
				;

		$beneficiaires = $beneficiaires->paginate(800);

                return response()->json(compact('beneficiaires'));
        }





        }




	public function getBeneficiairesByAge(Request $request){

		$ageMin = $request->ageMin;
		
		$ageMax = $request->ageMax;
	
		$label = $request->label;


		
		$language = Language::where('label','=',$label)->first();
        if($language)
        {

                        $beneficiaires = Beneficiaire::with(['images_beneficiaire', 'walls_beneficiaire' , 'notes_beneficiaire' ,'handicape_beneficiaire'=> function($q) use($language) {

                                        $q->where('language_id', '=', $language->id);
                                }])
                                ->join('beneficiaire_translate','beneficiaires.id','=','beneficiaire_translate.beneficaire_id')
				->select('beneficiaires.id','age','city','first_name','image_blur as image','birthday','sex','dream','father_name', 'death_date', 'father_birthday', 'isfree','lat','lng')
//->select('beneficiaires.id','age',"city",'last_name','first_name','image',"biography","dream",
                                //"father_name","mother_name","leisure","address","school_level","birthday","sex","weight","length","Last_school_note")
				->where('beneficiaire_translate.language_id','=',$language->id)
				->where('isfree',1)
				->where('age','<=',$ageMax)
				->where('age','>=',$ageMin)
                                ;



               /* $beneficiaires = collect();

                foreach ($benef as $b){

			
                        if($b->age <= $ageMax && $b->age >= $ageMin){

                                $beneficiaires->push($b);


		 }else{
                //                                      echo 'superieure';
                        }


		}*/
                $beneficiaires = $beneficiaires->paginate(800);

                return response()->json(compact('beneficiaires'));
	
	}

	



	}


 	public function sendToYatim(Request $request){


		$user = auth()->user();

 		$id = $user->id;
		
		//$id = $request->user_id;
		
		$beneficiaire_id = $request->beneficiaire_id;


		$userCheck = BeneficiaireUser::where('beneficiaire_id',$beneficiaire_id)

				->where('user_id',$id)
				->where('status','validé')	
				->first();


		if($userCheck){		

		$userBeneficiaireMessage = new UserBeneficiaireMessage;	
 	
 		$userBeneficiaireMessage->user_id = $id;
 			
		$userBeneficiaireMessage->beneficiaire_id = $beneficiaire_id;

		$userBeneficiaireMessage->message = $request->message;
 
		$userBeneficiaireMessage->save();

		return response()->json(['message'=>'success'],200);
		}
		return response()->json(['message'=>'sponsoring not found'],404);
	
	}


	 public function benevole(Request $request) {


                 
                 $user = auth()->user();
		//return response()->json(["message"=>$user],404);

                 $id = $user->id;
                 $freetime = $request->freetime;
                 $activities = $request->activities;

                 $activityBenevole = new ActivityBenevole;
                 $activityBenevole->user_id = $id;
                 $activityBenevole->activites = $request->activites;
                 $activityBenevole->freetime = $request->freetime;

                 if($activityBenevole->save()){

                         return response()->json(["message"=>"success"],200);
                 }else{

                         return response()->json(["message"=>"failure"],401);
                 }


	 }
	 public function benevoleInconnu(Request $request) {



                 
                //return response()->json(["message"=>$user],404);

                 
             
                 $activityBenevole = new ActivityBenevoleInconnu;
                 $activityBenevole->nom = $request->nom;
		 $activityBenevole->phone = $request->phone;
		 $activityBenevole->city = $request->city;
		 $activityBenevole->activites = $request->activites;
                 $activityBenevole->freetime = $request->freetime;

                 if($activityBenevole->save()){

                         return response()->json(["message"=>"success"],200);
                 }else{

                         return response()->json(["message"=>"failure"],401);
                 }


        }





  public function getCollabsWithMe(Request $request){

        $beneficiareid = $request->id;
	
	$user = auth()->user();
	
	//$user = User::whereEmail("ayoub.beltarchi@gmail.com")->first();

        $beneficiaireUser = BeneficiaireUser::where('beneficiaire_id',$beneficiareid)
			                    ->where('user_id',$user->id)
					    ->where('status','validé')
					    ->first();
	
	//return response()->json(array('user' => $beneficiaireUser));

      	if(!empty($beneficiaireUser)){

            $beneficiaireUser = BeneficiaireUser::where('beneficiaire_id',$beneficiareid)
                                ->where('status','validé')
                                ->where('type',1)
                                ->where('user_id','not like',$user->id)
                                ->get();

	    $collabs = array();
	    
	    //$beneficiaireUser =  json_decode($beneficiaireUser,true); 

	 //  	return $beneficiaireUser;
	    if(!empty($beneficiaireUser))
	   { 
            foreach($beneficiaireUser as $bene){
		
		  	//return $bene->user_id; 
		    $userCollab = User::find($bene->user_id);
		    
		    if(Carbon::parse($bene->date_fin)->greaterThan(Carbon::now())){
			    $isPayed = 1;
		    }else{		  	
			    $isPayed = 0;
		    }
		   
		    $payedTab = array('isPayed'=>$isPayed);

		    $userB = array_merge($userCollab->toArray(), $payedTab);
		   
		   //  return $userB;

                array_push($collabs,$userB);

            }

	    }             


	    return response()->json(compact('collabs')); 
       	}
    }


	public function getMetiers(Request $request){

        	$langage = $request->langue;

        	if($langage =='ar'){

            	$champLangage = 'nomAr';
                	}else if($langage =='fr'){
                    $champLangage = 'nomFr';
                        }else{
                            $champLangage = 'nomEn';

                        }

                        $metiers = DB::table('metiers')->pluck($champLangage);
                        return response()->json(compact('metiers'));
   	 }

	public function sendVerificationEmailTo(Request $request){

		if(User::where('email',$request->email)->doesntExist())
       	 {
            return view('failure')->with('message', 'user not found');

            /*return response([
                'message','user nor found'
            ],404);*/
       	 }

        	$token = Str::random(60);

            

                DB::table('email_verify')->insert([
                'email'=>$request->email,
                'token'=>$token,
                'created_at'=>Carbon::now(),
                'expired_at'=>Carbon::now()->addMinutes(10)
            ]);
		$htmlpart1="active your account <a href=";
                $htmlpart2=">here</a>";

		 $link = 'http://ataaserv.westeurope.cloudapp.azure.com/api/verifyemail/' . $token;
			
		$this->sendEmailTo($link,$request->email,$htmlpart1,$htmlpart2);
		
		return response([
            'message'=>'check your email'
            ]);
	
	    }
	
		
	public function verifyEmail(Request $request){

        $token = $request->token;

	

        $validator = Validator::make($request->all(), [
            'token'=>'required'
        ]);

       /* if ($validator->fails()) {

            return view('failure')->with('message', $validator->errors()->first());

	}*/

        if( !$verification = DB::table('email_verify')
            ->where('token','=',$token)
            ->where('expired_at','>',Carbon::now())
            ->first()
            ){

            return view('failure')->with('message', 'invalid token');
	}
	if( ! $user = User::where('email',$verification->email)->first() ){
            return view('failure')->with('message', 'user not found');
              /*return response([
                'message'=>'User not found'
            ],404);*/

        }

        $user->verifie = 1;
        $user->save();
        DB::table('email_verify')
        ->where('token', $token)
        ->update(['expired_at' =>Carbon::now() ]);
	
	return view('success');



	}
		

	private function sendEmailTo($link,$email,$htmlpart1,$htmlpart2){
	

	$mj = new \Mailjet\Client('4ed170d68d738eea3947ca0507f00582','adf5dae1bbef7ff0a89a05f8e6650ad8',true,['version' => 'v3.1']);
            $body = [
            'Messages' => [
          [
            'From' => [
              'Email' => "yatimi.store@gmail.com",
              'Name' => "Yatimi App"
            ],
            'To' => [
              [
                'Email' => $email,
                'Name' => ""
              ]
            ],
            'Subject' => "Reset your password",
            'TextPart' => "Password reset",
            'HTMLPart' => $htmlpart1.$link.$htmlpart2,
            'CustomID' => ""
                ]
            ]
            ];
            $response = $mj->post(Resources::$Email, ['body' => $body]);
            $response->success() && var_dump($response->getData());
	
	}
	
	public function forgot(Request $request){


        if(User::where('email',$request->email)->doesntExist())
        {
            return view('failure')->with('message', 'user not found');

            /*return response([
                'message','user nor found'
            ],404);*/
        }

        $token = Str::random(60);

            try{

                DB::table('password_resets')->insert([
                'email'=>$request->email,
		'token'=>$token,
		'created_at'=>Carbon::now(),
                'expired_at'=>Carbon::now()->addMinutes(10)
            ]);


            $link = 'http://165.227.80.7/reset/' . $token;

            //send Email
		$htmlpart1="change your password <a href=";
        	$htmlpart2=">here</a>";

	   $this-> sendEmailTo($link,$request->email,$htmlpart1,$htmlpart2);
           /* $mj = new \Mailjet\Client('4ed170d68d738eea3947ca0507f00582','adf5dae1bbef7ff0a89a05f8e6650ad8',true,['version' => 'v3.1']);
            $body = [
            'Messages' => [
          [
            'From' => [
              'Email' => "yatimi.store@gmail.com",
              'Name' => "Yatimi App"
            ],
            'To' => [
              [
                'Email' => $request->email,
                'Name' => ""
              ]
            ],
            'Subject' => "Reset your password",
            'TextPart' => "Password reset",
            'HTMLPart' => "change your password <a href=$link>here</a>"
            ,
            'CustomID' => ""
                ]
            ]
            ];
            $response = $mj->post(Resources::$Email, ['body' => $body]);
            $response->success() && var_dump($response->getData());
	    */

            return response([
            'message'=>'check your email'
            ]);
        }catch(\Exception $exception){
            return response([
                'message'=>$exception->getMessage()
            ],400);
        }

	}


    public function getKafalaType(Request $request){
	
	    $user = auth()->user();
		
	    //$user = User::find($request->user_id);

	    $kafala = BeneficiaireUser::
		      where('beneficiaire_id',$request->beneficiaire_id)
		    ->where('user_id',$user->id)
		    ->where('status','validé')
		    ->first();


	    if($kafala == null){

		    return response()->json(["message" => "not found"],404);
	    }else{
		    if($kafala->type == 1){

		    return response()->json(["message" => strval($kafala->type)],201);
		    
		    }
		    else{

		    return response()->json(["message" => strval($kafala->type)],200);
	    	}
	    }
	
	
	}	


    public function reset(Request $request){

        $token = $request->token;
        $password = $request->password;


        $validator = Validator::make($request->all(), [
            'password' =>  'required|string|min:6|max:16',
            'password_confirmation'=>'required|same:password',
            'token'=>'required'
        ]);

        if ($validator->fails()) {

            return view('failure')->with('message', $validator->errors()->first());

        }

        if( !$passwordreset = DB::table('password_resets')
            ->where('token','=',$token)
            ->where('expired_at','>',Carbon::now())
            ->first()
            ){

            return view('failure')->with('message', 'invalid token');

           /* return response([
                'message'=>'invalid token'
            ],400);*/

        }



        /** @var User $user */
        if( ! $user = User::where('email',$passwordreset->email)->first() ){
            return view('failure')->with('message', 'user not found');
              /*return response([
                'message'=>'User not found'
            ],404);*/

        }

        $user->password = bcrypt($password);
        $user->save();
        DB::table('password_resets')
        ->where('token', $token)
        ->update(['expired_at' =>Carbon::now() ]);
        return view('success');


    }
	
	public function saveDevice(Request $request)
	{
		$user = auth()->user();
		  	
        $user->device_token = $request->device_token;
        if($user->save()) {
                $status = TRUE;
                $message = 'token updated successfully';
        }else{
                $status = FALSE;
                $message = 'user not updated';
        }
        $data = array('status' => $status, 'message' => $message);
        return response()->json(compact('data'));
    }

	//------------login-------------------
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }


            return response()->json(compact('token'));

    }

    //---------------logout------------------
        public function logout() {

        auth()->logout();
        return response()->json(array('status' => true ));
	}


   

     public function verify(Request $request)
     {
	    $user= auth()->user();

			if($user->verifie == 0){
			
				return response()->json(array(
                    		'message'   =>  'non'
			
                		), 401);

			}

				 return response()->json(array(
                    		'message'   =>  'oui'
                		), 200);

					     	

                }



    //----------register--------------
    public function register(Request $request)
    {
	    	
		$user_test= User::where(array('email'=>$request->email))->first();
		if(!empty($user_test))
		{
			 return response()->json(array(
                    'message'   =>  'email existant'
                ), 401);
		}

		$user = new User;
        	//$user->id = $request->id;
		$user->email = $request->email;
		$user->password = bcrypt($request->password);
		$user->role_id=2;
		$user->city=(int)$request->city;
		$user->cityorigin = (int)$request->cityorigin;
		$user->country=(int)$request->country;
        	$user->lastname =$request->lastname;
        	$user->firstname =$request->firstname;
		$user->age =$request->date;
		$user->type=(int)$request->type;
		$user->adresse =$request->phone;
        	//$user->adresse =$request->adresse;
        	//$user->description = $request->description;
		$bool = $user->save();
		if($bool)
                {
                         return response()->json(array(
                    'message'   =>  'success'
                ), 200);
                }

    }


    

    /*public function profile()
    {
	    $countries = array("Maroc","France","Canada");
		
	    $cities = array("Temara","Casablanca","Rabat");

	    $user = auth()->user();
	    
	    $country = $user->country;

	    $city =$user->city;	
		  
	    $tab=$user->only('id','email','lastname','firstname','date','description','image','phone','type');

	    $data['user'] = array_merge($tab,["country"=>$countries[$country],"city"=>$cities[$city]]);
    	    		    

        return response()->json(compact('data'));
    }*/

    


    public function profile(Request $request)
    
    {	
	/*$cities = ["Rabat","Casablanca","Marrakech","Agadir"];

	$countries = ["Maroc","France","Belgique","Italie"];*/
	
	$userAuth = auth()->user();    

	//$userAuth = User::whereEmail($request->email)->first();
	
	/*$data['user']=$user1;
	return response()->json(compact('data'));*/

	 $label = $request->label;

                $language = Language::where('label','=',$label)->first();

                if($language)
                {




        $user = User::leftJoin('cities','cities.id','users.city')
                ->leftJoin('cities_translate','cities_translate.city_id','cities.id')
                ->leftJoin('countries','countries.id','users.country')
                ->leftJoin('countries_translate','countries_translate.country_id','countries.id')
                ->join('languages','languages.id','cities_translate.language_id')
                //->select('users.id','email','lastname','firstname','age','description','image','adresse','type')
                ->select('users.id','email','lastname','firstname','age','description','cities_translate.label as city','image','adresse','countries_translate.label as country','type')
                ->where('users.id','=',$userAuth->id)
                ->where('cities_translate.language_id',$language->id)
		->where('countries_translate.language_id',$language->id)
		->first();
	
	
	/*if($user == null){
		$data['user']=$user;
		             return response()->json(compact('data'));
		return response()->json(["user"=>"null"]);
	
	}*/
	
	/*$user->city=$cities[$user->city - 1];
	
	$user->country=$countries[$user->country - 1];

	//$user->country='Maroc';
	 */
	if($user->age != null){
	$user->age=substr($user->age,0,10);
	}
	if($user->type != null){
	if($user->type==1){
		$user->type = 'Employé';
		}
		if($user->type==2)
		{
		$user->type = 'Sans emploi';
		}	
	}
	$data['user']=$user;//->only('id','email','lastname','firstname','age','description','city','image','adresse','country','type');
        return response()->json(compact('data'));
		}
    }

   /*public function gettime(){

	   $user = User::whereEmail('ikitrade@live.fr')->first();
	   $tab=['time'=>$user->age];
	   return json_encode($tab);
   }*/

    public function update_profile(Request $request)
    {   $status=false;
    
    $user=auth()->user();
    
    // $user = User::whereEmail($request->email)->first();

        if(isset($request->lastname) && !empty($request->lastname))
        {
			$user->lastname=$request->lastname;
		}

        if(isset($request->firstname) && !empty($request->firstname))
        {
			$user->firstname=$request->firstname;
		}

        if(isset($request->description) && !empty($request->description))
        {
			$user->description=$request->description;
		}

		if(isset($request->age) && !empty($request->age))
		{
			$user->age=$request->age;
		}

		
	if(isset($request->city) && !empty($request->city))
        {
                $city = $request->city;

                $cities = ["Rabat","Casablanca","Marrakech","Agadir"];

                $size = sizeof($cities);

                for( $i = 0 ; $i < $size ; $i++ )
                {
                        if($city == $cities[$i]){

                        $user->city=$i+1;
			break;	
                        }


                }


        }
        if(isset($request->adresse) && !empty($request->adresse))
        {
            $user->adresse=$request->adresse;
        }

        if(isset($request->language_id) && !empty($request->language_id))
        {
			$user->language_id=$request->language_id;
		}




	if(isset($request->country) && !empty($request->country))
	{
		$country = $request->country;

		$countries = ["Maroc","France","Belgique","Italie"];

		$size = sizeof($countries);

		for( $i = 0 ; $i < $size ; $i++ )
		{
			if($country == $countries[$i]){

			$user->country=$i+1;
			break;
			}
			

		}


        }





	if(isset($request->type) && !empty($request->type))
	{
		if($request->type == 'Employé')
		{		$user->type=1;
		}
		else if($request->type == 'Sans Emploi')
                {               $user->type=2;
                }
	}




        if($user->save())
        {
            $status=true;
        }
        return response()->json(array('status'=>$status));

    }

    public function get_cities()
    {
        $cities=City::all();
        return response()->json(compact('cities'));
     }


    public function editPicture(Request $request) {
        $user = auth()->user();
        if(!empty($request->image)) {
			$pict = 'users/'.md5(uniqid(rand(), true)).'.jpg';
			$data_pic = base64_decode($request->image);
			Storage::disk('uploads')->put($pict, $data_pic);
			User::where(['id' => $user->id])->update(['image' => $pict]);
		}
        $status = True;
        $message = 'user updated picture';



        $data = array('status' => $status, 'message' => $message);
        return response()->json(compact('data'));

    }

    public function prise_en_charge(Request $request)
    {
		$beneficiaire = Beneficiaire::where("id","=",$request->beneficiaire_id)->first();
		if($beneficiaire){
            //echo 'beneficiare exists';
			$beneficiaire_user = BeneficiaireUser::where("user_id","=",auth()->user()->id)->where("beneficiaire_id","=",$request->beneficiaire_id)->first();
			if(!$beneficiaire_user){
                //echo 'beneficiare_user doesn\'t exists';
				$beneficiaire_user = new BeneficiaireUser;
				$beneficiaire_user->user_id = auth()->user()->id;
				$beneficiaire_user->beneficiaire_id = $request->beneficiaire_id;
				$beneficiaire_user->montant = $request->montant;
				$beneficiaire_user->status = 'encours';
				$beneficiaire_user->save();
				/*$paiement = new Paiement;
				$paiement->beneficiaire_user_id = $beneficiaire_user->id;
				$paiement->montant = $request->montant;
				$paiement->date_paiment = Carbon::now();
				$paiement->date_fin = Carbon::now()->addMonths(1);
				$paiement->save();*/
				$status = true;
			} else {
                $status = false;
            }
		}else{
			$status = false;
		}
        return response()->json(array('status' =>$status));
    }

	public function add_paiement(Request $request)
    {
		$paiement = new Paiement;
		$paiement->user_id = auth()->user()->id;
		$paiement->montant = $request->montant;
		$paiement->date_paiement = Carbon::now();
		$paiement->type = 'facture';
        $paiement->status = 'approved';
		$paiement->save();

        if(!empty($request->image)) {

			$pict = 'users/'.md5(uniqid(rand(), true)).'.jpg';
			$data_pic = base64_decode($request->image);

			Storage::disk('uploads')->put($pict, $data_pic);

			Paiement::where(['id' => $paiement->id])->update(['image' => $pict]);
		}

		$beneficiaires = BeneficiaireUser::where("user_id","=",auth()->user()->id)
			->where('beneficiaire_user.status','=','validé')
			->where('beneficiaire_user.date_fin','<=',Carbon::now())
			->get();
		foreach ($beneficiaires as $key => $beneficiaire) {
			$beneficiaire->date_fin = Carbon::now()->addMonths(1);
			$beneficiaire->save();
		}
		$status = true;

        return response()->json(array('status' =>$status));
    }

    public function pre_paiement(Request $request)
    {
        $paiement = new Paiement;
        $paiement->user_id = auth()->user()->id;
        $paiement->montant = $request->montant;
        $paiement->date_paiement = Carbon::now();
        $paiement->transaction_id = $request->transaction_id;
        $paiement->type = 'carte';
        $paiement->status = 'inprogress';
        $paiement->save();

        $status = true;

        return response()->json(array('status' =>$status));
    }

    public function approve_paiement(Request $request)
    {
        $storeKey = "YaT2020Mi";
        //$storeKey = "YaT2020Mi";

        Log::debug('cmi debug paiement | ' . print_r($_POST, true));
        $postParams = array();
        foreach ($_POST as $key => $value){
            array_push($postParams, $key);
        }

        natcasesort($postParams);
        $hach = "";
        $hashval = "";
        foreach ($postParams as $param){
            $paramValue = html_entity_decode(preg_replace("/\n$/","",$_POST[$param]), ENT_QUOTES, 'UTF-8');

            $hach = $hach . "(!".$param."!:!".$_POST[$param]."!)";
            $escapedParamValue = str_replace("|", "\\|", str_replace("\\", "\\\\", $paramValue));

            $lowerParam = strtolower($param);
            if($lowerParam != "hash" && $lowerParam != "encoding" ) {
                $hashval = $hashval . $escapedParamValue . "|";
            }
        }

        $escapedStoreKey = str_replace("|", "\\|", str_replace("\\", "\\\\", $storeKey));
        $hashval = $hashval . $escapedStoreKey;

        $calculatedHashValue = hash('sha512', $hashval);
        $actualHash = base64_encode (pack('H*',$calculatedHashValue));

        if(isset($_POST["HASH"])) {

            $retrievedHash = $_POST["HASH"];
	        if($retrievedHash == $actualHash && $_POST["ProcReturnCode"] == "00" )  {
	        	Log::debug('cmi debug if'.print_r($_POST['oid'],TRUE));
	        	$oid = $_POST['oid'];
	            $cmi_transactionid = $_POST['TransId'];
		            $paiement = Paiement::where('transaction_id',"=",$oid)->first();
                    $user = User::where('email', '=', $_POST['email'])->first();
                    if(!$paiement) {
                        $paiement = new Paiement;
                        $paiement->user_id = $user->id;
                        $paiement->montant = $_POST['amount'];
                        $paiement->date_paiement = Carbon::now();
                        $paiement->transaction_id = $_POST['oid'];
                        $paiement->type = 'carte';
                        //$paiement->status = 'approved';
                        //$paiement->partner_transactionid = $cmi_transactionid;
                        //$paiement->save();
                    }
		            //if($paiement){
		                $paiement->status = 'approved';
	                    $paiement->partner_transactionid = $cmi_transactionid;
                        $paiement->save();

		                $beneficiaire = BeneficiaireUser::where("user_id","=",$paiement->user_id)
		                ->where('beneficiaire_user.status','=','validé')
                        ->where('beneficiaire_user.date_fin','<=',Carbon::now())
                        ->orderBy('created_at', 'desc')
                        ->first();

                        if($beneficiaire) {

                          $beneficiaires = BeneficiaireUser::where("user_id","=",$paiement->user_id)
                            ->where('beneficiaire_user.status','=','validé')
                            ->where('beneficiaire_user.date_fin','<=',Carbon::now())
                            ->orderBy('created_at', 'desc')
                            ->get();

                            foreach ($beneficiaires as $key => $benef) {
                                $benef->date_fin = Carbon::parse($benef->date_fin)->addMonths(1);
                                //$benef->date_fin = Carbon::now()->addMonths(1);
                                $benef->save();
                            }
                            /*
                            $beneficiaire->status = "validé";
                            $beneficiaire->date_fin = Carbon::now()->addMonths(1);
                            $beneficiaire->save();*/
                        } else {
                            $beneficiaire = BeneficiaireUser::where("user_id","=",$paiement->user_id)
                                ->where('beneficiaire_user.status','=','encours')
                                ->orderBy('created_at', 'desc')
                                ->first();
                            if($beneficiaire) {
				    $beneficiaire->status = "validé";

				    $date = Carbon::now();

				    if($date->day >= 15 ){




					    $date_fin =  Carbon::now()->addMonths(2);

					    //$startDate = Carbon::now(); //returns current day
				    }else{

					    $date_fin =  Carbon::now()->addMonths(1);
				    
				    }

					    $firstDay = $date_fin->firstOfMonth();
				
				//	 $firstDay->format('Y-m-d');

				    
				$beneficiaire->date_fin = $firstDay->format('Y-m-d H:m:s');
				    //$beneficiaire->date_fin = Carbon::now()->addMonths(1);
                                $beneficiaire->save();
                            }
                        }
		                //
                        //$beneficiaire->date_fin = Carbon::now()->addMonths(1);
                        //$beneficiaire->save();
                        /*
		                foreach ($beneficiaires as $key => $beneficiaire) {
		                    $beneficiaire->date_fin = Carbon::now()->addMonths(1);
		                    $beneficiaire->save();
		                }
                        */

                        $beneficiaire = Beneficiaire::where("id","=",$beneficiaire->beneficiaire_id)->first();
                        if($beneficiaire->isfree == 1) {
                            //$this->sendNotification($title, $description, $paiement->user_id);
                            $beneficiaire->isfree = 0;
                            $beneficiaire->save();

                            $user_id = $user->id;
                            //$beneficiaire = Beneficiaire::where("id","=", $user_beneficiaire->beneficiaire_id)->first();
                            $beneficiaire_ar = Beneficiairetranslate::where('beneficaire_id', '=', $beneficiaire->id)->where('language_id', '=', 2)->first();
                            //$beneficiaire_ar->first_name;
                            $title = "تأكيد الكفالة";
                            $description = sprintf("لقد تمت كفالتكم لليتيم(ة) %s بنجاح، هنيئا لكم هذا الفضل.", $beneficiaire_ar->first_name);

                            //echo $title . " " . $description . " \n";
                            $this->sendNotification($title, $description, $user_id);
                        }
		        	//}
	            //  "Il faut absolument verifier toutes les informations envoyées par MTC (requete server-to-server) avec les données du site avant de procéder à la confirmation de la transaction!"
	            //  "Par exemple le montant envoyé dans la requête de MTC doit correspondre exactement au montant de la commande enregistré dans la BDD du site marchand.
	            //  "Mettre à jour la base de données du site marchand en vérifiant si la commande existe et correspond au retour MTC!"
	            //  "Dans cette MAJ, il faut enregistrer le n° du Bon de commande de paiement envoyé dans le paramètre ""orderNumber"" "

	               echo "ACTION=POSTAUTH";
	        }else {
	        		Log::debug('cmi debug else');

	               echo "ERREUR CMI";
	        }
		}else {
	        Log::debug('cmi debug else');

	        echo "ERREUR CMI";    }
    }


    public function test(){

	    $startDate = Carbon::now(); 
	//    return $startDate;
	$firstDay = $startDate->firstOfMonth();
	//return $firstDay;
   return $firstDay->format('Y-m-d H:m:s');
    }



    public function testNotification(Request $request) {
        //
        /*
        $users_beneficiaires = BeneficiaireUser::where('beneficiaire_user.status','=','validé')->get();
        foreach ($users_beneficiaires as $user_beneficiaire) {
            $user_id = $user_beneficiaire->user_id;
            $beneficiaire = Beneficiaire::where("id","=", $user_beneficiaire->beneficiaire_id)->first();
            $beneficiaire_ar = Beneficiairetranslate::where('beneficaire_id', '=', $beneficiaire->id)->where('language_id', '=', 2)->first();
            //$beneficiaire_ar->first_name;
            $title = "تأكيد الكفالة";
            $description = sprintf("لقد تمت كفالتكم لليتيم %s بنجاح، هنيئا لكم هذا الفضل.", $beneficiaire_ar->first_name);

            //echo $title . " " . $description . " \n";
            //$this->sendNotification($title, $description, $user_id);
        }*/
        //echo "ACTION=POSTAUTH";
        //echo "APPROVED";

        $payment_pending = BeneficiaireUser::where('beneficiaire_user.status','=','validé')
                ->where('beneficiaire_user.user_id','=',42)
                ->where('beneficiaire_user.date_fin','<=',Carbon::now())
                ->first();

        $new_date = Carbon::parse($payment_pending->date_fin)->addMonths(1);
            dd($new_date);
        return response()->json(compact('payment_pending'));
    }

    public function paymentReminder(Request $request) {

        $payment_pending = BeneficiaireUser::where('beneficiaire_user.status','=','validé')
                ->where('beneficiaire_user.date_fin','<=',Carbon::now())
                ->where('beneficiaire_user.user_id',"=",auth()->user()->id)
                ->select('beneficiaire_user.user_id')
                ->distinct()
                ->get();

        foreach ($payment_pending as $payment) {

            $title = "أداء كفالة";
            $description = 'يمكنكم أداء كفالة هذا الشهر من خلال الدخول إلى "الكفالات المدفوعة" عن طريق حسابكم على التطبيق.';
            //echo $title . " " . $description . " \n";
            //$this->sendNotification($title, $description, 455, false);
            $this->sendNotification($title, $description, $payment->user_id, true);

        }

        return response()->json(compact('payment_pending'));
    }

    public function sendNotification($title, $description, $user_id, $saving=true) {
        if($saving) {
            $notification = new Notification;
            $notification->user_id = $user_id;
            $notification->title = $title;
            $notification->description = $description;
            $notification->save();
        }

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($description)
                                ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['title'=>$title,'description' => $description]);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        if($user_id != 0) {
            $user = User::select('device_token')->where('id','=',$user_id)->first();
            $token = $user->device_token;
            if($token) {
                $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);
            }
        }
    }

    /*public function approve_donation(Request $request) {
        $storeKey = "YaT2020Mi";

        Log::debug('cmi debug donation | ' . print_r($_POST, true));
        $postParams = array();
        foreach ($_POST as $key => $value){
            array_push($postParams, $key);
        }

        natcasesort($postParams);
        $hach = "";
        $hashval = "";
        foreach ($postParams as $param){
            $paramValue = html_entity_decode(preg_replace("/\n$/","",$_POST[$param]), ENT_QUOTES, 'UTF-8');

            $hach = $hach . "(!".$param."!:!".$_POST[$param]."!)";
            $escapedParamValue = str_replace("|", "\\|", str_replace("\\", "\\\\", $paramValue));

            $lowerParam = strtolower($param);
            if($lowerParam != "hash" && $lowerParam != "encoding" ) {
                $hashval = $hashval . $escapedParamValue . "|";
            }
        }


        $escapedStoreKey = str_replace("|", "\\|", str_replace("\\", "\\\\", $storeKey));
        $hashval = $hashval . $escapedStoreKey;

        $calculatedHashValue = hash('sha512', $hashval);
        $actualHash = base64_encode (pack('H*',$calculatedHashValue));

        if(isset($_POST["HASH"])) {
            $retrievedHash = $_POST["HASH"];
            if($retrievedHash == $actualHash && $_POST["ProcReturnCode"] == "00" )  {
                //Log::debug('cmi debug if'.print_r($_POST['oid'],TRUE));
                $project = Project::where('status', '=', 'open')->first();

                $oid = $_POST['TransId'];
                $amount = $_POST['amount'];
                $currency = $_POST['currency'];

                $donation = new Donation;
                $donation->transaction_id = $oid;
                $donation->montant = $amount;
                $donation->currency = $currency;
                $donation->email = $_POST['email'];
                if($project) {
                    $donation->project_id = $project->id;
                    $project->collected = $project->collected + $amount;
		    $project->save();


		    if($project->collected >= $project->needed){

			    $donations = Donation::where('project_id',$project->id)->distinct('email')->get();
			    
			    foreach($donations as $donation){
				    $title = "ﺃﺩﺍﺀ ﻚﻓﺎﻟﺓ";
            			    $description = 'ﻲﻤﻜﻨﻜﻣ ﺃﺩﺍﺀ ﻚﻓﺎﻟﺓ ﻩﺫﺍ ﺎﻠﺸﻫﺭ ﻢﻧ ﺥﻼﻟ ﺎﻟﺪﺧﻮﻟ ﺈﻟﻯ "ﺎﻠﻜﻓﺍﻼﺗ ﺎﻠﻣﺪﻓﻮﻋﺓ" ﻊﻧ ﻁﺮﻴﻗ ﺢﺳﺎﺒﻜﻣ ﻊﻟﻯ ﺎﻠﺘﻄﺒﻴﻗ.';
            
				    $user = User::whereEmail($donation->email)->first();
				    $this->sendNotification($title, $description, $user->id, true);
			    			    
			    }

		    }
                }
                $donation->save();
                //  "Il faut absolument verifier toutes les informations envoyées par MTC (requete server-to-server) avec les données du site avant de procéder à la confirmation de la transaction!"
                //  "Par exemple le montant envoyé dans la requête de MTC doit correspondre exactement au montant de la commande enregistré dans la BDD du site marchand.
                //  "Mettre à jour la base de données du site marchand en vérifiant si la commande existe et correspond au retour MTC!"
                //  "Dans cette MAJ, il faut enregistrer le n° du Bon de commande de paiement envoyé dans le paramètre ""orderNumber"" "

                echo "ACTION=POSTAUTH";
                return;
            }
        }
        Log::debug('cmi debug else');
        echo "Erreur";
    }*/

    public function approve_donation(Request $request) {
        $storeKey = "YaT2020Mi";
    
        Log::debug('cmi debug donation | ' . print_r($_POST, true));
        $postParams = array();
        foreach ($_POST as $key => $value){
            array_push($postParams, $key);              
        }
        
        natcasesort($postParams);       
        $hach = "";
        $hashval = "";                  
        foreach ($postParams as $param){                
            $paramValue = html_entity_decode(preg_replace("/\n$/","",$_POST[$param]), ENT_QUOTES, 'UTF-8'); 

            $hach = $hach . "(!".$param."!:!".$_POST[$param]."!)";
            $escapedParamValue = str_replace("|", "\\|", str_replace("\\", "\\\\", $paramValue));   
                
            $lowerParam = strtolower($param);
            if($lowerParam != "hash" && $lowerParam != "encoding" ) {
                $hashval = $hashval . $escapedParamValue . "|";
            }
        }
        
        
        $escapedStoreKey = str_replace("|", "\\|", str_replace("\\", "\\\\", $storeKey));   
        $hashval = $hashval . $escapedStoreKey;
        
        $calculatedHashValue = hash('sha512', $hashval);  
        $actualHash = base64_encode (pack('H*',$calculatedHashValue));
        
        if(isset($_POST["HASH"])) {
            $retrievedHash = $_POST["HASH"];
            if($retrievedHash == $actualHash && $_POST["ProcReturnCode"] == "00" )  {
                //Log::debug('cmi debug if'.print_r($_POST['oid'],TRUE));
                $project = Project::where('status', '=', 'open')->first();

                $oid = $_POST['TransId'];
                $amount = $_POST['amount'];
                $currency = $_POST['currency'];

                $donation = new Donation;
                $donation->transaction_id = $oid;
                $donation->montant = $amount;
                $donation->currency = $currency;
                $donation->email = $_POST['email'];
                if($project) {
                    $donation->project_id = $project->id;
                    $project->collected = $project->collected + $amount;
                    $project->save();
                }
                $donation->save();
                //  "Il faut absolument verifier toutes les informations envoyées par MTC (requete server-to-server) avec les données du site avant de procéder à la confirmation de la transaction!"
                //  "Par exemple le montant envoyé dans la requête de MTC doit correspondre exactement au montant de la commande enregistré dans la BDD du site marchand.
                //  "Mettre à jour la base de données du site marchand en vérifiant si la commande existe et correspond au retour MTC!"
                //  "Dans cette MAJ, il faut enregistrer le n° du Bon de commande de paiement envoyé dans le paramètre ""orderNumber"" "
                
                echo "ACTION=POSTAUTH";  
                return;
            }
        }
        Log::debug('cmi debug else');
        echo "Erreur";
    }
    
    
    
    
    
    
    public function updatepass(Request $request) {


            $user = User::where('code', '=', $request->code)
                    ->where('email', '=', $request->email)
                    ->whereRaw('`date_expired` >"'.Carbon::now().'"')->first();

            if(!empty($user)) {

                $user->password = bcrypt($request->password);

                $user->date_expired = Carbon::now();
                if($user->save())
                    return response()->json(['status' => 1]);
                else
                    return response()->json(['status' => 0]);
            } else {
                return response()->json(['status' => 0]);
            }
    }

    public function resetpass(Request $request)
    {

        $user = User::where(array('email' => $request->email))->first();

        if(!empty($user)) {

            $code= $request->code;
            $user->code =$code;
            $now = new DateTime();
            $tomorrow = $now->add(new DateInterval('P1D'));
            $user->date_expired = $tomorrow;
            $user->save();

            Mail::send('email', ['name' => $user->firstname, 'email' => $user->email, 'code' => $code], function ($m) use ($user,$code) {

                            $name = $user->firstname;


                                 $m->from(config('constants.MAIL_FROM'), 'yatimi ');

                                 $m->to($user->email, $name)->subject('Yatimi - activate your account');

                                 $m->getSwiftMessage()
                                   ->getHeaders()
                                   ->addTextHeader('X-MailjetLaravel-Template', config('constants.TMPL_ID_PASSWORD'));

                           $link ="yatimi://yatimi.com/resetpass/code/".$code."?email=".$user->email."";

                            $variable = json_encode(['link' => $link,'email'=>$user->email]);
                            $m->getSwiftMessage()
                            ->getHeaders()
                            ->addTextHeader('X-MailjetLaravel-TemplateBody', $variable);
                        });
            return response()->json(['message' => 'Email was sent to the user']);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }

	public function facebook_google_LoginRegister(Request $request)
    {
                    if(isset($request->provider) && !empty($request->provider) && isset($request->provider_id) && !empty($request->provider_id)){

                        $provider_id = $request->provider_id;
                        if($request->provider == 'facebook'){
                            $profile = file_get_contents('https://graph.facebook.com/v3.2/me?fields=email,last_name,first_name,picture.type(large)&access_token=' . $provider_id);
                        }else{
				if($request->provider == 'google'){
					//$birth = file_get_contents("https://www.googleapis.com/auth/user.birthday.read?access_token=".$provider_id);
                                $profile = file_get_contents('https://www.googleapis.com/oauth2/v3/userinfo?access_token=' . $provider_id);
                            }
                        }

						$profile = json_decode($profile);

			//return response()->json(["profile"=>$birth],401);
                    if($profile) {

                        if(isset($profile->email)) {

                                $user_test = User::where(array('email' => $profile->email))
                                            //->where(array('provider' => $request->provider))
                                            ->first();
                                if(!empty($user_test)){
                                    //$profile2 = 'https://www.googleapis.com/auth/userinfo.profile?access_token=' . $provider_id;
                                    //Log::debug('google oauth profile | ' . $profile2);
                                    Auth::loginUsingId($user_test->id);
                                    $token = JWTAuth::fromUser(Auth::user());
                                    $user_test = Auth::user();
                                    if(empty($user_test->firstname)) {
                                        $user_test->lastname = isset($profile->family_name)? $profile->family_name : "";
                                        $user_test->firstname = isset($profile->given_name)? $profile->given_name : "";
                                        if(isset($profile->picture) && !empty($profile->picture)) {
                                            $picture = $profile->picture;
                                            $contents = file_get_contents($picture);
                                            $name = 'users/'.md5(uniqid(rand(), true)).'.jpg';
                                            Storage::disk('uploads')->put($name, $contents);
                                            $user_test->image = $name;
                                        }
                                        $user_test->save();
                                    }
                                    return response()->json(compact('token'));
                                }else{
                                            $user_test = new User;
                                            $user_test->email = $profile->email;
                                            if($request->provider == 'facebook'){
                                                $user_test->lastname = $profile->last_name;
                                                $user_test->firstname = $profile->first_name;
                                                $picture = $profile->picture->data->url;
                                                $contents = file_get_contents($picture);
                                                $name = 'users/'.md5(uniqid(rand(), true)).'.jpg';
                                                Storage::disk('uploads')->put($name, $contents);
                                                $user_test->image = $name;
                                                $user_test->provider_id = $profile->id;

                                            }else{
                                                $user_test->lastname = $profile->family_name;
                                                $user_test->firstname = $profile->given_name;
                                                if(isset($profile->picture) && !empty($profile->picture)) {
                                                    $picture = $profile->picture;
                                                    $contents = file_get_contents($picture);
                                                    $name = 'users/'.md5(uniqid(rand(), true)).'.jpg';
                                                    Storage::disk('uploads')->put($name, $contents);
                                                    $user_test->image = $name;
                                                }
                                                $user_test->provider_id = $profile->sub;
                                                //$user_test->lastname = "";
                                                //$user_test->firstname = "";
					    }
					    

                                            $user_test->role_id = 2;
                                            $user_test->city = "";
                                             
                                            $user_test->adresse = "";
                                            $user_test->description = "";
					    $user_test->age = Carbon::now()->toDateTimeString();
					    $user_test->type=1;
                                            $user_test->provider = $request->provider;

                                            $user_test->save();
                                            Auth::loginUsingId($user_test->id);
                                            $token = JWTAuth::fromUser(Auth::user());
                                            return response()->json(compact('token'));

                                            }
                                        }
                                }


                    }
                    else{$token=false;
                        return response()->json(array('token' => $token));
                    }
    }
}
