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
use App\Models\Donation;
use App\Models\Project;
use App\Models\ProjectTranslate;
use App\Models\Paiement;
use App\Http\Controllers\Admin\Export6;


class DonationCrudController extends Controller
{
    public function index(Request $request)
    {
		
	    $donations = Donation::join('projects','donations.project_id','=','projects.id')
		    ->join('project_translates','project_translates.project_id','=','projects.id')
		    ->where('project_translates.language_id',2)
		    ->select('donations.id','transaction_id','montant','email','title','donations.created_at')
		    ->get();
	    
	    	
	    return view('donation.list', compact('donations'));
 	    
        
    }


    
     public function store(Request $request) {
		

	     $donation = new Donation;

	     $donation->transaction_id = $request->post('transaction_id');
	     $donation->montant = $request->post('montant');
	     $donation->project_id = $request->post('project_id');

	     $user = User::whereEmail($request->email)->first();
	     //return $user;
	     if($user == null){
		     return 'email n\'existe pas';
	     }else{	     
	     $donation->email = $request->post('email');	   
	     $donation->currency = 504;
	     
	     $donation->save(); 	     
	
	     }

        return redirect('/admin/donation');
    }

    public function create()
    
    {
	    			$projects = Project::join('project_translates','projects.id','=','project_translates.project_id')
		    			  
					  ->select('projects.id','project_translates.title')->get();



		     	return view('donation.add',compact('projects'));
    }



    public function edit($id)
    {    
	    $donation = Donation::find($id);
	     $projects = Project::join('project_translates','projects.id','=','project_translates.project_id')

                                          ->select('projects.id','project_translates.title')->get();

//	return $paiement;
        return view('donation.edit', compact(['projects','donation']));
    }
	
	public function destroy($id)
    {
    	
	
	    $donation = Donation::find($id);
	    
	    $donation->delete();

        
        return redirect('/admin/donation');
    }

   
    
    public function update(Request $request)
    {
		
		$donation = Donation::find($request->post('id'));
		if($donation){
			

             $donation->transaction_id = $request->post('transaction_id');
             $donation->montant = $request->post('montant');
             $donation->project_id = $request->post('project_id');

             $user = User::whereEmail($request->email)->first();
             //return $user;
             if($user == null){
                     return 'email n\'existe pas';
             }else{
             $donation->email = $request->post('email');
             $donation->currency = 504;

             $donation->save();

             }

        return redirect('/admin/donation');

		}
		
       return redirect('/admin');
    }


 public function export(){

        $now = Carbon::now();
        //Excel::import(User::all(), 'users.xlsx');
        return Excel::download(new \App\Http\Controllers\Admin\Export7, 'donations_'.$now->toDateTimeString().'.xlsx');

    }

 public function pdf()
{

        $now = Carbon::now();

	$paiements = Donation::join('projects','projects.id','=','donations.project_id')
		    ->join('project_translates','project_translates.project_id','=','projects.id')	
                    ->select('transaction_id','montant','donations.created_at','email','project_translates.title')
		   
		    ->where('language_id',2)
                    ->orderBy('donations.created_at', 'ASC')
                    ->get();

                view()->share('paiements',$paiements);
                $pdf = PDF::loadView('donation.donationPDF', $paiements);
                return $pdf->stream('donation_'.$now->toDateTimeString().'.pdf');

    }








    
}
