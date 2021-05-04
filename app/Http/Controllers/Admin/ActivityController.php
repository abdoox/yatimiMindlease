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
use App\Models\ActivityTranslate;
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
use App\Models\Activity;
use App\Models\ActivityMedia;
use App\Models\ActivityBenevole;
use App\Models\ActivityBenevoleInconnu;

class ActivityController extends Controller
{
      

	public function benevoles(){

		$activities = ActivityBenevole::join('users','users.id','activite_benevole.user_id')
			->select('users.id','firstname','lastname','activites','freetime','email','adresse')
			->get();
		//	return $activities;
		
		//return $activities2;
		return view('benevoles.list', compact(['activities']));
	
	}
	  public function benevoles2(){

                
                //      return $activities;
                $activities2 = ActivityBenevoleInconnu::all();
                //return $activities2;
                return view('benevoles2.list', compact(['activities2']));

        }




	public function index(Request $request)
    {
//		use App\Models\Donation;
	    $activities = Activity::join('activite_translate','activites.id','activite_translate.activite_id')
		    ->where('language_id',2)
		    ->select('activites.id','activites.date','activite_translate.titre','activites.image','activite_translate.description')
			->get();
	    //return $activities;
	    //$projects2 = project::with(['project_media','project_advancement'])->whereColumn('needed','<=','collected')->get();
	    //return $projects2;	
	    return view('activities.list', compact(['activities']));
 	    
        
    }

    public function store_media(Request $request) {

		
	    	$file = request()->image;
		$filename = time().'.'.$file->getClientOriginalExtension();
		$mime = mime_content_type($file->path());
		
		$activity = Activity::find($request->id);


		if($activity){

		$activityMedia  =new  ActivityMedia;

		$activityMedia->activite_id = $request->id;	
			if(strstr($mime, "video/")){


            
            		$activityMedia->type="video";	



			}else if(strstr($mime, "image/")){
				
		$activityMedia->type="image";		
		

			}

		$file->move(public_path('uploads/'), $filename);
		$activityMedia->url=$filename;
		//$activity->activite_id = $request->id;
		$activityMedia->save();


	
                        //return $user;
        


		//return $donations;




		return redirect('/admin/activities/edit/'.$request->id);
    }
    }


     public function create_media($id)
    {

                return view('activities.add_media', compact('id'));
    }


     public function destroy_media($id)
    {
                $image = ActivityMedia::find($id);
                $id = $image->activite_id;
                $image->delete();

        return redirect('/admin/activities/edit/'.$id);
    }
	

	
    


     public function store_advancement(Request $request) {
                $wall = New ProjectAdvancement;
                $filename = time().'.'.request()->image->getClientOriginalExtension();

		 $mime = mime_content_type(request()->image->path());
                     if(strstr($mime, "video/")){



                        $wall->type="video";



                        }else if(strstr($mime, "image/")){

                         $wall->type="image";

                        }



		request()->image->move(public_path('uploads/images'), $filename);

                $wall->image = 'images/'.$filename;
                $wall->project_id = $request->id;
                $wall->title = $request->title;
                $wall->description = $request->description;
                $wall->language_id = 2;
                $wall->save();

		$donations = Donation::where("project_id", "=", $wall->project_id)->distinct('email')->get();

                if($donations != null) {
                        foreach($donations as $donation){

                                $user = User::whereEmail($donation->email)->first();
                                //return $user;
				if($user != null)

                                {

				$user_id = $user->id;
                                $title = "ﻲﺘﻴﻤﻳ";
				//return $user;
                                $description = "ﻪﻧﺎﻛ ﺝﺪﻳﺩ ﻊﻟﻯ ﻢﻧ ﺖﻜﻔﻟﻮﻧ ... ﺖﺟﺩﻮﻨﻫ ﻒﻳ ﺲﺟﻼﺗ ﺺﻏﺍﺮﻜﻣ.";
                                //return $user_id;
				$this->sendNotification($title, $description, $user_id);
				}
                        }
                        //return $user;
        }
        
                return redirect('/admin/project/edit/'.$request->id);
                //return view('beneficiaire.add_wall', compact('id'));
    }

    
     public function store(Request $request) {
		

	     $project = new Activity;

	     $project->date = $request->post('date');
	     //$project->image = $request->post('image');

	     /*$project->deadline = $request->post('deadline');
	     $project->needed = $request->post('needed');
	     $project->collected = $request->post('collected');*/	         
	     
	     
	     $file  = request()->image;
             $filename = time().'.'.$file->getClientOriginalExtension();
                request()->image->move(public_path('uploads/images'), $filename);

             $project->image='images/'.$filename; 
	     
	     $project->save(); 	     
	



	  
	    
	     $id = $project->id;

	     $projectTranslate_ar = new ActivityTranslate;
	     $projectTranslate_ar->activite_id = $id;
	     $projectTranslate_ar->titre = $request->post('title_ar');
             $projectTranslate_ar->description = $request->post('description_ar');
	     $projectTranslate_ar->language_id = 2;	
	     
	     $projectTranslate_ar->save();


	     $projectTranslate_fr = new ActivityTranslate;
             $projectTranslate_fr->activite_id = $id;
             $projectTranslate_fr->titre = $request->post('title_fr');
             $projectTranslate_fr->description = $request->post('description_fr');
             $projectTranslate_fr->language_id = 1;                     
             
             $projectTranslate_fr->save();


	     $users = User::whereEmail('abdelilahmb55@gmail.com')->first();
	     //$fcm_token = $users->device_token;
		//foreach($users as $user){

	     $title=$request->post('title_ar');
		$description = $request->post('description_ar')."<br/>".$request->post('description_fr');	     
                //$this->sendNotification($title, $description, $users->id,"http://ataaserv.westeurope.cloudapp.azure.com/uploads/images".$filename);
                $this->sendPushNotification($users->device_token, $title, $description,$id, "http://ataaserv.westeurope.cloudapp.azure.com/uploads/images/".$filename);



        return redirect('/admin/activities');
    }

