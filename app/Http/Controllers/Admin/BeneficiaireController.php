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
use App\Models\BeneficiaireAssoc;
use App\Models\Beneficiairetranslate;
use App\Models\Photo;
use App\Models\PhotoAssoc;
use App\Models\Association;
use App\Models\WallsBeneficiaire;
use App\Models\WallsBeneficiaireAssoc;
use PDF;
use App\Models\BeneficiaireEcole;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
use LaravelFCM\Message\Topics;
use App\Models\Notification;

//use Intervention\Image\Image;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\BeneficiaireUser;
use App\Models\BeneficiaireHandicape;
use App\Models\BeneficiaireHandicapeTranslate;
use App\User;
use App\Http\Controllers\Admin\Export;
use App\Http\Controllers\Admin\Export2;
use App\Http\Controllers\Admin\Export3;
use App\Models\City;
class BeneficiaireController extends Controller
{
    
	public function notification($id){
	
		$beneficiaire = Beneficiaire::find($id);	
		return view('dashboard', $beneficiaire);
	
	}








	public function index(Request $request)
    {
		
	    $beneficiaires = Beneficiaire::with(['images_beneficiaire', 'walls_beneficiaire','beneficiaire_translate'])
		    ->join('cities','cities.id','beneficiaires.city_id')
		    ->select('beneficiaires.id','beneficiaires.sex','beneficiaires.handicape','cities.label')
		    ->orderBy('beneficiaires.id', 'DESC')->get();
//	return $beneficiaires;	
		$beneficiairesNonParraines = Beneficiaire::with(['images_beneficiaire', 'walls_beneficiaire','beneficiaire_translate'])
			->where('beneficiaires.isfree',1)
			->orderBy('id', 'ASC')
			->get();	
		$beneficiairesParraines = Beneficiaire::with(['images_beneficiaire', 'walls_beneficiaire','beneficiaire_translate'])
			->orderBy('id', 'ASC')->where('beneficiaires.isfree',0)
						                        ->get();

		return view('beneficiaire.list', compact(['beneficiaires','beneficiairesParraines','beneficiairesNonParraines']));
        
        
	}

	public function index2(Request $request){

		$beneficiaires = Beneficiaire::with(['images_beneficiaire', 'walls_beneficiaire','beneficiaire_translate'])
			->join('cities','cities.id','beneficiaires.city_id')
                    	->select('beneficiaires.id','beneficiaires.sex','beneficiaires.handicape','cities.label')
                        ->where('beneficiaires.isfree',1)
                        ->orderBy('id', 'ASC')
                        ->get();
	
		 return view('beneficiairenonparraine.list', compact('beneficiaires'));
	
	}
	 public function index3(Request $request){

                 $beneficiaires = Beneficiaire::with(['images_beneficiaire', 'walls_beneficiaire','beneficiaire_translate'])
			  ->join('cities','cities.id','beneficiaires.city_id')
        	          ->select('beneficiaires.id','beneficiaires.sex','beneficiaires.handicape','cities.label')
			 ->orderBy('id', 'ASC')->where('beneficiaires.isfree',0)
                                                                        ->get();

                 return view('beneficiaireparraine.list', compact('beneficiaires'));

        }


	public function index4(Request $request){

		$beneficiaires = Beneficiaire::with(['images_beneficiaire', 'walls_beneficiaire','beneficiaire_translate'])
			 ->join('cities','cities.id','beneficiaires.city_id')
                         ->select('beneficiaires.id','beneficiaires.sex','beneficiaires.handicape','cities.label')
                         ->orderBy('id', 'ASC')->where('handicape',1)
                                                                        ->get();

                 return view('beneficiairehandicaps.list', compact('beneficiaires'));

	}

	public function wallsedit($id){

		$wallsAssoc = WallsBeneficiaireAssoc::find($id);

		if($wallsAssoc){

			return view("nouveautesencours.edit", compact('wallsAssoc'));

	
		}
	}




	public function wallsvalidate($id){

		$wallsAssoc = WallsBeneficiaireAssoc::find($id);

		if($wallsAssoc){
		

			if($wallsAssoc->deleted == 0)
		
			{

				$walls = new WallsBeneficiaire;
				$walls->title = $wallsAssoc->title;
				$walls->description = $wallsAssoc->description;
				$walls->image = $wallsAssoc->image;
				$walls->type = $wallsAssoc->type;
				$walls->beneficiaire_id = $wallsAssoc->beneficiaire_id;
				$walls->language_id = 2;
				$walls->save();


			
			}else if($wallsAssoc->deleted == 1){
			

				$walls = WallsBeneficiaire::find($id);
				$walls->delete();
			
			}
		

			$wallsAssoc->validated = 1;
			$wallsAssoc->save();
		
			return redirect("/admin/nouveautesencours");	
		
		}
	
	
	}


