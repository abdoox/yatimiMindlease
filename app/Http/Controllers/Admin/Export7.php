<?php  

namespace App\Http\Controllers\admin;

use  App\Models\Donation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Export7 implements FromCollection, WithHeadings
{
    public function collection()
    {
	    $paiements = Donation::join('projects','projects.id','=','donations.project_id')
                    ->join('project_translates','project_translates.project_id','=','projects.id')
                    ->select('transaction_id','montant','donations.created_at','email','project_translates.title')
                    ->where('language_id',2)
                    ->orderBy('donations.created_at', 'DESC')
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
			        return ["transaction id", "montant", "date paiement","email","projet"];
    }
}

