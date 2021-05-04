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
use PDF;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\Beneficiaire;
use App\Models\Beneficiairetranslate;
use App\Models\BeneficiaireUser;
use App\User;
use Illuminate\Support\Facades\DB;
//use Intervention\Image\Image;
use Intervention\Image\Facades\Image;

class UtilisateurCrudController extends Controller
{
    public function index(Request $request)
    {
      
                        $parrains = User::join('beneficiaire_user','beneficiaire_user.user_id', '=', 'users.id')
				->select('users.id','users.email','users.password','users.verifie','users.lastname','users.firstname','users.city')
		    ->where('status','validé')		
		    ->distinct('users.id')
		    //->orderBy('users.created_at', 'desc')
		    ->get();

			$users =User::select('users.id','users.email','users.password','users.verifie','users.lastname','users.firstname','users.city')
				-> orderBy("users.created_at","desc")
				//->distinct('users.id')
                    ->get();


        return view('user.list', compact('users','parrains'));
    }

  public function index2(){
  $parrains = User::join('beneficiaire_user','beneficiaire_user.user_id', '=', 'users.id')
                    ->select('users.id','users.email','users.password','users.verifie','users.lastname','users.firstname','users.city')
		    ->where('status','validé')
		    ->distinct('users.id')
                    //->orderBy('users.created_at', 'desc')
		    ->get();
  return view('parrains.list', compact('parrains'));
  
  }







 public function destroy($id)
    {

                //Beneficiairetranslate::where("beneficaire_id","=",$id)->delete();
            //Photo::where("beneficiaire_id","=",$id)->delete();
            $user = User::find($id);
            
            $user->delete();


       return redirect('/admin/utilisateur');
    }


	     public function edit(Request $request)
	     {
		     $id = $request->id;
		     
	   // $beneficiaireUser = DB::table('beneficiaire_user')->where('id',$id)->first();	
	    $user = User::find($id);
	    //$user = User::find($beneficiaireUser->user_id);	
	   // $userId = DB::table('beneficiaire_user')->select('user_id')->where('id',$id)->first();
	    
	    //$user = DB::table('users')->select('email')->where('id',$userId)->first();
	   
            return view('user.edit')->with(['user'=>$user,"id"=>$id]);
	    //var_dump($beneficiaireUser);
	     }


	public function create()
    {    
	    return view('user.add');

             }





	    public function update(Request $request){


		 

		    $user = User::find($request->id);
		    $userCheck = User::whereEmail($request->email)->where('id', '<>', $request->id)->first();
		    if($userCheck == null){
		    
			    $user->email = $request->email;
			    if(!empty($request->password)){
                    $user->password = bcrypt($request->password);}
                    $user->lastname = $request->lastname;
                    $user->firstname = $request->firstname;
                    $user->city = $request->city;
                    $user->save();
		    }
		    else{
		    return 'email existant';
		    }
		    //var_dump($beneficiaireUser);	

			
		     return redirect('/admin/utilisateur');



	    
	    }	


		public function store(Request $request){

		   
		    
		    $checkUser = User::whereEmail($request->email)->first();

                    if($checkUser==null){
			//return $checkUser->email;
                        $user = new User;

                    $user->email = $request->email;
                    $user->password = bcrypt($request->password);
                    //$user->verifie = $request->verifie;
                    $user->city = $request->city;
                    $user->lastname = $request->lastname;
                    $user->firstname = $request->firstname;
                    $user->type = $request->type;
                    $user->save();

                }else{

			return 'email existant';

		}
                        
                     return redirect('/admin/utilisateur');


		}







public function export(){

        $now = Carbon::now();
        //Excel::import(User::all(), 'users.xlsx');
        return Excel::download(new Export4, 'utilisateursParrains_'.$now->toDateTimeString().'.xlsx');

    }

public function export2(){

        $now = Carbon::now();
        //Excel::import(User::all(), 'users.xlsx');
        return Excel::download(new Export5, 'utilisateurs_'.$now->toDateTimeString().'.xlsx');

}
public function pdf()
{

	$now = Carbon::now();

	$users = User::join('beneficiaire_user','beneficiaire_user.user_id','=','users.id')
                    ->select('users.id','users.email',"users.verifie","users.lastname",'users.firstname','users.description','users.provider')
                    ->distinct('users.id')
                    ->get();
		view()->share('users',$users);
		$pdf = PDF::loadView('user.userPdf', $users);
		return $pdf->stream('parrains_'.$now->toDateTimeString().'.pdf');
	/*$now = Carbon::now();
     //$pdf = \App::make('dompdf.wrapper');
	    //$pdf->loadHTML($this->convert_customer_data_to_html());
	   $users = User::join('beneficiaire_user','beneficiaire_user.user_id','=','users.id')
                    ->select('users.id','users.email',"users.verifie","users.lastname",'users.firstname','users.description','users.provider')
                    ->distinct('users.id')
		    ->get();
	    view()->share('users',$users);
	    $pdf = PDF::loadView('user.userPdf',$users);
	    return $pdf->download('parrains_'.$now->toDateTimeString().'.pdf');*/
    }

/*public function pdf2()
{

        $now = Carbon::now();

        $users = User::select('users.id','users.email',"users.verifie","users.lastname",'users.firstname','users.description','users.provider')
                    ->distinct('users.id')
                    ->get();
                view()->share('users',$users);
                $pdf = PDF::loadView('user.userPdf', $users);
                return $pdf->stream('parrains_'.$now->toDateTimeString().'.pdf');
        
}*/




}
