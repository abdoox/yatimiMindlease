<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Hash;
use App\Models\City;
use App\Models\Poste;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\BeneficiaireRespo;
use App\Models\NiveauScolaire;
use App\Models\Association;
use App\Models\BeneficiaireAssoc;
use App\Models\Beneficiaire;
use App\Models\BeneficiaireUser;
use App\Models\BeneficiaireHandicape;
use App\Models\BeneficiaireDocumentAssoc;
use App\Models\BeneficiaireHandicapeAssoc;
use App\Models\BeneficiaireHandicapeTranslateAssoc;
use App\Models\BeneficiaireEcole;
use App\Models\BeneficiaireEcoleAssoc;
use App\Models\BeneficiairetranslateAssoc;
use App\Models\Photo;
use App\Models\Logement;
use App\Models\PhotoAssoc;
use Intervention\Image\Facades\Image;
use App\Models\WallsBeneficiaire;
use App\Models\WallsBeneficiaireAssoc;
use App\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Admin\ExportAssoc;
use App\Http\Controllers\Admin\Export2Assoc;
use App\Http\Controllers\Admin\Export3Assoc;
use App\Http\Controllers\Admin\Export4Assoc;
use Carbon\Carbon;


class AssociationConnectedController extends Controller
{


	  public function exportPriseEnCharge(){

                        $now = Carbon::now();

                        return  Excel::download(new ExportPriseEnChargeAssoc, 'prise_en_charge_'.$now->toDateTimeString().'.xlsx');

                  }
                  public function exportPriseEnChargeTermine(){

                        $now = Carbon::now();

                        return Excel::download(new ExportPriseTermineAssoc, 'prise_en_charge_annulee_'.$now->toDateTimeString().'.xlsx');


		
		  }

		  public function exportParrainages($id){

			  $now = Carbon::now();

			  $beneficiaire = Beneficiairetranslate::where('beneficiaire_id',$id)->where("language_id",2)->first();

			  return Excel::download(new ExportParrainage($id), $beneficiaire->first_name.'_'.$beneficiare->last_name.'_'.$now->toDateTimeString().'.xlsx');
		  
		  }



	 public function prise_en_charge(Request $request)
    {

	    $association = auth("associations")->user();

	    $nbr = BeneficiaireUser::join("beneficiaires","beneficiaires.id","beneficiaire_user.beneficiaire_id")
		    	->where("beneficiaires.association_id",$association->id)	
			->where("status","validé")
			->count();


            $entries = BeneficiaireUser::where('status', '=', 'validé')
                        ->join('beneficiaire_translate','beneficiaire_translate.beneficaire_id', '=', 'beneficiaire_user.beneficiaire_id')
                                 ->where('beneficiaire_translate.language_id', '=', 2)
                                 //->where('beneficiaire_user.type','=',0)
                                 //->join('users', 'users.id', '=', 'beneficiaire_user.user_id')
                    ->join('beneficiaires', 'beneficiaires.id', '=', 'beneficiaire_translate.beneficaire_id')
                    //->join('association_translate', 'beneficiaires.association_id', '=', 'association_translate.association_id')
                    ->select('beneficiaires.id',"beneficiaires.created_at as createdAt","beneficiaire_translate.age","beneficiaires.sex","beneficiaires.handicape","beneficiaire_user.id as parrainage_id", 'beneficiaire_user.beneficiaire_id', 'beneficiaire_user.user_id', 'beneficiaire_translate.first_name', 'beneficiaire_translate.last_name' ,'beneficiaire_user.montant', 'beneficiaire_user.date_fin', 'beneficiaire_user.created_at')
                    ->where('association_id',$association->id)
                    ->orderBy('created_at', 'desc')

                    ->get();


        return view('association.assoc.prise_en_charge', compact(['entries','nbr']));
    }