	 public function mediavalidate($id){

                $wallsAssoc = PhotoAssoc::find($id);

                if($wallsAssoc){


                        if($wallsAssoc->deleted == 0)

                        {

                                $walls = new Photo;
                                
                                $walls->link = $wallsAssoc->link;
                                $walls->type = $wallsAssoc->type;
                                $walls->beneficiaire_id = $wallsAssoc->beneficiaire_id;

                                $walls->save();



                        }else if($wallsAssoc->deleted == 1){


                                $walls = Photo::find($id);
                                $walls->delete();

                        }


                        $wallsAssoc->validated = 1;
                        $wallsAssoc->save();

                        return redirect("/admin/nouveautesencours");

                }



	 }

	public function mediadelete($id){

		$mediaAssoc = PhotoAssoc::find($id);
		
		if($mediaAssoc) {$mediaAssoc->delete();return redirect('/admin/nouveautesencours');}
	
	
	}
	
	public function wallsdelete($id){
	

		$wallsAssoc = WallsBeneficiaireAssoc::find($id);

		if($wallsAssoc){ $wallsAssoc->delete();return redirect('/admin/nouveautesencours');}
	
	
	}	




	/*public function beneficiairevalidate($id){


		$beneficiaire = Beneficiaire::find($id);

		$beneficiaireAssoc = BeneficiaireAssoc::find($id);

		if($beneficiaireAssoc){


			if(!$beneficiaire)
			{

				$beneficiaire = new Beneficiaire;
			}
			
                                $beneficiaire->birthday = $beneficiaireAssoc->birthday;
				$beneficiaire->sex = $beneficiaireAssoc->sex;
				$beneficiaire->weight = $beneficiaireAssoc->weight;
				$beneficiaire->length = $beneficiaireAssoc->length;
				$beneficiaire->image = $beneficiaireAssoc->image;
				$beneficiaire->image_blur = $beneficiaireAssoc->image_blur;
				$beneficiaire->nb_likes = $beneficiaireAssoc->nb_likes;
				$beneficiaire->association_id = $beneficiaireAssoc->association_id;
				$beneficiaire->mother_phone = $beneficiaireAssoc->mother_phone;
				$beneficiaire->mother_death_date = $beneficiaireAssoc->mother_death_date;
				$beneficiaire->brothers_number = $beneficiaireAssoc->brothers_number;
				$beneficiaire->father_birthday = $beneficiaireAssoc->father_birthday;
				$beneficiaire->death_date = $beneficiaireAssoc->death_date;
				$beneficiaire->isfree = $beneficiaireAssoc->isfree;
				$beneficiaire->Last_school_note = $beneficiaireAssoc->Last_school_note;
				$beneficiaire->city_id = $beneficiaireAssoc->city_id;
				$beneficiaire->type = $beneficiaireAssoc->type;
				$beneficiaire->handicape = $beneficiaireAssoc->handicape;
				$beneficiaire->house_price = $beneficiaireAssoc->house_price;


			
			




		}


	
	}*/







	public function nouveautesencours(){

		$images = Beneficiaire::join('images_beneficiaire_assoc','beneficiaires.id','images_beneficiaire_assoc.beneficiaire_id')
			->join("beneficiaire_translate",'beneficiaires.id','beneficiaire_translate.beneficaire_id')
			->where("images_beneficiaire_assoc.validated",0)
			->where("beneficiaire_translate.language_id",2)
                        ->select("beneficiaires.id","images_beneficiaire_assoc.id as identifiant","link","last_name","images_beneficiaire_assoc.type","first_name","age","sex","handicape","images_beneficiaire_assoc.deleted")		
			->get();

		$walls = Beneficiaire::join("walls_beneficiaire_assoc",'beneficiaires.id','walls_beneficiaire_assoc.beneficiaire_id')
			->join("beneficiaire_translate",'beneficiaires.id','beneficiaire_translate.beneficaire_id')
			->where("walls_beneficiaire_assoc.validated",0)
			->where("beneficiaire_translate.language_id",2)
			->select("beneficiaires.id","walls_beneficiaire_assoc.image","walls_beneficiaire_assoc.id as identifiant","walls_beneficiaire_assoc.title","walls_beneficiaire_assoc.description","last_name","walls_beneficiaire_assoc.type","first_name","age","sex","handicape","walls_beneficiaire_assoc.deleted")
			->get();
	
		//return $walls;	
		return view("nouveautesencours.list",compact(['images','walls']));
	
	}


