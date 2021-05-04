<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
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

//---------Models--------
use App\User;
use App\Models\BeneficiaireUser;
use App\Models\Beneficiaire;
use App\Models\Country;
use App\Models\City;
use App\Models\Language;
use App\Models\WallsBeneficiaire;
use App\Models\UserBeneficiaireLike;
use App\Models\News;
use App\Models\Page;
use App\Models\Activity;
use App\Models\Project;
use App\Models\ProjectTranslate;
use App\Models\ActivityBenevole;



class contentController extends Controller
{
	public function news(Request $request) {
		$label = $request->label;
     	$language = Language::where('label','=',$label)->first();
     	if($language)
     	{ 
			$news = News::where('language_id','=',$language->id)->orderBy('created_at', 'desc')->paginate(5);
			return response()->json(compact('news'));
		}
	}



	 public function benevole(Request $request) {
		 
		 
		 $user = auth()->user();
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


	 public function activities(Request $request) {
                $label = $request->label;
        $language = Language::where('label','=',$label)->first();
        if($language)
        {
		$activities = Activity::with(['activity_media', 'activity_translate' => function($q) use($language) {

                                        $q->where('language_id', '=', $language->id);
                 }])
			//->join('activite_translate','activite_translate.activite_id','activites.id')
			//->where('activite_translate.language_id',$language->id)
			
				->get();

		return response()->json(compact('activities'));
                }
        }






	
	public function page(Request $request) {

		$label = $request->label;
	        $language = Language::where('label','=',$label)->first();
		$page = Page::where('slug','=',$request->slug)->where('language_id',$language->id)->first();
		return response()->json(compact('page'));
	}

	public function projects(Request $request) {
		$label = $request->label;
     	$language = Language::where('label','=',$label)->first();
     	if($language) {
     		$projects = ProjectTranslate::select('projects.id as id', 'reference', 'title', 'description', 'collected', 'needed', 'image')->join('projects', 'projects.id', '=', 'project_translates.project_id')->where("language_id", "=", $language->id)->orderBy('projects.created_at', 'desc')->get();
			return response()->json(compact('projects'));
     	}
	}


	public function allprojects(Request $request) {
                $label = $request->label;
        $language = Language::where('label','=',$label)->first();
        if($language) {
		 $projects = Project::with(['project_media', 'project_advancement' => function($q) use($language) {

                                        $q->where('language_id', '=', $language->id);
		 }])
			->join('project_translates','projects.id','=','project_translates.project_id')
			->select('projects.id', 'advancement','reference', 'title', 'project_translates.description', 'collected', 'needed', 'image')
			//->join('projects', 'projects.id', '=', 'project_translates.project_id')
			//->join('projects_media','projects_media.project_id','=','project_translates.project_id')
			//->join('project_real_advancement','project_real_advancement.project_id','=','project_translates.project_id')
->where("language_id", "=", $language->id)->orderBy('projects.created_at', 'desc')->take(10)->get();
                        return response()->json(compact('projects'));
        }
        }


	
}
