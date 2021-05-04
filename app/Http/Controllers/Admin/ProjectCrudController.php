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
use App\Models\Donation;


class ProjectCrudController extends Controller
{
    public function index(Request $request)
    {
		
	    $projects  = project::with(['project_media','project_translates'])->orderBy('id', 'DESC')->get();
	   
	    
	    return view('project.list', compact(['projects']));
 	    
        
    }




	public function closed(Request $request)
    	{

            $projects = project::with(['project_media','project_translates'])->where('status','closed')->orderBy('id', 'DESC')->get();

            return view('project.listClosed', compact(['projects']));


    }
	public function inProgress(Request $request)
    	{

            $projects = project::with(['project_media','project_advancement','project_translates'])->whereColumn('needed','>','collected')->where('status','open')->get();

            return view('project.listInprogress', compact(['projects']));


    }
	public function collected(Request $request)
    	{

           
            $projects = project::with(['project_media','project_advancement','project_translates'])->whereColumn('needed','<=','collected')->where('status','open')->get();
            
            return view('project.listCollected', compact(['projects']));


    }














    public function store_media(Request $request) {

		
	    	$file = request()->image;
		$filename = time().'.'.$file->getClientOriginalExtension();
		$mime = mime_content_type($file->path());
		$isVideo = 0;
		$image = New Media;
		
			if(strstr($mime, "video/")){


            
            		$image->type="video";	
			$isVideo = 1;
	

			}else if(strstr($mime, "image/")){
				
		$image->type="image";		
		$img = Image::make($file->path());              
                $img->save(public_path('uploads').'/'. $filename);	

			}

		$file->move(public_path('uploads/'), $filename);
		$image->url='uploads/'.$filename;
		$image->project_id = $request->id;
		$image->save();

		 $donations = Donation::where("project_id", "=", $request->id)->select('email')->distinct()->get();

		 //$donations = Donation::where("project_id", "=", $request->id)->distinct('email')->get();

		$projectTranslate = ProjectTranslate::where('project_id',$request->id)
                                  ->where('language_id',2)
                                  ->first();

		if($donations != null) {
			foreach($donations as $donation){
				
				$user = User::whereEmail($donation->email)->first();
				//return $user;
				if($user != null)
					
				{
				$user_id = $user->id;		
				$title = "yatimi | ﻲﺘﻴﻤﻳ : ".$projectTranslate->title;
                		
				$description = $projectTranslate->title." : Nouveau média";
				//return $user_id;	
				//$this->sendNotification($title, $description, $user_id, "http://ataaserv.westeurope.cloudapp.azure.com/".$image->url);


				 if( $isVideo == 1 ){

                                        $url = "yatimi_bg.jpg";

                                }else{

                                        $url = $image->url;
                                }

					$id = $user_id + $request->id;

                                        $this->sendNotification($id,$title, $description, $user_id, "http://ataaserv.westeurope.cloudapp.azure.com/".$url);




				}
			}
                        //return $user;
        }


		//return $donations;




		return redirect('/admin/project/edit/'.$request->id);
    }
	


     public function create_media($id)
    {

                return view('project.add_media', compact('id'));
    }


     public function destroy_media($id)
    {
                $image = Media::find($id);
                $id = $image->project_id;
                $image->delete();

        return redirect('/admin/project/edit/'.$id);
    }
	

	
    


     public function store_advancement(Request $request) {
                $wall = New ProjectAdvancement;
                $filename = time().'.'.request()->image->getClientOriginalExtension();
		$isVideo = 0;
		 $mime = mime_content_type(request()->image->path());
                     if(strstr($mime, "video/")){



                        $wall->type="video";

			$isVideo = 1;

                        }else if(strstr($mime, "image/")){

                         $wall->type="image";

                        }



		request()->image->move(public_path('uploads/images'), $filename);

                $wall->image = 'uploads/images/'.$filename;
                $wall->project_id = $request->id;
                $wall->title = $request->title;
                $wall->description = $request->description;
                $wall->language_id = 2;
                $wall->save();

		$projectTranslate = ProjectTranslate::where('project_id',$request->id)
				  ->where('language_id',2)
			          ->first();




		$donations = Donation::where("project_id", "=", $wall->project_id)->select('email')->distinct()->get();
	
                if($donations != null) {
                        foreach($donations as $donation){

                                $user = User::whereEmail($donation->email)->first();
                                //return $user;
				if($user != null)

                                {

				$user_id = $user->id;
                                $title = "yatimi | يتيمي : ".$projectTranslate->title;
				//return $user;
                                //$description = "ﻪﻧﺎﻛ ﺝﺪﻳﺩ ﻊﻟﻯ ﻢﻧ ﺖﻜﻔﻟﻮﻧ ... ﺖﺟﺩﻮﻨﻫ ﻒﻳ ﺲﺟﻼﺗ ﺺﻏﺍﺮﻜﻣ.";
                                //return $user_id;
				$description =$wall->description;
				
				if( $isVideo == 1 ){

					$url = "yatimi_bg.jpg";

				}else{

					$url = $wall->image;
				}
					                                        $id = $user_id + $request->id;
					$this->sendNotification($id, $title, $description, $user_id, "http://ataaserv.westeurope.cloudapp.azure.com/".$url);
				
					
				
				}
                        }
                        //return $user;
        }
        
                return redirect('/admin/project/edit/'.$request->id);
                //return view('beneficiaire.add_wall', compact('id'));
    }

    
     public function store(Request $request) {
		

	     $project = new Project;

	     $project->reference = $request->post('reference');
	     $project->status = $request->post('status');
	     $project->deadline = $request->post('deadline');
	     $project->needed = $request->post('needed');
	     $project->collected = $request->post('collected');	         
	     
	     
	     $file  = request()->image;
             $filename = time().'.'.$file->getClientOriginalExtension();
                request()->image->move(public_path('uploads/images'), $filename);

             $project->image='images/'.$filename; 
	     
	     $project->save(); 	     
	



	    



	    
	     $id = $project->id;

	     $projectTranslate_ar = new ProjectTranslate;
	     $projectTranslate_ar->project_id = $id;
	     $projectTranslate_ar->title = $request->post('title_ar');
             $projectTranslate_ar->description = $request->post('description_ar');
	     $projectTranslate_ar->language_id = 2;	
	     
	     $projectTranslate_ar->save();


	     $projectTranslate_fr = new ProjectTranslate;
             $projectTranslate_fr->project_id = $id;
             $projectTranslate_fr->title = $request->post('title_fr');
             $projectTranslate_fr->description = $request->post('description_fr');
             $projectTranslate_fr->language_id = 1;                     
             
             $projectTranslate_fr->save();










        return redirect('/admin/project');
    }