	 public function beneficiairesencours(){

                $images = BeneficiaireAssoc::join("beneficiaire_translate_assoc",'beneficiaires_assoc.id','beneficiaire_translate_assoc.beneficaire_id')
			->where("beneficiaire_translate_assoc.validated",0)
			->where("beneficiaires_assoc.validated",0)
                        ->where("beneficiaire_translate_assoc.language_id",2)
                        ->select("beneficiaires_assoc.id","last_name","first_name","age","sex","handicape","beneficiaires_assoc.deleted")
                        ->get();

                

                
                return view("beneficiairesencours.list",compact('images'));

        }



	public function beneficiairesvalides(){

                $images = BeneficiaireAssoc::join("beneficiaire_translate_assoc",'beneficiaires_assoc.id','beneficiaire_translate_assoc.beneficaire_id')
			->where("beneficiaire_translate_assoc.validated",1)
			->where("beneficiaires_assoc.validated",1)
                        ->where("beneficiaire_translate_assoc.language_id",2)
                        ->select("beneficiaires_assoc.id","last_name","first_name","age","sex","handicape","beneficiaires_assoc.deleted")
                        ->get();

		//return $images;




                return view("beneficiairesvalides.list",compact('images'));

        }


	 public function nouveautesvalides(){

                $images = Beneficiaire::join('images_beneficiaire_assoc','beneficiaires.id','images_beneficiaire_assoc.beneficiaire_id')
                        ->join("beneficiaire_translate",'beneficiaires.id','beneficiaire_translate.beneficaire_id')
                        ->where("images_beneficiaire_assoc.validated",1)
                        ->where("beneficiaire_translate.language_id",2)
                        ->select("beneficiaires.id","link","last_name","images_beneficiaire_assoc.type","first_name","age","sex","handicape","images_beneficiaire_assoc.deleted")
                        ->get();

                $walls = Beneficiaire::join("walls_beneficiaire_assoc",'beneficiaires.id','walls_beneficiaire_assoc.beneficiaire_id')
                        ->join("beneficiaire_translate",'beneficiaires.id','beneficiaire_translate.beneficaire_id')
                        ->where("walls_beneficiaire_assoc.validated",1)
                        ->where("beneficiaire_translate.language_id",2)
                        ->select("beneficiaires.id","walls_beneficiaire_assoc.image","walls_beneficiaire_assoc.title","walls_beneficiaire_assoc.description","last_name","walls_beneficiaire_assoc.type","first_name","age","sex","handicape","walls_beneficiaire_assoc.deleted")
                        ->get();

                //return $walls;
                return view("nouveautesvalides.list",compact(['images','walls']));

        }







    public function store_image(Request $request) {

		
	    	$file = request()->image;
		$filename = time().'.'.$file->getClientOriginalExtension();
		$mime = mime_content_type($file->path());
		$image = New Photo;
		$isImage = false;

			if(strstr($mime, "video/")){


            
            		$image->type="video";	



			}else if(strstr($mime, "image/")){
		$isImage = true;		
		$image->type="image";		
		$img = Image::make($file->path());              
                $img->save(public_path('uploads/images').'/'. $filename);	

			}else if(strstr($mime,"audio/")){
			$image->type="audio";
			
			}

		$file->move(public_path('uploads/images'), $filename);
		$image->link='images/'.$filename;
		$image->beneficiaire_id = $request->id;
		$image->save();

		$beneficiairesUser = BeneficiaireUser::where("beneficiaire_id", "=", $request->id)
                                ->where('status','=','validé')
                                ->get();

			foreach($beneficiairesUser as $beneficiaire)

			{
                        $user_id = $beneficiaire->user_id;
                        //$beneficiaire = Beneficiaire::where("id","=", $user_beneficiaire->beneficiaire_id)->first();
                $beneficiaire_ar = Beneficiairetranslate::where('beneficaire_id', '=', $request->id)->where('language_id', '=', 2)->first();
                //$beneficiaire_ar->first_name;
                //$title = "ﻲﺘﻴﻤﻳ";
                //$description = "ﻪﻧﺎﻛ ﺝﺪﻳﺩ ﻊﻟﻯ ﻢﻧ ﺖﻜﻔﻟﻮﻧ ... ﺖﺟﺩﻮﻨﻫ ﻒﻳ ﺲﺟﻼﺗ ﺺﻏﺍﺮﻜﻣ.";

			 $title = "يتيمي| Yatimi";
                $description = "هناك جديد حول من تكفلون ... ستجدونه في سجلات صغاركم";


			
			$id = $request->id + $image->id;
		//echo $title . " " . $description . " \n";

		if($isImage){

			$url = "uploads/".$image->link;

		}else{

			 $url = "yatimi_bg.jpg"; 
		
		}


		$this->sendNotification($id, $title, $description, $user_id, "http://ataaserv.westeurope.cloudapp.azure.com/".$url);
		            //    return redirect('/admin/beneficiaire/edit/'.$request->id);
        		}
		return redirect('/admin/beneficiaire/edit/'.$request->id);


    }


