<?php

namespace App\Http\Controllers\Admin;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\PaiementRequest as StoreRequest;
use App\Http\Requests\PaiementRequest as UpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\Beneficiaire;
use App\Models\Beneficiairetranslate;
use App\Models\BeneficiaireUser;
use App\Models\Motif;
use App\User;
use Illuminate\Support\Facades\DB;
//use Intervention\Image\Image;
use Intervention\Image\Facades\Image;
use PDF;
class UserBeneficiaireCrudController extends Controller
{
    public function index(Request $request)
    {
      
                        $entries = BeneficiaireUser::where('status', '=', 'validé')
                        ->join('beneficiaire_translate','beneficiaire_translate.beneficaire_id', '=', 'beneficiaire_user.beneficiaire_id')
                                 ->where('beneficiaire_translate.language_id', '=', 2)
				 ->where('beneficiaire_user.type','=',0)
				 ->join('users', 'users.id', '=', 'beneficiaire_user.user_id')
                    ->join('beneficiaires', 'beneficiaires.id', '=', 'beneficiaire_translate.beneficaire_id')
                    ->join('association_translate', 'beneficiaires.association_id', '=', 'association_translate.association_id')
                    ->select('beneficiaires.id',"beneficiaire_user.id as parrainage_id", 'beneficiaire_user.beneficiaire_id', 'beneficiaire_user.user_id', 'beneficiaire_translate.first_name', 'beneficiaire_translate.last_name', 'users.firstname', 'users.lastname', 'users.email', 'beneficiaire_user.montant', 'beneficiaire_user.date_fin', 'beneficiaire_user.created_at', 'association_translate.name', 'users.adresse')
		    ->where('association_translate.language_id',2)

		    ->orderBy('created_at', 'desc')
		    
		    ->get();
		

        return view('prise_en_charge.list', compact('entries'));
    }



    	public function index2(Request $request){

		 $entries2 = BeneficiaireUser::where('status', '=', 'validé')

                        ->where('beneficiaire_user.type','=',1)
                        ->join('beneficiaire_translate','beneficiaire_translate.beneficaire_id', '=', 'beneficiaire_user.beneficiaire_id')
                        ->where('beneficiaire_translate.language_id', '=', 2)
                    ->join('users', 'users.id', '=', 'beneficiaire_user.user_id')
                    ->join('beneficiaires', 'beneficiaires.id', '=', 'beneficiaire_translate.beneficaire_id')
                    ->join('association_translate', 'beneficiaires.association_id', '=', 'association_translate.association_id')
                    ->select('beneficiaires.id',"beneficiaire_user.id as parrainage_id", 'beneficiaire_user.beneficiaire_id', 'beneficiaire_user.user_id', 'beneficiaire_translate.first_name', 'beneficiaire_translate.last_name', 'users.firstname', 'users.lastname', 'users.email', 'beneficiaire_user.montant', 'beneficiaire_user.date_fin', 'beneficiaire_user.created_at', 'association_translate.name', 'users.adresse')
                    ->where('association_translate.language_id',2)

                    ->orderBy("beneficiaires.id","desc")
                    ->get();
		        return view('prise_en_charge_partage.list', compact('entries2'));
	
	}



	     public function edit(Request $request)
	     {
		     $id = $request->id;
		     
	   
	    $beneficiaireUser = BeneficiaireUser::find($id);
	    $user = User::find($beneficiaireUser->user_id);	
	   
	    
	    

	    $motifs  = Motif::all();
	    
	    return view('prise_en_charge.edit')->with([ 'beneficiaireUser'=>$beneficiaireUser,'motifs'=>$motifs, "email"=>$user->email,"id"=>$id ]);
	     
	     }
	    
	     


	public function create()
    {    
	    return view('prise_en_charge.create');

             }





	    public function update(Request $request){

		   	
		    $beneficiaireUser = BeneficiaireUser::find($request->id);
	

		    $beneficiaireUser->montant = $request->post('montant');
		    $beneficiaireUser->status = $request->post('status');
		    
		    if($request->post('status') == "terminé"){

			                                $beneficiaireUser->date_fin = Carbon::now()->toDateTimeString();
		    
		    }else{
			
			    $beneficiaireUser->date_fin = $request->date_fin;
		    }
	    	    $beneficiaireUser->beneficiaire_id = $request->beneficiaire_id;	
		    $User = User::whereEmail($request->email)->first();
		    if($User == null) return "l'email n'existe pas";
                    $beneficiaireUser->user_id = $User->id;
		    $beneficiaireUser->type = $request->type;
		    
		    if($request->motif != null){

			   
			    $beneficiaireUser->motif_id = $request->motif;	
		    }		    
		    
		    $beneficiaireUser->save();
		    //var_dump($beneficiaireUser);	

			
		     return redirect('/admin/prise_en_charge');



	    
	    }	