		   public function prise_en_charge_termine(Request $request)
    {

            $association = auth("associations")->user();

	    $nbr = BeneficiaireUser::join("beneficiaires","beneficiaires.id","beneficiaire_user.beneficiaire_id")
                        ->where("beneficiaires.association_id",$association->id)
                        ->where("status","terminé")
                        ->count();
            $entries = BeneficiaireUser::where('status', '=', 'terminé')
                        ->join('beneficiaire_translate','beneficiaire_translate.beneficaire_id', '=', 'beneficiaire_user.beneficiaire_id')
                                 ->where('beneficiaire_translate.language_id', '=', 2)
                                 //->where('beneficiaire_user.type','=',0)
                                 //->join('users', 'users.id', '=', 'beneficiaire_user.user_id')
                    ->join('beneficiaires', 'beneficiaires.id', '=', 'beneficiaire_translate.beneficaire_id')
                    //->join('association_translate', 'beneficiaires.association_id', '=', 'association_translate.association_id')
                    ->select('beneficiaires.id',"beneficiaires.created_at as createdAt","beneficiaire_translate.age","beneficiaires.sex","beneficiaires.handicape","beneficiaire_user.id as parrainage_id", 'beneficiaire_user.beneficiaire_id', 'beneficiaire_user.user_id', 'beneficiaire_translate.first_name', 'beneficiaire_translate.last_name' ,'beneficiaire_user.montant', 'beneficiaire_user.date_fin', 'beneficiaire_user.created_at')
                    ->where('association_id',$association->id)
                    ->orderBy('created_at', 'desc')

                    ->get();


        return view('association.assoc.prise_en_charge_termine', compact(['entries','nbr']));
    }





               // $association = auth('associations')->user();

	public function index(){


		$association = auth('associations')->user();

                        $beneficiaires =  Beneficiaire::with(['images_beneficiaire', 'walls_beneficiaire','beneficiaire_translate'])
                    ->join('cities','cities.id','beneficiaires.city_id')
                    ->join('associations','associations.id','beneficiaires.association_id')

                    ->select('beneficiaires.id','beneficiaires.sex','beneficiaires.handicape','cities.label')

                    ->orderBy('beneficiaires.id', 'DESC')
                    ->where('associations.id',$association->id)
                    ->get();


		$nbrTotalBen = Beneficiaire::where("association_id",$association->id)->count();
	        $nbrParraineBen = Beneficiaire::where('isfree',0)->where("association_id",$association->id)->count();	
                $nbrNonParraineBen = Beneficiaire::where('isfree',1)->where("association_id",$association->id)->count();	

                        return view('association.assoc.list', compact(['beneficiaires','nbrTotalBen','nbrParraineBen','nbrNonParraineBen']));
		
	
	}

	  public function index2(Request $request){

		                  $association = auth('associations')->user();
                $beneficiaires = Beneficiaire::with(['images_beneficiaire', 'walls_beneficiaire','beneficiaire_translate'])
                        ->join('cities','cities.id','beneficiaires.city_id')
                        ->select('beneficiaires.id','beneficiaires.sex','beneficiaires.handicape','cities.label')
                        ->where('beneficiaires.isfree',1)
		                    ->where('association_id',$association->id)  
			->orderBy('id', 'ASC')
                        ->get();

		 //$nbrTotalBen = Beneficiaire::get()->count();
                //$nbrParraineBen = Beneficiaire::where('isfree',0)->count();
                $nbrNonParraineBen = Beneficiaire::where('isfree',1)->where("association_id",$association->id)->count();

                 return view('association.assoc.listNonParraine', compact(['beneficiaires','nbrNonParraineBen']));

        }
         public function index3(Request $request){

		                 $association = auth('associations')->user();
                 $beneficiaires = Beneficiaire::with(['images_beneficiaire', 'walls_beneficiaire','beneficiaire_translate'])
                          ->join('cities','cities.id','beneficiaires.city_id')
                          ->select('beneficiaires.id','beneficiaires.sex','beneficiaires.handicape','cities.label')
			  ->orderBy('id', 'ASC')
			                      ->where('association_id',$association->id)
			  ->where('beneficiaires.isfree',0)
                                                                        ->get();

				                 $nbrParraineBen = Beneficiaire::where('isfree',0)->where("association_id",$association->id)->count();

                 return view('association.assoc.listParraine', compact(['beneficiaires','nbrParraineBen']));

        }