     public function store(Request $request) {
		
       /* $beneficiaire = Beneficiaire::create([
          'birthday' => $request->post('birthday'),
          'sex' => $request->post('sex'),
          'weight' => $request->post('weight'),
	  'length' => $request->post('length'),
	  'handicape' => $request->post('handicape'),
	  'type' => $request->post('type'),
          'Last_school_note' => $request->post('Last_school_note'),
          'association_id' => $request->post('association_id'),
          'mother_phone' => $request->post('mother_phone'),
	  'brothers_number' => $request->post('brothers_number'),
	  'mother_death_date'=>$request->post('mother_death_date'),
          'father_birthday' => $request->post('father_birthday'),
	  'death_date' => $request->post('death_date'),
	  'house_price' => $request->post('house_price')
  ]);*/


	     $beneficiaire = new Beneficiaire;

	     $beneficiaire->birthday = $request->post('birthday');
	     $beneficiaire->sex= $request->post('sex');
		
	     $beneficiaire->death_date = $request->post('death_date');
	     $beneficiaire->father_birthday = $request->post('father_birthday');
	     $beneficiaire->mother_death_date = $request->post('mother_death_date');
	     $beneficiaire->brothers_number = $request->post('brothers_number');
	     $beneficiaire->mother_phone = $request->post('mother_phone');
	     $beneficiaire->association_id = $request->post('association_id');
	     $beneficiaire->Last_school_note = $request->post('Last_school_note');
	     $beneficiaire->type = $request->post('type');
	     $beneficiaire->handicape = $request->post('handicape');
	     $beneficiaire->length = $request->post('length');
	     $beneficiaire->weight = $request->post('weight');
	     $beneficiaire->house_price = $request->post('house_price');
	     $beneficiaire->city_id = $request->city_id;

	     $file  = request()->image;
	     $filename = time().'.'.$file->getClientOriginalExtension();
		request()->image->move(public_path('uploads/images'), $filename);

	     $beneficiaire->image='images/'.$filename;


	     //if(in_array($file['content-type'], ['image/*'])){
	     
		$beneficiaire->image_blur = 'blur-images/' . $filename;
    		$img = Image::make(public_path('uploads/images/' . $filename));
		$img->blur(90);
		$img->save(public_path('uploads/blur-images/' . $filename));
		$beneficiaire->save();

	     //}
		/*
		$img = Image::make('public/foo.jpg');
		// apply slight blur filter
		$img->blur();
		// apply stronger blur
		$img->blur(15);
		*/
		$id = $beneficiaire->id;
		$beneficiaire_fr = New Beneficiairetranslate;
		$beneficiaire_fr->language_id = 1;
		$beneficiaire_fr->beneficaire_id = $id;
		$beneficiaire_fr->last_name = $request->last_name_fr;
		$beneficiaire_fr->first_name = $request->first_name_fr;
		$beneficiaire_fr->father_name = $request->father_name_fr;
		$beneficiaire_fr->mother_name = $request->mother_name_fr;
		$beneficiaire_fr->leisure = $request->leisure_fr;
		$beneficiaire_fr->address = $request->address_fr;
		$beneficiaire_fr->biography = $request->biography_fr;
		$beneficiaire_fr->school_level = $request->school_level_fr;
		//$beneficiaire_fr->city = $request->city_fr;
		$beneficiaire_fr->dream = $request->dream_fr;
		$beneficiaire_fr->age =  \Carbon\Carbon::parse($request->post('birthday'))->age;
		$beneficiaire_fr->last_school_name = $request->last_school_name_fr;
		$beneficiaire_fr->house_type = $request->house_type_fr;
		$beneficiaire_fr->save();
		
		$beneficiaire_ar = New BeneficiaireTranslate;
		$beneficiaire_ar->language_id = 2;
		$beneficiaire_ar->beneficaire_id = $id;
		$beneficiaire_ar->last_name = $request->last_name_ar;
		$beneficiaire_ar->first_name = $request->first_name_ar;
		$beneficiaire_ar->father_name = $request->father_name_ar;
		$beneficiaire_ar->mother_name = $request->mother_name_ar;
		$beneficiaire_ar->leisure = $request->leisure_ar;
		$beneficiaire_ar->address = $request->address_ar;
		$beneficiaire_ar->biography = $request->biography_ar;
		$beneficiaire_ar->school_level = $request->school_level_ar;
		//$beneficiaire_ar->city = $request->city_ar;
		$beneficiaire_ar->dream = $request->dream_ar;
		$beneficiaire_ar->age = \Carbon\Carbon::parse($request->post('birthday'))->age;;
		$beneficiaire_ar->last_school_name = $request->last_school_name_ar;
		$beneficiaire_ar->house_type = $request->house_type_ar;
		$beneficiaire_ar->save();


		
		if($request->handicape == "1")
		
		{

			$beneficiaireHandicape = new BeneficiaireHandicape;
			$beneficiaireHandicape->beneficiaire_id = $id;
			$beneficiaireHandicape->save();

			$beneficiaireHandicapeTranslate = new BeneficiaireHandicapeTranslate;
			$beneficiaireHandicapeTranslate->beneficiaire_id = $id;
			$beneficiaireHandicapeTranslate->handicape_id = $beneficiaireHandicape->id;
			$beneficiaireHandicapeTranslate->handicape_title = $request->nommaladie;
			$beneficiaireHandicapeTranslate->description = $request->descriptionmaladie;
			$beneficiaireHandicapeTranslate->price = $request->prixmedicaments;
			$beneficiaireHandicapeTranslate->language_id = 2;	
			$beneficiaireHandicapeTranslate->save();	
		}






        return redirect('/admin/beneficiaire');
    }