		public function store(Request $request){

		    $beneficiaire_id = $request->beneficiaire_id;	
		    $checkBeneficiaireUser = BeneficiaireUser::where('beneficiaire_id',$beneficiaire_id)
			    ->where('status','validé')->first();

		    if($checkBeneficiaireUser ==null){

                    $beneficiaireUser = new BeneficiaireUser;
                    $beneficiaireUser->montant = $request->montant;
		    $beneficiaireUser->status = "validé";
		    $beneficiaireUser->type = $request->type;
                    $beneficiaireUser->date_fin = $request->date_fin;
		    $beneficiaireUser->beneficiaire_id = $beneficiaire_id; 
		    $user =User::whereEmail($request->email)->first();
		    if($user == null) return "l'email n'existe pas";
		    $user_id = $user->id;
		    $beneficiaireUser->user_id = $user_id;    
                    $beneficiaireUser->save();



                return redirect('/admin/prise_en_charge');

			}else{
			echo "l'orphelin est deja parraine";		
			}

            
                  }


 		public function export(){

        		$now = Carbon::now();
        	
        		return 	Excel::download(new ExportPrise, 'prise_en_charge_complete_'.$now->toDateTimeString().'.xlsx');

    		  }
  		  public function export2(){

                        $now = Carbon::now();

                        return Excel::download(new ExportPrisePartage, 'prise_en_charge_partage_'.$now->toDateTimeString().'.xlsx');


                    }

		  public function pdf()
{

        $now = Carbon::now();

        $beneficiaireUser = BeneficiaireUser::join('beneficiaire_translate','beneficiaire_user.beneficiaire_id','=','beneficiaire_translate.beneficaire_id')
                    ->join('users','users.id','beneficiaire_user.user_id')
                                      ->join("beneficiaires",'beneficiaire_translate.beneficaire_id','beneficiaires.id')
                   ->join('associations','associations.id','beneficiaires.association_id')
                   ->join('association_translate','association_translate.association_id', 'associations.id')

                        ->select('lastname','firstname','montant','first_name','last_name','handicape','beneficiaire_user.created_at','association_translate.name')
                                ->where("beneficiaire_translate.language_id",2)
                                ->where('beneficiaire_user.type',0)
                                ->where('association_translate.language_id',2)
                                ->where('status','validé')
                         ->orderBy('beneficiaires.id', 'ASC')
                    ->get();

                view()->share('beneficiaireUser',$beneficiaireUser);
                $pdf = PDF::loadView('prise_en_charge.prise_en_chargePdf', $beneficiaireUser);
                return $pdf->stream('prise_en_charge_'.$now->toDateTimeString().'.pdf');

    }





		public function pdf2()
	{

        	$now = Carbon::now();

        $beneficiaireUser = BeneficiaireUser::join('beneficiaire_translate','beneficiaire_user.beneficiaire_id','=','beneficiaire_translate.beneficaire_id')
                    ->join('users','users.id','beneficiaire_user.user_id')
                                      ->join("beneficiaires",'beneficiaire_translate.beneficaire_id','beneficiaires.id')
                   ->join('associations','associations.id','beneficiaires.association_id')
                   ->join('association_translate','association_translate.association_id', 'associations.id')

                        ->select('lastname','firstname','montant','first_name','last_name','handicape','beneficiaire_user.created_at','association_translate.name')
                                ->where("beneficiaire_translate.language_id",2)
                                ->where('beneficiaire_user.type',1)
                                ->where('association_translate.language_id',2)
                                ->where('status','validé')
                         ->orderBy('beneficiaires.id', 'ASC')
                    ->get();

                view()->share('beneficiaireUser',$beneficiaireUser);
                $pdf = PDF::loadView('prise_en_charge.prise_en_chargePdf', $beneficiaireUser);
                return $pdf->stream('prise_en_charge_'.$now->toDateTimeString().'.pdf');

    		}


}
