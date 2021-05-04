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
use App\Models\News;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
	    return view('dashboard');
 	    
        
    }

    /*public function store_media(Request $request) {

		
	    	$file = request()->image;
		$filename = time().'.'.$file->getClientOriginalExtension();
		$mime = mime_content_type($file->path());
		$image = New Media;
		
			if(strstr($mime, "video/")){


            
            		$image->type="video";	



			}else if(strstr($mime, "image/")){
				
		$image->type="photo";		
		$img = Image::make($file->path());              
                $img->save(public_path('uploads').'/'. $filename);	

			}

		$file->move(public_path('uploads/'), $filename);
		$image->url=$filename;
		$image->project_id = $request->id;
		$image->save();


		 $donations = Donation::where("project_id", "=", $request->id)->distinct('email')->get();
			
		if($donations != null) {
			foreach($donations as $donation){
				
				$user = User::whereEmail($donation->email)->first();
				//return $user;
				$user_id = $user->id;		
				$title = "ﻲﺘﻴﻤﻳ";
                		
				$description = "ﻪﻧﺎﻛ ﺝﺪﻳﺩ ﻊﻟﻯ ﻢﻧ ﺖﻜﻔﻟﻮﻧ ... ﺖﺟﺩﻮﻨﻫ ﻒﻳ ﺲﺟﻼﺗ ﺺﻏﺍﺮﻜﻣ.";
				//return $user_id;	
                         	$this->sendNotification($title, $description, $user_id);
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
                                $user_id = $user->id;
                                $title = "ﻲﺘﻴﻤﻳ";
				//return $user;
                                $description = "ﻪﻧﺎﻛ ﺝﺪﻳﺩ ﻊﻟﻯ ﻢﻧ ﺖﻜﻔﻟﻮﻧ ... ﺖﺟﺩﻮﻨﻫ ﻒﻳ ﺲﺟﻼﺗ ﺺﻏﺍﺮﻜﻣ.";
                                //return $user_id;
                                $this->sendNotification($title, $description, $user_id);
                        }
                        //return $user;
        }
        
                return redirect('/admin/project/edit/'.$request->id);
                //return view('beneficiaire.add_wall', compact('id'));
     }*/

    
     public function store(Request $request) {
		

	     $new = new News;

	     $new->title = $request->post('title');
	     $new->detail = $request->post('detail');
	     $new->language_id=2;
	     if(request()->image !=null){
	     $file  = request()->image;
             $filename = time().'.'.$file->getClientOriginalExtension();
                request()->image->move(public_path('uploads/images'), $filename);

             $new->image='images/'.$filename; 
	     }
	     $new->save(); 	     


	     $this->sendNotificationToAll("notif all", "test notif all");	   
	     /*
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
             */

        return redirect('/admin/news');
    }

    public function create()
    {
		     	return view('news.add');
    }



    public function edit($id)
    {    
        $news = News::whereId($id)->first();

        return view('news.edit', compact('news'));
    }
	
	public function destroy($id)
    {
    	
		//Beneficiairetranslate::where("beneficaire_id","=",$id)->delete();
	    //Photo::where("beneficiaire_id","=",$id)->delete();
	    $beneficiaire = News::find($id);
	    
	    $beneficiaire->delete();

        
        return redirect('/admin/news');
    }

   
    
    public function update(Request $request)
    {
		
		$news = News::find($request->post('id'));
		if($news){
	     	$news->title = $request->post('title');
             	$news->detail = $request->post('detail');
	     
		/*$news->deadline = $request->post('deadline');
             	$project->needed = $request->post('needed');
             	$project->collected = $request->post('collected');*/

             	$file  = request()->image;  

			if(isset(request()->image) && !empty(request()->image)){
				$filename = time().'.'.request()->image->getClientOriginalExtension();
				request()->image->move(public_path('uploads/news/images'), $filename);

				$news->image = 'news/images/' . $filename;
				

    			
			}
			
			$news->save();
			
			return redirect('/admin/news');
		}
		
       return redirect('/admin');
    }

    /*public function create_advancement($id, Request $request) {
		return view('project.add_advancement', compact('id'));
    }

    
    public function destroy_advancement($id, Request $request) {
		//return view('beneficiaire.add_wall', compact('id'));
		$wall = WallsBeneficiaire::find($id);
		$id = $wall->beneficiaire_id;
		$wall->delete();
        
        return redirect('/admin/project/edit/'.$id);
    }*/


    public function sendNotificationToAll($title, $description) {
        
        
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

	

       
            $tokens = User::select('device_token')->get();
	
	    $tokensArray = $tokens->toArray();
	  
            $downstreamResponse = FCM::sendTo($tokensArray, $option, $notification, $data);
          
        }
    
    //
		//$walls=WallsBeneficiaire::where('beneficiaire_id','=',$request->beneficiaire_id)->get();

    
}