    public function create()
    {
	$associations = Association::join('association_translate','associations.id','=','association_translate.association_id')->where('language_id',2)->get();
	$cities = City::join('cities_translate','cities.id','=','cities_translate.city_id')->where('language_id',2)->get();
	//return $cities;
	return view('beneficiaire.add', compact('associations','cities'));
    }

	public function create_image($id)
    {
		
		return view('beneficiaire.add_image', compact('id'));
    }

    public function edit($id)
    {    
	//	$associations = Association::get();
	$associations = Association::join('association_translate','associations.id','=','association_translate.association_id')->where('language_id',2)->get();    
	
	$beneficiaire = beneficiaire::with(['images_beneficiaire', 'walls_beneficiaire','beneficiaire_translate'])->where('beneficiaires.id','=',$id)->first();

	$beneficiaireSuperieur = BeneficiaireEcole::where('beneficiaire_id',$id)->first();

	if($beneficiaire->handicape == 1){
	
		$beneficiaireHandicape = beneficiaireHandicape::join('beneficiaire_handicape_translate','beneficiaire_handicape_translate.handicape_id','=','beneficiaire_handicape.id')->where('beneficiaire_handicape_translate.language_id',2)->where('beneficiaire_handicape.beneficiaire_id',$id)->first();

		//return $beneficiaireHandicape;
	}

	//$beneficiaire = beneficiaire::with(['images_beneficiaire', 'walls_beneficiaire','beneficiaire_translate'])->where('id','=',$id)->first();
	//return $beneficiaireHandicape;
	$cities = City::join('cities_translate','cities.id','=','cities_translate.city_id')->where('language_id',2)->get();
        return view('beneficiaire.edit', compact('beneficiaire', 'associations','cities','beneficiaireHandicape','beneficiaireSuperieur'));
    }
	
	public function destroy($id)
    {
    	
		//Beneficiairetranslate::where("beneficaire_id","=",$id)->delete();
	    //Photo::where("beneficiaire_id","=",$id)->delete();
	    $beneficiaire = Beneficiaire::find($id);
	    $archivedBeneficiaire = $beneficiaire->replicate();
	    $archivedBeneficiaire->setTable("beneficiaires_archived");
	    $archivedBeneficiaire->save();
	    $beneficiaire->delete();

        
        return redirect('/admin/beneficiaire');
    }

   	public function destroy_image($id)
    {
		$image = Photo::find($id);
		$id = $image->beneficiaire_id;
		$image->delete();
        
        return redirect('/admin/beneficiaire/edit/'.$id);
    }
    
