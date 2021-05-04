<?php  

namespace App\Http\Controllers\admin;

use  App\Models\BeneficiaireUser;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportPriseEnChargeAssoc implements FromCollection, WithHeadings
{
    public function collection()
    {

	    $association = auth("associations")->user();

	    $beneficiaireUser =  BeneficiaireUser::join('beneficiaire_translate','beneficiaire_user.beneficiaire_id','=','beneficiaire_translate.beneficaire_id')
		   	->join("beneficiaires",'beneficiaire_translate.beneficaire_id','beneficiaires.id') 
			->select('user_id',"beneficiaire_user.beneficiaire_id",'first_name','last_name',"age","sex",'handicape',"beneficiaires.created_at as createdAt","montant",'beneficiaire_user.created_at','beneficiaire_user.date_fin')
		    		->where("beneficiaire_translate.language_id",2)
				
				->where('association_id',$association->id)
				->where('status','validé')
                         ->orderBy('beneficiaires.id', 'ASC')			 	
			 ->get();

	    foreach($beneficiaireUser as $bene){

                    if($bene->handicape == 1)
                    {
                            $bene->beneficiaire_id = "oh- ".$bene->beneficiaire_id;

                    }else{

                            $bene->beneficiaire_id = "o- ".$bene->beneficiaire_id;

                    }

                    $bene->user_id = "p- ".$bene->user_id;


            }


            return $beneficiaireUser;

    }
    public function headings() : array
	        {
			        return ["ID parrain","ID bénéficiaire","Prénom orphelin","Nom orphelin","Âge","sexe","état de santé (normal : null, handicapé : 1)","date de création d'orphelin","montant de parrainage","date du parrainage","date du prochain paiement"];
    }
}