        public function index4(Request $request){

		                $association = auth('associations')->user();
                $beneficiaires = Beneficiaire::with(['images_beneficiaire', 'walls_beneficiaire','beneficiaire_translate'])
                         ->join('cities','cities.id','beneficiaires.city_id')
                         ->select('beneficiaires.id','beneficiaires.sex','beneficiaires.handicape','cities.label')
			 ->orderBy('id', 'ASC')
			                     ->where('association_id',$association->id)
			 ->where('handicape',1)
                                                                        ->get();

	                $nbrHandicapeBen  = Beneficiaire::where('handicape',1)->where("association_id",$association->id)->count();				

                 return view('association.assoc.listHandicape', compact(['beneficiaires','nbrHandicapeBen']));

        }


	public function parrainages($id){

		$association = auth("associations")->user();

		$beneficiaire = Beneficiaire::join('beneficiaire_translate','beneficiaire_translate.beneficaire_id','beneficiaires.id')
			->where("language_id",2)
			->where("association_id",$association->id)
			->where('beneficiaires.id',$id)
			->first();

		$parrainages = BeneficiaireUser::join('users','users.id','beneficiaire_user.user_id')
			->join("motifs_annulation_parrainage",'motifs_annulation_parrainage.id','motif_id')
			->where('beneficiaire_id', $id)
			->get();

		//return $parrainages;

		return view('association.assoc.parrainages', compact(['parrainages','beneficiaire']));

	}





	public function create(){

		$association = auth("associations")->user();

		$niveau_scolaire = NiveauScolaire::all();

		$logements = Logement::all();

		$villes = City::all();

		$postes = Poste::all();

               // return $association;
//	$cities = City::join('cities_translate','cities.id','=','cities_translate.city_id')->where('language_id',2)->get();
        //return $cities;
        return view('association.assoc.add',compact(['logements','niveau_scolaire','villes','postes']));

	}