    public function create()
    {
		     	return view('project.add');
    }



    public function edit($id)
    {    
        $project = Project::with(['project_translates'])->whereId($id)->first();

        return view('project.edit', compact('project'));
    }
	
	public function destroy($id)
    {
    	
		//Beneficiairetranslate::where("beneficaire_id","=",$id)->delete();
	    //Photo::where("beneficiaire_id","=",$id)->delete();
	    $beneficiaire = Project::find($id);
	    
	    $beneficiaire->delete();

        
        return redirect('/admin/project');
    }


   

        public function benevoles($id)
    {

                //Beneficiairetranslate::where("beneficaire_id","=",$id)->delete();
            //Photo::where("beneficiaire_id","=",$id)->delete();
            $users = User::join('donations','users.email','=','donations.email')->where('donations.project_id',$id)->get();

           
            return $users;		
	
        //return view('project.benevoles',compact('users'));
    }
   
    
    public function update(Request $request)
    {
		
		$project = Project::find($request->post('id'));
		if($project){
			 $project->reference = $request->post('reference');
             $project->status = $request->post('status');
             $project->deadline = $request->post('deadline');
             $project->needed = $request->post('needed');
             $project->collected = $request->post('collected');
	     if($project->needed >= $project->collected){
	                  $project->advancement = 0;
	     }else{
	     $project->advancement = $request->post('advancement');
		}
             $file  = request()->image;
                  
	     
			if(isset(request()->image) && !empty(request()->image)){
				$filename = time().'.'.request()->image->getClientOriginalExtension();
				request()->image->move(public_path('uploads/images'), $filename);

				$project->image = 'images/' . $filename;
				

    			
			}

	     $project_ar = ProjectTranslate::where('project_id',$request->post('id'))->where('language_id',2)->first();

	     

	     $project_ar->title = $request->post('title_ar');
	     //return $request->post('title_ar');
	     $project_ar->description = $request->post('description_ar');	
	     $project_ar->save();

	     $project_fr = ProjectTranslate::where('project_id',$request->post('id'))->where('language_id',1)->first();
	     $project_fr->title = $request->post('title_fr');
	    // return $request->post('title_fr');
	     $project_fr->description = $request->post('description_fr');
	     $project_fr->save();

			$project->save();

	     if($project->needed <= $project->collected){

		     $donations = Donation::where("project_id", "=", $request->id)->select('email')->distinct()->get();

                if($donations != null) {
                        foreach($donations as $donation){

                                $user = User::whereEmail($donation->email)->first();
                                //return $user;
                                if($user != null)

                                {

                                $user_id = $user->id;
                                $title = "yatimi | يتيمي : "." ".$project_ar->title;
                                //return $user;
                                //$description = "ﻪﻧﺎﻛ ﺝﺪﻳﺩ ﻊﻟﻯ ﻢﻧ ﺖﻜﻔﻟﻮﻧ ... ﺖﺟﺩﻮﻨﻫ ﻒﻳ ﺲﺟﻼﺗ ﺺﻏﺍﺮﻜﻣ.";
                                //return $user_id;
                                $description = "لقد تمت علمية جمع أموال المشروع الذي تطوعتم فيه من قبل";

                               
                                                                                $id = $user_id + $request->id;
                                        $this->sendNotification($id, $title, $description, $user_id, "http://ataaserv.westeurope.cloudapp.azure.com/uploads/".$project->image);



                                }
                        }
                        //return $user;
        }



	     }
			

			return redirect('/admin/project');
		}
		
       return redirect('/admin');
    }

    public function create_advancement($id, Request $request) {
		return view('project.add_advancement', compact('id'));
    }

    
    public function destroy_advancement($id, Request $request) {
		$image = ProjectAdvancement::find($id);
                $id = $image->project_id;
                $image->delete();

        return redirect('/admin/project/edit/'.$id);
    }


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
    //
		//$walls=WallsBeneficiaire::where('beneficiaire_id','=',$request->beneficiaire_id)->get();

    
}