    public function update(Request $request)
    {
		
		$beneficiaire = Beneficiaire::find($request->post('id'));
		if($beneficiaire){
			$beneficiaire->birthday = $request->post('birthday');
			$beneficiaire->mother_death_date = $request->post('mother_death_date');
			$beneficiaire->type = $request->post('type');
			$beneficiaire->sex = $request->post('sex');
			$beneficiaire->weight = $request->post('weight');
			$beneficiaire->length = $request->post('length');
			$beneficiaire->Last_school_note = $request->post('Last_school_note');
			$beneficiaire->association_id = $request->post('association_id');
			$beneficiaire->city_id = $request->post('city_id');
          	$beneficiaire->mother_phone = $request->post('mother_phone');
          	$beneficiaire->brothers_number = $request->post('brothers_number');
          	$beneficiaire->father_birthday = $request->post('father_birthday');
          	$beneficiaire->death_date = $request->post('death_date');

		$beneficiaire->house_price = $request->post('house_price');
			if(isset(request()->image) && !empty(request()->image)){
				$filename = time().'.'.request()->image->getClientOriginalExtension();
				request()->image->move(public_path('uploads/images'), $filename);

				$beneficiaire->image = 'images/' . $filename;
				$beneficiaire->image_blur = 'blur-images/' . $filename;

    			$img = Image::make(public_path('uploads/images/' . $filename));
				$img->blur(90);
				$img->save(public_path('uploads/blur-images/' . $filename));
			}
			
			$beneficiaire->save();
			
			$beneficiaire_fr = Beneficiairetranslate::where("beneficaire_id","=",$request->post('id'))->where("language_id","=",1)->first();
			if(!$beneficiaire_fr){
				$beneficiaire_fr = New Beneficiairetranslate;
			}
			$beneficiaire_fr->language_id = 1;
			$beneficiaire_fr->beneficaire_id = $request->post('id');
			$beneficiaire_fr->last_name = $request->last_name_fr;
			$beneficiaire_fr->first_name = $request->first_name_fr;
			$beneficiaire_fr->father_name = $request->father_name_fr;
			$beneficiaire_fr->mother_name = $request->mother_name_fr;
			$beneficiaire_fr->leisure = $request->leisure_fr;
			$beneficiaire_fr->address = $request->address_fr;
			$beneficiaire_fr->biography = $request->biography_fr;
			$beneficiaire_fr->school_level = $request->school_level_fr;
			//$beneficiaire_fr->city = $request->city_fr;
			$beneficiaire_fr->dream = $request->dream_fr;
			$beneficiaire_fr->age = $request->age_fr;
			$beneficiaire_fr->last_school_name = $request->last_school_name_fr;
			$beneficiaire_fr->house_type = $request->house_type_fr;
			$beneficiaire_fr->save();
			
			$beneficiaire_ar = Beneficiairetranslate::where("beneficaire_id","=",$request->post('id'))->where("language_id","=",2)->first();
			if(!$beneficiaire_ar){
				$beneficiaire_ar = New Beneficiairetranslate;
			}
			$beneficiaire_ar->language_id = 2;
			$beneficiaire_ar->beneficaire_id = $request->post('id');
			$beneficiaire_ar->last_name = $request->last_name_ar;
			$beneficiaire_ar->first_name = $request->first_name_ar;
			$beneficiaire_ar->father_name = $request->father_name_ar;
			$beneficiaire_ar->mother_name = $request->mother_name_ar;
			$beneficiaire_ar->leisure = $request->leisure_ar;
			$beneficiaire_ar->address = $request->address_ar;
			$beneficiaire_ar->biography = $request->biography_ar;
			$beneficiaire_ar->school_level = $request->school_level_ar;
			//$beneficiaire_ar->city = $request->city_ar;
			$beneficiaire_ar->dream = $request->dream_ar;
			$beneficiaire_ar->age = $request->age_ar;
			$beneficiaire_ar->last_school_name = $request->last_school_name_ar;
			$beneficiaire_ar->house_type = $request->house_type_ar;
			$beneficiaire_ar->save();

			if($request->charges != null && $request->noteBac != null){

				$beneficiaireSuperieur = BeneficiaireEcole::where('beneficiaire_id',$request->id)->first();
				
				if(!$beneficiaireSuperieur){

					$beneficiaireSuperieur = new BeneficiaireEcole;


				}

				$beneficiaireSuperieur->beneficiaire_id = $request->id;
				$beneficiaireSuperieur->noteBac = $request->noteBac;
				$beneficiaireSuperieur->charges = $request->charges;
				$beneficiaireSuperieur->save();


			}

			return redirect('/admin/beneficiaire');
		}
		
       return redirect('/admin');
    }

    public function create_wall($id, Request $request) {
		return view('beneficiaire.add_wall', compact('id'));
    }