    public function create()
    {
		     	return view('activities.add');
    }



    public function edit($id)
    {    
        $activity = Activity::with(['activity_media', 'activity_translate'])
                        //->join('activite_translate','activite_translate.activite_id','activites.id')
                        //->where('activite_translate.language_id',$language->id)
				->whereId($id)
                                ->first();
	//return $activity;

        return view('activities.edit', compact('activity'));
    }
	
	public function destroy($id)
    {
    	
		//Beneficiairetranslate::where("beneficaire_id","=",$id)->delete();
	    //Photo::where("beneficiaire_id","=",$id)->delete();
	    $beneficiaire = Activity::find($id);
	    
	    $beneficiaire->delete();

        
        return redirect('/admin/activities')->with(['message', 'Record Deleted!']);
    }


   

        
   
    
    public function update(Request $request)
    {

	    
	     $project = Activity::find($request->post('id'));
	   
	//	return $project;
    

	     $project->date = $request->post('date');
             //$project->image = $request->post('image');

             /*$project->deadline = $request->post('deadline');
             $project->needed = $request->post('needed');
             $project->collected = $request->post('collected');*/


	      if(isset(request()->image) && !empty(request()->image)){
             $file  = request()->image;
             $filename = time().'.'.$file->getClientOriginalExtension();
                request()->image->move(public_path('uploads/images'), $filename);

             $project->image='images/'.$filename;
		}
             $project->save();
		



		

             $id = $project->id;


             $projectTranslate_ar = ActivityTranslate::where('activite_id',$id)->where('language_id',2)->first();
             $projectTranslate_ar->titre = $request->post('title_ar');
             $projectTranslate_ar->description = $request->post('description_ar');
             

             $projectTranslate_ar->save();


             $projectTranslate_fr = ActivityTranslate::where('activite_id',$id)->where('language_id',1)->first();
             $projectTranslate_fr->titre = $request->post('title_fr');
             $projectTranslate_fr->description = $request->post('description_fr');
             

             $projectTranslate_fr->save();



        return redirect('/admin/activities');
	
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


    public function sendNotification($title, $description, $user_id) {
        $notification = new Notification;
        $notification->user_id = $user_id;
        $notification->title = $title;
        $notification->description = $description;
	$notification->lu =0;
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
    }
    //
		//$walls=WallsBeneficiaire::where('beneficiaire_id','=',$request->beneficiaire_id)->get();

    



	public function sendPushNotification($fcm_token, $title, $message, $id, $image) {
        	/*$push_notification_key = "AAAAtMwIaQY:APA91bG-LEmpjVW9ih87cuQnOXbMLH-7ohIE424AD_0sSWYeSDHgL637_g1lwv8TWfh8b6z5bpJoWMB5M_ptKYl3cgsRx0GpnEkXNxEIXpWZ6HIWtJxgQgFMGRbJ6tnh4NRvYiE_jeS5";
        	$url = "https://fcm.googleapis.com/fcm/send";
        	$header = array("authorization: key=" . $push_notification_key . "",
            	"content-type: application/json"
        );

        $postdata = '{
            	"to" : "' . $fcm_token . '",
                "notification" : {
                "title":"' . $title . '",
		"body" : "' . $message . '",
		"image" : "' . $image . '",
		"sound" : "default"
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

		return $result;*/


		$url = 'https://fcm.googleapis.com/fcm/send';
        $dataArr = array('click_action' => 'FLUTTER_NOTIFICATION_CLICK', 'id' => $id,'status'=>"done");
        $notification = array('title' =>"Nouvelle Activité | نشاط جديد" .$title, 'body' => $message, 'image'=> $image, 'sound' => 'default', 'badge' => '1',);
        $arrayToSend = array('to' => $fcm_token, 'notification' => $notification, 'data' => $dataArr, 'priority'=>'high');
        $fields = json_encode ($arrayToSend);
        $headers = array (
            'Authorization: key=' . "AAAAtMwIaQY:APA91bG-LEmpjVW9ih87cuQnOXbMLH-7ohIE424AD_0sSWYeSDHgL637_g1lwv8TWfh8b6z5bpJoWMB5M_ptKYl3cgsRx0GpnEkXNxEIXpWZ6HIWtJxgQgFMGRbJ6tnh4NRvYiE_jeS5",
            'Content-Type: application/json'
        );

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

        $result = curl_exec ( $ch );
        //var_dump($result);
        curl_close ( $ch );


//	dd ($result);


    
	}	}
