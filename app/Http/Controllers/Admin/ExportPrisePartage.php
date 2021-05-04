<?php  

namespace App\Http\Controllers\admin;

use  App\Models\BeneficiaireUser;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportPrisePartage implements FromCollection, WithHeadings
{
    public function collection()
    {
	    return BeneficiaireUser::join('beneficiaire_translate','beneficiaire_user.beneficiaire_id','=','beneficiaire_translate.beneficaire_id')
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
    }
    public function headings() : array
	        {
			        return ["Nom parrain", "Prénom parrain","Montant","Prénom orphelin","Nom orphelin","état de santé (normal : null, handicapé : 1)","date du parrainage","association"];
    }
}