    public function wallsupdate(Request $request) {
	    
	    $wall = WallsBeneficiaireAssoc::find($request->idWall);

             	// $filename = time().'.'.request()->image->getClientOriginalExtension();

	    if($wall){
		$isImage = false;

		if(isset($request->image)){

		$filename = time().'.'.request()->image->getClientOriginalExtension();
		//$isImage = false;
                $mime = mime_content_type(request()->image->path());
                     if(strstr($mime, "video/")){



                        $wall->type="video";



                        }else if(strstr($mime, "image/")){

                                $wall->type="image";
                                $isImage = true;

                        }else if(strstr($mime, "audio/")){

                        $wall->type="audio";
                        }

                request()->image->move(public_path('uploads/images'), $filename);

                $wall->image = 'images/'.$filename;

		
		
		
		}
		else{
			if($request->type == "image"){

				$isImage = true;

			}else{

				$isImage = false;
			
			}

			$wall->type=$request->type;
			$wall->image=$request->url;

		
		}
		
		/*$isImage = false;
                $mime = mime_content_type(request()->image->path());
                     if(strstr($mime, "video/")){



                        $wall->type="video";



                        }else if(strstr($mime, "image/")){

                                $wall->type="image";
                                $isImage = true;

                        }else if(strstr($mime, "audio/")){

                        $wall->type="audio";
                        }

                request()->image->move(public_path('uploads/images'), $filename);

		$wall->image = 'images/'.$filename;*/
		
		
		
		$wall->beneficiaire_id = $request->id;
                $wall->title = $request->title;
                $wall->description = $request->description;
                $wall->language_id = $request->language_id;
                $wall->save();


	      
      			  
        
                return redirect('/admin/nouveautesencours');
                //return view('beneficiaire.add_wall', compact('id'));
   
   		 }
	}





    public function store_wall(Request $request) {
		$wall = New WallsBeneficiaire;
		$filename = time().'.'.request()->image->getClientOriginalExtension();
		$isImage = false;
		$mime = mime_content_type(request()->image->path());
                     if(strstr($mime, "video/")){



                        $wall->type="video";



                        }else if(strstr($mime, "image/")){

				$wall->type="image";
				$isImage = true;

			}else if(strstr($mime, "audio/")){
			
			$wall->type="audio";
			}
		
		request()->image->move(public_path('uploads/images'), $filename);

		$wall->image = 'images/'.$filename;
		$wall->beneficiaire_id = $request->id;
		$wall->title = $request->title;
		$wall->description = $request->description;
		$wall->language_id = $request->language_id;
		$wall->save();

        $beneficiaire = BeneficiaireUser::where("beneficiaire_id", "=", $request->id)
                                ->where('status','=','validé')
				->get();


        foreach($beneficiaire as $bene) {

			$user = User::find($bene->user_id);
			
			$device_token = $user->device_token;
			
			//$beneficiaire = Beneficiaire::where("id","=", $user_beneficiaire->beneficiaire_id)->first();
	        	
			$beneficiaire_ar = Beneficiairetranslate::where('beneficaire_id', '=', $request->id)->where('language_id', '=', 2)->first();
			//$beneficiaire_ar->first_name;
			
			if($isImage){
				$url = "uploads/".$wall->image;
				}else{
			        $url = "yatimi_bg.jpg";
				}
	        $title = "يتيمي";
	        $description = "هناك جديد على من تكفلون ... تجدونه في سجلات صغاركم.";

	        $id = $wall->id +  $request->id;
		//echo $title . " " . $description . " \n";

		$this->sendNotification($id, $title, $description, $user->id, "http://ataaserv.westeurope.cloudapp.azure.com/".$url);		
	        //$this->sendPushNotification($id, $title, $description, $device_token, "http://ataaserv.westeurope.cloudapp.azure.com/".$url);
    	}
		return redirect('/admin/beneficiaire/edit/'.$request->id);
		//return view('beneficiaire.add_wall', compact('id'));
    }

    public function destroy_wall($id, Request $request) {
		//return view('beneficiaire.add_wall', compact('id'));
		$wall = WallsBeneficiaire::find($id);
		$id = $wall->beneficiaire_id;
		$wall->delete();
        
        return redirect('/admin/beneficiaire/edit/'.$id);
    }


 /*public function sendPushNotification($id, $title, $message, $fcm_token, $image) {
                $push_notification_key = "AAAAtMwIaQY:APA91bG-LEmpjVW9ih87cuQnOXbMLH-7ohIE424AD_0sSWYeSDHgL637_g1lwv8TWfh8b6z5bpJoWMB5M_ptKYl3cgsRx0GpnEkXNxEIXpWZ6HIWtJxgQgFMGRbJ6tnh4NRvYiE_jeS5";
                $url = "https://fcm.googleapis.com/fcm/send";
                $header = array("authorization: key=" . $push_notification_key . "",
                "content-type: application/json"
        );

        $postdata = '{
                "to" : "' . $fcm_token . '",
                "notification" : {
                    "title":"' . $title . '",
                            "text" : "' . $message . '",
                                                        "image" : "' . $image . '",
                },
                "data" : {
                "id" : "'.$id.'",
                "title":"' . $title . '",
                "description" : "' . $message . '",
                "text" : "' . $message . '",
                "is_read": 0
                }
                }';

                $ch = curl_init();
                $timeout = 12000;
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        // Get URL content
                $result = curl_exec($ch);
        // close handle to release resources
                curl_close($ch);

        return $result;

 }  */ 

