<?php  

namespace App\Http\Controllers\admin;

use  App\Models\Beneficiaire;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportAssoc implements FromCollection, WithHeadings
{


    public function collection()
    {
	   // $association = auth("associations")->user();

	    return BeneficiaireUser::join('users','users.id','beneficiaire_user.user_id')
		    ->join("motifs_annulation_parrainage",'motifs_annulation_parrainage.id','motif_id')
		    ->join("motifs",'motifs.id','beneficiaire_user.motif_id')
		    ->select('user_id','email','last_name','first_name','beneficiaire_user.created_at','status','date_fin','motif')
		    //->where('beneficiaire_id', $id)
		   // ->where('status','terminé')
                        ->get();
    }
    public function headings() : array
	        {
			        return ["ID parrain", "Email parrain", "Nom","Prénom","Date de parrainage","État","Date d'annulation","Motif d'annulation"];
    }
}

