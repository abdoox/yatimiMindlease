<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

use App\User;
use App\Models\Beneficiaire;
use App\Models\Project;
use App\Models\Paiement;
use App\Models\Donation;
use App\Models\City;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class StatsController extends CrudController
{
	public function index()
    {
	$usersCount = User::get()->count();
	
	
	$usersParrainsCount = User::join('beneficiaire_user','beneficiaire_user.user_id','=','users.id')->where('status','validé')->distinct('user_id')->count('users.id');

	
	$installations = 5364;

	
	$beneficiaireCount = Beneficiaire::get()->count();


	$cities = City::join('cities_translate','cities.id','=','cities_translate.city_id')
		->where('language_id',1)
		->select('cities.id','cities_translate.label')
		->get()
		//->keyBy('cities.id')
		->toArray();

	//dd($cities);

	$villeBeneficiaires = DB::table('beneficiaires')
                 ->select('city_id', DB::raw('count(*) as total'))
                 ->groupBy('beneficiaires.city_id')
		 ->take(5)
		 ->get()
		 ->sortByDesc('total')
		 ->toArray();
	//dd ($villeBeneficiaires);
	/*$villeBeneficiairesParraines = DB::table('beneficiaires')
		 ->where('isfree',0)
                 ->select('city_id', DB::raw('count(*) as total'))
		 ->groupBy('beneficiaires.city_id')
		 ->take(5)
		 ->get()
		 ->sortByDesc('total')
		 ->toArray();*/
//	dd($villeBeneficiaires);
	
	$sizeCities = count($cities);
	
	$sizeBenefCities = count($villeBeneficiaires);

	$villeBeneficiairesResult = array();
	
	$villeTemp = array();
	for($i = 0 ; $i < $sizeBenefCities ; $i++){
		for( $j = 0; $j < $sizeCities ; $j++)	
		{
		if($villeBeneficiaires[$i]->city_id == $cities[$j]['id'])
	
		{
			$villeTemp = ['city'=>$cities[$j]['label'],'total'=>$villeBeneficiaires[$i]->total];		
	

		}
		//array_push($villeBeneficiairesResult, $villeTemp);
	
		}
	array_push($villeBeneficiairesResult, $villeTemp);
	}

	$villeBeneficiairesResult = collect($villeBeneficiairesResult)->sortBy('total')->reverse()->toArray();

//	dd($villeBeneficiairesResult);
	$now = Carbon::now();
	$paiement = Paiement::whereYear('created_at','=',$now->year)->whereMonth('created_at','=',$now->month)->sum('montant');
	$donation = Donation::whereYear('created_at','=',$now->year)->whereMonth('created_at','=',$now->month)->sum('montant');

	$now1 = $now->subMonth();
	$paiement1 = Paiement::whereYear('created_at','=',$now1->year)->whereMonth('created_at','=',$now1->month)->sum('montant');
	$donation1 = Donation::whereYear('created_at','=',$now1->year)->whereMonth('created_at','=',$now1->month)->sum('montant');

	$now2 = $now1->subMonth();
	$donation2 = Donation::whereYear('created_at','=',$now2->year)->whereMonth('created_at','=',$now2->month)->sum('montant');
	$paiement2 = Paiement::whereYear('created_at','=',$now2->year)->whereMonth('created_at','=',$now2->month)->sum('montant');
	
	$now3 = $now2->subMonth();
	$donation3 = Donation::whereYear('created_at','=',$now3->year)->whereMonth('created_at','=',$now3->month)->sum('montant');
	$paiement3 = Paiement::whereYear('created_at','=',$now3->year)->whereMonth('created_at','=',$now3->month)->sum('montant');
	
	$now4 = $now3->subMonth();
	$donation4 = Donation::whereYear('created_at','=',$now4->year)->whereMonth('created_at','=',$now4->month)->sum('montant');	
	$paiement4 = Paiement::whereYear('created_at','=',$now4->year)->whereMonth('created_at','=',$now4->month)->sum('montant');

	$now5 = $now4->subMonth();
	$donation5 = Donation::whereYear('created_at','=',$now5->year)->whereMonth('created_at','=',$now5->month)->sum('montant');
	$paiement5 = Paiement::whereYear('created_at','=',$now5->year)->whereMonth('created_at','=',$now5->month)->sum('montant');

	$now6 = $now5->subMonth();
	$donation6 = Donation::whereYear('created_at','=',$now6->year)->whereMonth('created_at','=',$now6->month)->sum('montant');
	$paiement6 = Paiement::whereYear('created_at','=',$now6->year)->whereMonth('created_at','=',$now6->month)->sum('montant');

	$now7 = $now6->subMonth();
	$donation7 = Donation::whereYear('created_at','=',$now7->year)->whereMonth('created_at','=',$now7->month)->sum('montant');
	$paiement7 = Paiement::whereYear('created_at','=',$now7->year)->whereMonth('created_at','=',$now7->month)->sum('montant');

	$now8 = $now7->subMonth();
	$donation8 = Donation::whereYear('created_at','=',$now8->year)->whereMonth('created_at','=',$now8->month)->sum('montant');
	$paiement8 = Paiement::whereYear('created_at','=',$now8->year)->whereMonth('created_at','=',$now8->month)->sum('montant');

	$now9 = $now8->subMonth();
	$donation9 = Donation::whereYear('created_at','=',$now9->year)->whereMonth('created_at','=',$now9->month)->sum('montant');
	$paiement9 = Paiement::whereYear('created_at','=',$now9->year)->whereMonth('created_at','=',$now9->month)->sum('montant');

	$now10 = $now9->subMonth();
	$donation10 = Donation::whereYear('created_at','=',$now10->year)->whereMonth('created_at','=',$now10->month)->sum('montant');
	$paiement10 = Paiement::whereYear('created_at','=',$now10->year)->whereMonth('created_at','=',$now10->month)->sum('montant');

	$now11 = $now10->subMonth();	
	$donation11 = Donation::whereYear('created_at','=',$now11->year)->whereMonth('created_at','=',$now11->month)->sum('montant');
	$paiement11 = Paiement::whereYear('created_at','=',$now11->year)->whereMonth('created_at','=',$now11->month)->sum('montant');

	//return Carbon::now()->year;
	//return $now->year." :  ".$now->month;
	/*$paiement = Paiement::whereYear('created_at','=',$now->year)->whereMonth('created_at','=',02)->sum('montant');
	$paiement1 = Paiement::whereYear('created_at','=',$now1->year)->whereMonth('created_at','=',$now1->month)->sum('montant');
	$paiement2 = Paiement::whereYear('created_at','=',$now2->year)->whereMonth('created_at','=',$now2->month)->sum('montant');
	$paiement3 = Paiement::whereYear('created_at','=',$now3->year)->whereMonth('created_at','=',$now3->month)->sum('montant');
	$paiement4 = Paiement::whereYear('created_at','=',$now4->year)->whereMonth('created_at','=',$now4->month)->sum('montant');
	$paiement5 = Paiement::whereYear('created_at','=',$now5->year)->whereMonth('created_at','=',$now5->month)->sum('montant');
	$paiement6 = Paiement::whereYear('created_at','=',$now6->year)->whereMonth('created_at','=',$now6->month)->sum('montant');
	$paiement7 = Paiement::whereYear('created_at','=',$now7->year)->whereMonth('created_at','=',$now7->month)->sum('montant');
	$paiement8 = Paiement::whereYear('created_at','=',$now8->year)->whereMonth('created_at','=',$now8->month)->sum('montant');
	$paiement9 = Paiement::whereYear('created_at','=',$now9->year)->whereMonth('created_at','=',$now9->month)->sum('montant');
	$paiement10 = Paiement::whereYear('created_at','=',$now10->year)->whereMonth('created_at','=',$now10->month)->sum('montant');
	$paiement11 = Paiement::whereYear('created_at','=',$now11->year)->whereMonth('created_at','=',$now11->month)->sum('montant');
	*/


	$paiementTotal = Paiement::sum('montant');
	$donationTotal = Donation::sum('montant');

	$paiements = [

		"paiementTotal"=>$paiementTotal,
		"paiement"=>$paiement,	
		"paiement1"=>$paiement1,
		"paiement2"=>$paiement2,
		"paiement3"=>$paiement3,
		"paiement4"=>$paiement4,
		"paiement5"=>$paiement5,
		"paiement6"=>$paiement6,
		"paiement7"=>$paiement7,
		"paiement8"=>$paiement8,
		"paiement9"=>$paiement9,
		"paiement10"=>$paiement10,
		"paiement11"=>$paiement11,
		"paiementYear"=>$paiement + $paiement1 + $paiement2 + $paiement3 + $paiement4 + $paiement5 + $paiement6 + $paiement7 + $paiement8 + $paiement9 + $paiement10 + $paiement11
	
	]; 

	$donations = [

		"donationTotal"=>$donationTotal,
                "donation"=>$donation,
                "donation1"=>$donation1,
                "donation2"=>$donation2,
                "donation3"=>$donation3,
                "donation4"=>$donation4,
                "donation5"=>$donation5,
                "donation6"=>$donation6,
                "donation7"=>$donation7,
                "donation8"=>$donation8,
                "donation9"=>$donation9,
                "donation10"=>$donation10,
                "donation11"=>$donation11,
		"donationYear"=>$donation + $donation1 +$donation2 +$donation3 +$donation4 +$donation5+$donation6+$donation7+$donation8+$donation9+$donation10+$donation11

	];
	//$a = ["paiements"=>$paiements, "donations"=>$donations];
	//dd($a);
	$beneficiaireGarconCount = Beneficiaire::where('sex','M')->get()->count();
	
	$beneficiaireFilleCount = Beneficiaire::where('sex','F')->get()->count();

	$garconPercent = (double)($beneficiaireGarconCount / $beneficiaireCount) * 100;

	$fillePercent = (double)($beneficiaireFilleCount / $beneficiaireCount) * 100;





	$beneficiaireParraineCount = Beneficiaire::join('beneficiaire_user','beneficiaire_user.beneficiaire_id','=','beneficiaires.id')->where('status','validé')->distinct('beneficiaire_id')->count('beneficiaires.id');

	$beneficiaireNonParraineCount = $beneficiaireCount - $beneficiaireParraineCount;


	$beneficiaireParrainePercent = (double)($beneficiaireParraineCount / $beneficiaireCount) * 100;


	$beneficiaireNonParrainePercent = (double)($beneficiaireNonParraineCount / $beneficiaireCount) * 100;



		
	

	$projectsCount = Project::get()->count();
	//return $projectsCount;
	//$projectsOpenedCount = Project::where('status','open')->get()->count();

	$projectsCollectedCount = Project::whereColumn('collected','>=','needed')->where('status','open')->get()->count();

	$projectsClosedCount = Project::where('status','closed')->get()->count();
	$projectsNotCollectedCount = Project::whereColumn('collected','<','needed')->get()->count();

//	dd($villeBeneficiairesResult);


	//return $villeBeneficiairesResult;
	$results = [
		"projectsCount" => $projectsCount,
		//"projectsOpenedCount"=>$projectsOpenedCount,
		"projectsCollectedCount"=>$projectsCollectedCount,
		"projectsNotCollectedCount"=>$projectsNotCollectedCount,
		"projectsClosedCount"=>$projectsClosedCount,
		"usersCount" => $usersCount,
		"usersParrainsCount" => $usersParrainsCount,
		"installations" => $installations,
		"beneficiaireCount" => $beneficiaireCount,
		"beneficiaireGarconCount" => $beneficiaireGarconCount,
		"beneficiaireFilleCount" => $beneficiaireFilleCount,
		"garconPercent" => $garconPercent,
		"fillePercent" => $fillePercent,	
		"beneficiaireParraineCount" => $beneficiaireParraineCount,
		"beneficiaireNonParraineCount" => $beneficiaireNonParraineCount,
		"beneficiaireParrainePercent" => $beneficiaireParrainePercent,
		"beneficiaireNonParrainePercent" => $beneficiaireNonParrainePercent,
		"paiements"=>$paiements,
		"donations"=>$donations,
		"villeBeneficiairesResult"=>$villeBeneficiairesResult
		//"villeBeneficiairesParraines"=>$villeBeneficiairesParraines
	];

	//return $results;
	return view('dashboard',compact('results'));






    }
}