     public function sendNotification($id, $title, $description, $user_id, $image){
        $notification = new Notification;
        $notification->user_id = $user_id;
        $notification->title = $title;
        $notification->description = $description;
        //$notification->image = $image;
        $notification->lu = 0;
        $notification->save();

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($description)
                ->setSound('default')
                ->setIcon($image)
                ;

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['title'=>$title, 'description' => $description, 'image'=> $image,"id"=>$id]);

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


  /*  public function sendNotification($title, $description, $user_id) {
        $notification = new Notification;
        $notification->user_id = $user_id;
        $notification->title = $title;
        $notification->description = $description;
        $notification->save();
        
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
  }*/
    //
		//$walls=WallsBeneficiaire::where('beneficiaire_id','=',$request->beneficiaire_id)->get();

    public function blurImage(Request $request) {
    	set_time_limit(0);
		ini_set('max_execution_time', 0); 
    	//$img = Image::make(public_path('uploads/users/7322e4cb3235cc69e3b65c095c0a4e87.jpg'));
		// apply slight blur filter
		//$img->blur(50);
		//$img->save(public_path('uploads/users/blur.jpg'));
		$beneficiaires = Beneficiaire::get();//where('id', '>', 107)->
		foreach ($beneficiaires as $beneficiaire) {
			$beneficiaire->image_blur = 'blur-' . $beneficiaire->image;
    		$img = Image::make(public_path('uploads/' . $beneficiaire->image));
			$img->blur(90);
			$img->save(public_path('uploads/blur-' . $beneficiaire->image));
			$beneficiaire->save();

			echo "Beneficiaire : $beneficiaire->id <br/>";
		}

    }

    public function export(){
	    
	$now = Carbon::now();
	//Excel::import(User::all(), 'users.xlsx');
	return Excel::download(new Export, 'beneficiaires_'.$now->toDateTimeString().'.xlsx');

    }
    public function export2(){

		        $now = Carbon::now();
			       
			        return Excel::download(new Export2, 'beneficiairesNonParraines_'.$now->toDateTimeString().'.xlsx');
			
			
			            }
	
    public function export3(){

	                         $now = Carbon::now();
		                return Excel::download(new Export3, 'beneficiairesParraines_'.$now->toDateTimeString().'.xlsx');


				                                     }


public function pdf()
{

        $now = Carbon::now();

        $beneficiaires = Beneficiaire::join('beneficiaire_translate','beneficiaires.id','=','beneficiaire_translate.beneficaire_id')
                    ->where("beneficiaire_translate.language_id",2)
                    ->orderBy('beneficiaires.id', 'ASC')                    
                    ->get();

                view()->share('beneficiaires',$beneficiaires);
                $pdf = PDF::loadView('beneficiaire.beneficiairePdf', $beneficiaires);
                return $pdf->stream('beneficiaires_'.$now->toDateTimeString().'.pdf');
      
    }





public function pdf2()
{

        $now = Carbon::now();

        $beneficiaires = beneficiaire::join('beneficiaire_translate','beneficiaires.id','=','beneficiaire_translate.beneficaire_id')
            ->where("beneficiaire_translate.language_id",2)->where('isfree',1)
            ->orderBy('beneficiaires.id', 'ASC')
            ->get();


                view()->share('beneficiaires',$beneficiaires);
                $pdf = PDF::loadView('beneficiaire.beneficiairePdf', $beneficiaires);
                return $pdf->stream('beneficiaires_'.$now->toDateTimeString().'.pdf');
        
    }





public function pdf3()
{

        $now = Carbon::now();

        $beneficiaires = beneficiaire::join('beneficiaire_translate','beneficiaires.id','=','beneficiaire_translate.beneficaire_id')
         ->where("beneficiaire_translate.language_id",2)->where('isfree',0)
         ->orderBy('beneficiaires.id', 'ASC')->get();


                view()->share('beneficiaires',$beneficiaires);
                $pdf = PDF::loadView('beneficiaire.beneficiairePdf', $beneficiaires);
                return $pdf->stream('beneficiaires_'.$now->toDateTimeString().'.pdf');

    }














}