	 public function update(Request $request)
    {

	    $association = auth('associations')->user();

                $beneficiaire = Beneficiaire::find($request->post('id'));
	    
	    if($beneficiaire){

		    $beneficiaireAssoc = BeneficiaireAssoc::find($request->post('id'));

		    if(!$beneficiaireAssoc){

			    
			    $beneficiaireAssoc = new BeneficiaireAssoc;
		    }

			$beneficiaireAssoc->id = $beneficiaire->id;   
                        $beneficiaireAssoc->birthday = $request->post('birthday');
                        $beneficiaireAssoc->mother_death_date = $request->post('mother_death_date');
                        $beneficiaireAssoc->type = $request->post('type');
                        $beneficiaireAssoc->sex = $request->post('sex');
                        $beneficiaireAssoc->weight = $request->post('weight');
                        $beneficiaireAssoc->length = $request->post('length');
                        $beneficiaireAssoc->Last_school_note = $request->post('Last_school_note');
                        $beneficiaireAssoc->association_id = $association->id;
                        $beneficiaireAssoc->city_id = $association->city_id;
                $beneficiaireAssoc->mother_phone = $request->post('mother_phone');
                $beneficiaireAssoc->brothers_number = $request->post('brothers_number');
                $beneficiaireAssoc->father_birthday = $request->post('father_birthday');
                $beneficiaireAssoc->death_date = $request->post('death_date');

                $beneficiaireAssoc->house_price = $request->post('house_price');
                        if(isset(request()->image) && !empty(request()->image)){
                                $filename = time().'.'.request()->image->getClientOriginalExtension();
                                request()->image->move(public_path('uploads/images'), $filename);

                                $beneficiaireAssoc->image = 'images/' . $filename;
                                $beneficiaireAssoc->image_blur = 'blur-images/' . $filename;

                        $img = Image::make(public_path('uploads/images/' . $filename));
                                $img->blur(90);
                                $img->save(public_path('uploads/blur-images/' . $filename));
                        }

                        $beneficiaireAssoc->save();

                        $beneficiaire_fr = BeneficiairetranslateAssoc::where("beneficaire_id","=",$request->post('id'))->where("language_id","=",1)->first();
                        if(!$beneficiaire_fr){
                                $beneficiaire_fr = New BeneficiairetranslateAssoc;
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

                        $beneficiaire_ar = BeneficiairetranslateAssoc::where("beneficaire_id","=",$request->post('id'))->where("language_id","=",2)->first();
                        if(!$beneficiaire_ar){
                                $beneficiaire_ar = New BeneficiairetranslateAssoc;
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

                                $beneficiaireSuperieur = BeneficiaireEcoleAssoc::where('beneficiaire_id',$request->id)->first();

                                if(!$beneficiaireSuperieur){

                                        $beneficiaireSuperieur = new BeneficiaireEcoleAssoc;


                                }

                                $beneficiaireSuperieur->beneficiaire_id = $request->id;
                                $beneficiaireSuperieur->noteBac = $request->noteBac;
                                $beneficiaireSuperieur->charges = $request->charges;
                                $beneficiaireSuperieur->save();


                        }

                        return redirect('/beneficiairesAssoc');
		    
	    }else{
	    echo "not found";
	    }

	 }

	 public function create_image($id)
    {

                return view('association.assoc.add_image', compact('id'));
    }


	 public function create_wall($id, Request $request) {
                return view('association.assoc.add_wall', compact('id'));
    }

    public function store_wall(Request $request) {
                $wall = New WallsBeneficiaireAssoc;
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

        

        
                return redirect('/association/beneficiaire/edit/'.$request->id);
                //return view('beneficiaire.add_wall', compact('id'));
    }

    public function destroy_wall($id) {
                //return view('beneficiaire.add_wall', compact('id'));
	    $wall = WallsBeneficiaire::find($id);
	    if($wall){

		    	$wallAssoc = WallsBeneficiaireAssoc::find($id);

			if(!$wallAssoc){

				//return "not found";
				
				$wallAssoc = $wall->replicate();
				$wallAssoc->setTable("walls_beneficiaire_assoc");
				//$wallAssoc->save();

			}

			$wallAssoc->id = $wall->id;
                	$id = $wallAssoc->beneficiaire_id;
			$wallAssoc->deleted = 1;
			$wallAssoc->save();

		return redirect('/association/beneficiaire/edit/'.$id);
	    }
    }


         public function destroy_image($id)
    {
                $image = Photo::find($id);
            if($image){

                        $wallAssoc = PhotoAssoc::find($id);

                        if(!$wallAssoc){

                                //return "not found";

                                $wallAssoc = $image->replicate();
                                $wallAssoc->setTable("images_beneficiaire_assoc");
                                //$wallAssoc->save();

                        }

			$wallAssoc->id = $image->id;
                        $id = $wallAssoc->beneficiaire_id;
                        $wallAssoc->deleted = 1;
                        $wallAssoc->save();


        return redirect('/association/beneficiaire/edit/'.$id);
    }
	 }



	public function store_image(Request $request) {


                $file = request()->image;
                $filename = time().'.'.$file->getClientOriginalExtension();
                $mime = mime_content_type($file->path());
                $image = New PhotoAssoc;
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

                
                return redirect('/association/beneficiaire/edit/'.$request->id);


	}



	 public function edit($id)
    {
        //      $associations = Association::get();
      //  $associations = Association::join('association_translate','associations.id','=','association_translate.association_id')->where('language_id',2)->get();

        $beneficiaire = beneficiaire::with(['images_beneficiaire', 'walls_beneficiaire','beneficiaire_translate'])->where('beneficiaires.id','=',$id)->first();

        $beneficiaireSuperieur = BeneficiaireEcole::where('beneficiaire_id',$id)->first();

        if($beneficiaire->handicape == 1){

                $beneficiaireHandicape = beneficiaireHandicape::join('beneficiaire_handicape_translate','beneficiaire_handicape_translate.handicape_id','=','beneficiaire_handicape.id')->where('beneficiaire_handicape_translate.language_id',2)->where('beneficiaire_handicape.beneficiaire_id',$id)->first();

                //return $beneficiaireHandicape;
        }

        //$beneficiaire = beneficiaire::with(['images_beneficiaire', 'walls_beneficiaire','beneficiaire_translate'])->where('id','=',$id)->first();
        //return $beneficiaireHandicape;
        $cities = City::join('cities_translate','cities.id','=','cities_translate.city_id')->where('language_id',2)->get();
        return view('association.assoc.edit', compact('beneficiaire','cities','beneficiaireHandicape','beneficiaireSuperieur'));
    }



	public function store(Request $request){

	
		$association = auth("associations")->user();

	//	return $association;	


	 $beneficiaire = new BeneficiaireAssoc;

             $beneficiaire->birthday = $request->post('birthday');
             $beneficiaire->sex= $request->post('sex');

             $beneficiaire->death_date = $request->post('death_date');
             $beneficiaire->father_birthday = $request->post('father_birthday');
             $beneficiaire->mother_death_date = $request->post('mother_death_date');
             $beneficiaire->brothers_number = $request->post('brothers_number');
             $beneficiaire->mother_phone = $request->post('mother_phone');
             $beneficiaire->association_id = $association->id;
             $beneficiaire->Last_school_note = $request->post('Last_school_note');
             $beneficiaire->type = $request->post('type');
             $beneficiaire->handicape = $request->post('handicape');
             $beneficiaire->length = $request->post('length');
             $beneficiaire->weight = $request->post('weight');
             $beneficiaire->house_price = $request->post('house_price');
             $beneficiaire->city_id = $association->city_id;

	     $file  = request()->image;

	     $cin_file  = request()->cin;
	     $acte_naissance_file  = request()->acte_naissance;
	     $certif_deces_pere_file  = request()->certif_deces_pere;
	     $certif_deces_mere_file  = request()->certif_deces_mere;
	     $dernier_bulletin_file  = request()->dernier_bulletin;
	     $certif_scolarite_file  = request()->certif_scolarite;
	     $dossier_medical_file  = request()->dossier_medical;
	     $ordonnance_file  = request()->ordonnance;
	     $analyses_file  = request()->analyses;
	     $contrat_logement_file  = request()->contrat_logement;
	     $certif_residence_file  = request()->certif_residence;
	     $acte_naissance_freres_file  = request()->acte_naissance_freres;


             $filename = time().'.'.$file->getClientOriginalExtension();
                request()->image->move(public_path('uploads/images'), $filename);

             $beneficiaire->image='images/'.$filename;

	     $beneficiaire->image_blur = 'blur-images/' . $filename;
                $img = Image::make(public_path('uploads/images/' . $filename));
                $img->blur(90);
                $img->save(public_path('uploads/blur-images/' . $filename));
                $beneficiaire->save();



	     $beneficiaireDocument = new BeneficiaireDocumentAssoc;

	     $beneficiaireDocument->beneficiaire_id = $beneficiaire->id;	     
     	     

	     $filename_cin = 'cin'.time().'.'.$cin_file->getClientOriginalExtension();
             $cin_file->move(public_path('uploads/images/cin'), $filename_cin);

	     $beneficiaireDocument->cin='images/cin/'.$filename_cin;


	     $filename_acte_naissance = 'acte_naissance'.time().'.'.$acte_naissance_file->getClientOriginalExtension();
             $acte_naissance_file->move(public_path('uploads/images/acte_naissance'), $filename_acte_naissance);

	     $beneficiaireDocument->acte_naissance='images/acte_naissance/'.$filename_acte_naissance;

	    
	     $filename_certif_deces_pere = 'certif_deces_pere'.time().'.'.$certif_deces_pere_file->getClientOriginalExtension();
             $certif_deces_pere_file->move(public_path('uploads/images/certif_deces_pere'), $filename_certif_deces_pere);

             $beneficiaireDocument->certif_deces_pere='images/certif_deces_pere/'.$filename_certif_deces_pere;


	     if( $request->post('type') == 1){
		     if($request->hasFile('certif_deces_mere')){
	      $filename_certif_deces_mere = 'certif_deces_mere'.time().'.'.$certif_deces_mere_file->getClientOriginalExtension();
              $certif_deces_mere_file->move(public_path('uploads/images/certif_deces_mere'), $filename_certif_deces_mere);
              $beneficiaireDocument->certif_deces_mere='images/certif_deces_mere/'.$filename_certif_deces_mere;
	     	}
	     }

	    if($request->hasFile('dernier_bulletin')){
	    
	     $filename_dernier_bulletin = 'dernier_bulletin'.time().'.'.$dernier_bulletin_file->getClientOriginalExtension();
             $dernier_bulletin_file->move(public_path('uploads/images/dernier_bulletin'), $filename_dernier_bulletin);

             $beneficiaireDocument->dernier_bulletin='images/dernier_bulletin/'.$filename_dernier_bulletin;

		}

	     if($request->hasFile('certif_scolarite')){

	     $filename_certif_scolarite = 'certif_scolarite'.time().'.'.$certif_scolarite_file->getClientOriginalExtension();
             $certif_scolarite_file->move(public_path('uploads/images/certif_scolarite'), $filename_certif_scolarite);

             $beneficiaireDocument->certif_scolarite='images/certif_scolarite/'.$filename_certif_scolarite;

	     }
		
	     if($request->handicape == 1){

		     if($request->hasFile('dossier_medical')){

		$filename_dossier_medical = 'dossier_medical'.time().'.'.$dossier_medical_file->getClientOriginalExtension();
                $dossier_medical_file->move(public_path('uploads/images/dossier_medical'), $filename_dossier_medical);

                $beneficiaireDocument->dossier_medical='images/dossier_medical/'.$filename_dossier_medical;

		}
		     if($request->hasFile('ordonnance')){

	     $filename_ordonnance = 'ordonnance'.time().'.'.$ordonnance_file->getClientOriginalExtension();
             $ordonnance_file->move(public_path('uploads/images/ordonnance'), $filename_ordonnance);

             $beneficiaireDocument->ordonnance='images/ordonnance/'.$filename_ordonnance;
		     }


		     if($request->hasFile('analyses')){

	     $filename_analyses = 'analyses'.time().'.'.$analyses_file->getClientOriginalExtension();
             $analyses_file->move(public_path('uploads/images/analyses'), $filename_analyses);

             $beneficiaireDocument->analyses = 'images/analyses/'.$filename_analyses;
		     }
	}

	     if($request->hasFile('contrat_logement')){

	     $filename_contrat_logement = 'contrat_logement'.time().'.'.$contrat_logement_file->getClientOriginalExtension();
             $contrat_logement_file->move(public_path('uploads/images/contrat_logement'), $filename_contrat_logement);

             $beneficiaireDocument->contrat_logement='images/contrat_logement/'.$filename_contrat_logement;
		}

	     if($request->hasFile('certif_residence')){

	     $filename_certif_residence = 'certif_residence'.time().'.'.$certif_residence_file->getClientOriginalExtension();
             $certif_residence_file->move(public_path('uploads/images/certif_residence'), $filename_certif_residence);

             $beneficiaireDocument->certif_residence='images/certif_residence/'.$filename_certif_residence;

		}

	     if($request->hasFile('acte_naissance_freres')){

	     $filename_acte_naissance_freres = 'acte_naissance_freres'.time().'.'.$acte_naissance_freres_file->getClientOriginalExtension();
              $acte_naissance_freres_file->move(public_path('uploads/images/acte_naissance_freres'), $filename_acte_naissance_freres);

             $beneficiaireDocument->acte_naissance_freres='images/acte_naissance_freres/'.$filename_acte_naissance_freres;
	     
	     }
	
	     $beneficiaireDocument->save();

	     	$beneficiaire_respo = New BeneficiaireRespo;
	     
	     	$beneficiaire_respo->beneficiaire_id = $beneficiaire->id;
	 	$beneficiaire_respo->nom = $request->nom_respo;
                $beneficiaire_respo->prenom = $request->prenom_respo;
                $beneficiaire_respo->telephone = $request->telephone_respo;
                $beneficiaire_respo->email = $request->email_respo;
                $beneficiaire_respo->cin = $request->cin_respo;
                $beneficiaire_respo->city_id = $request->ville_respo;
                $beneficiaire_respo->poste_id = $request->poste_respo; 

		
		if($request->hasFile('image_cin_respo')){

             $filename_image_cin_respo = 'respo'.time().'.'.$request->image_cin_respo->getClientOriginalExtension();
              $request->image_cin_respo->move(public_path('uploads/images/image_cin_respo'), $filename_image_cin_respo);

             $beneficiaire_respo->cin_image='images/image_cin_respo/'.$filename_image_cin_respo;

             }

		$beneficiaire_respo->save();

             //if(in_array($file['content-type'], ['image/*'])){

                /*$beneficiaire->image_blur = 'blur-images/' . $filename;
                $img = Image::make(public_path('uploads/images/' . $filename));
                $img->blur(90);
                $img->save(public_path('uploads/blur-images/' . $filename));
		$beneficiaire->save();*/

             //}
                /*
                $img = Image::make('public/foo.jpg');
                // apply slight blur filter
                $img->blur();
                // apply stronger blur
                $img->blur(15);
                */
                $id = $beneficiaire->id;
                $beneficiaire_fr = New BeneficiairetranslateAssoc;
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

                $beneficiaire_ar = New BeneficiaireTranslateAssoc;
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

                        $beneficiaireHandicape = new BeneficiaireHandicapeAssoc;
                        $beneficiaireHandicape->beneficiaire_id = $id;
                        $beneficiaireHandicape->save();

                        $beneficiaireHandicapeTranslate = new BeneficiaireHandicapeTranslateAssoc;
                        $beneficiaireHandicapeTranslate->beneficiaire_id = $id;
                        $beneficiaireHandicapeTranslate->handicape_id = $beneficiaireHandicape->id;
                        $beneficiaireHandicapeTranslate->handicape_title = $request->nommaladie;
                        $beneficiaireHandicapeTranslate->description = $request->descriptionmaladie;
                        $beneficiaireHandicapeTranslate->price = $request->prixmedicaments;
                        $beneficiaireHandicapeTranslate->language_id = 2;
                        $beneficiaireHandicapeTranslate->save();
                }






		return redirect('/beneficiairesAssoc');
    }

	
    public function export(){

        $now = Carbon::now();
        //Excel::import(User::all(), 'users.xlsx');
        return Excel::download(new ExportAssoc, 'beneficiaires_'.$now->toDateTimeString().'.xlsx');

    }


