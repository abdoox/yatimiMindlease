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
use App\Models\ProjectAdvancement;
use App\Models\Project;
use App\Models\ProjectTranslate;
use App\Models\Paiement;
use App\Http\Controllers\Admin\Export6;


class PaiementCrudController extends Controller
{
    public function index(Request $request)
    {
		
	    $paiements = Paiement::join('users','users.id','=','paiements.user_id')->select('paiements.id','status','email','transaction_id','date_paiement','paiements.image','montant','paiements.type','partner_transactionid')
		    ->orderBy('paiements.date_paiement','DESC')
		    ->where('status','approved')	
		    ->get();
	    
	    $paiements2 = Paiement::join('users','users.id','=','paiements.user_id')->select('paiements.id','status','email','transaction_id','date_paiement','paiements.image','montant','paiements.type','partner_transactionid')
                    ->orderBy('paiements.date_paiement','DESC')
                    ->where('status','inprogress')
                    ->get();
	
	    return view('paiement.list', compact(['paiements','paiements2']));
 	    
        
    }


    
     public function store(Request $request) {
		

  //	return $request->status;
	
	$paiement = new Paiement;

	$user = User::whereEmail($request->post('email'))->first();
	
	if($user !=null){		
		
             $paiement->date_paiement = Carbon::now();
             $paiement->transaction_id = $request->post('transaction_id');
             $paiement->montant = $request->post('montant');
             $paiement->type = $request->post('type');
             $paiement->status = $request->post('status');
	     $paiement->partner_transactionid = $request->post('partner_transactionid');
	     $paiement->user_id = $user->id;	
	     

             //$file  = request()->image;


                        if(isset(request()->image) && !empty(request()->image)){
                               
				$file = request()->image;
		                $filename = time().'.'.$file->getClientOriginalExtension();
				$file->move(public_path('uploads/paiements'), $filename);
				$paiement->image = /*('images/paiements').*/$filename;



                        }

             $paiement->save();

	     //return $paiement;	     

	     return redirect('/admin/paiement');

	}else{

		return 'email n\'existe pas';
	
	}


    }

    public function create()
    {
		     	return view('paiement.add');
    }



    public function edit($id)
    {    
        $paiement = Paiement::join('users','users.id','=','paiements.user_id')->select('paiements.id','email','transaction_id','date_paiement','paiements.image','montant','paiements.type','status','partner_transactionid')->where('paiements.id',$id)->first();
	$parsedDate = Carbon::parse($paiement->date_paiement);
	$paiement->date_paiement = $parsedDate->format('d-m-Y');
	//return $paiement;
        return view('paiement.edit', compact('paiement'));
    }
	
	public function destroy($id)
    {
    	
	
	    $paiement = Paiement::find($id);
	    
	    $paiement->delete();

        
        return redirect('/admin/paiement');
    }

   
    
    public function update(Request $request)
    {
	//return $request->post('status');	
	 $paiement =  Paiement::find($request->id);

	 if($paiement){
        $user = User::whereEmail($request->post('email'))->first();

        if($user !=null){

             //$paiement->date_paiement = $request->post('date_paiement');
             $paiement->transaction_id = $request->post('transaction_id');
             $paiement->montant = $request->post('montant');
	     $paiement->type = $request->post('type');
	     
             $paiement->status = $request->post('status');
             $paiement->partner_transactionid = $request->post('partner_transactionid');
             $paiement->user_id = $user->id;



			
	
        	if(isset(request()->image) && !empty(request()->image)){

                                $file = request()->image;
                                $filename = time().'.'.$file->getClientOriginalExtension();
                                $file->move(public_path('uploads/paiements'), $filename);
                                $paiement->image = /*('images/paiements').*/$filename;



                        }
                        $paiement->save();
	//	return $paiement;
                        return redirect('/admin/paiement');
	}else{
	 return 'email n\'existe pas';
	}
	 }else{

		 return 'paiement n\'existe pas';
	 }

    }


 public function export(){

        $now = Carbon::now();
        //Excel::import(User::all(), 'users.xlsx');
        return Excel::download(new \App\Http\Controllers\Admin\Export6, 'paiements_'.$now->toDateTimeString().'.xlsx');

    }

 public function pdf()
{

        $now = Carbon::now();

        $paiements = Paiement::join('users','users.id','=','paiements.user_id')
                    ->select('transaction_id','montant','date_paiement','email','paiements.type')
                    ->where("status",'approved')
                    ->orderBy('date_paiement', 'ASC')
                    ->get();

                view()->share('paiements',$paiements);
                $pdf = PDF::loadView('paiement.paiementPDF', $paiements);
                return $pdf->stream('beneficiaires_'.$now->toDateTimeString().'.pdf');

    }








    
}
