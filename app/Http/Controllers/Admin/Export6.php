<?php  

namespace App\Http\Controllers\admin;

use  App\Models\Paiement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Export6 implements FromCollection, WithHeadings
{
    public function collection()
    {
	    $paiements =  Paiement::join('users','paiements.user_id','=','users.id')
		    
		    ->select('date_paiement','transaction_id','lastname','firstname','montant','paiements.type','partner_transactionid') 
                    //->orderBy('date_paiement', 'DESC')			 
		    ->get();

	    foreach($paiements as $paiement) 	
	{
			$paiement->transaction_id =' '.$paiement->transaction_id; 
		//	$paiement->save();

	    }
	    return $paiements;
    }
    public function headings() : array
	        {
			        return ["date paiement", "transaction id", "nom","prenom","montant","type","partner_transactionid"];
    }
}