    public function export2(){

                        $now = Carbon::now();

                                return Excel::download(new Export2Assoc, 'beneficiairesParraines_'.$now->toDateTimeString().'.xlsx');


                                    }

    public function export3(){

                                 $now = Carbon::now();
                                return Excel::download(new Export3Assoc, 'beneficiairesNonParraines_'.$now->toDateTimeString().'.xlsx');


                                                                     }

    public function export4(){

                                 $now = Carbon::now();
                                return Excel::download(new Export4Assoc, 'beneficiairesHandicape_'.$now->toDateTimeString().'.xlsx');


                                                                     }






	 public function __construct()
    {

       // $this->middleware('guest')->except('logoutAssociation');
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
			
			
			return view('beneficiaire.list', compact('beneficiaires'));}



		/*$association = Association::whereEmail($request->email)->first();



		if( $association != null)
		
		{
			if(Hash::check($request->password, $association->password))
		

			{return view('beneficiaire.list');}
			else{return "password check";}*/
		
		else return "false";

	
	
	
	
	
	}

      public function destroy($id)
    {

                //Beneficiairetranslate::where("beneficaire_id","=",$id)->delete();
            //Photo::where("beneficiaire_id","=",$id)->delete();
	    $beneficiaire = Beneficiaire::find($id);
	    if( $beneficiaire ){

		    $beneficiaireAssoc = BeneficiaireAssoc::find($id);
		    
		    if(!$beneficiaireAssoc){

			    $beneficiaireAssoc = $beneficiaire->replicate();
			    $beneficiaireAssoc->setTable("beneficiaires_assoc");

		    }
            $beneficiaireAssoc->id = $beneficiaire->id;
	    $beneficiaireAssoc->deleted = 1;		    
            $beneficiaireAssoc->save();
	    




	}

        return redirect('/beneficiairesAssoc');
    }





}
