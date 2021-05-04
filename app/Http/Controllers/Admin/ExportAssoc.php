<?php  

namespace App\Http\Controllers\admin;

use  App\Models\Beneficiaire;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportAssoc implements FromCollection, WithHeadings
{
    public function collection()
    {
	    $association = auth("associations")->user();

	    return beneficiaire::join('beneficiaire_translate','beneficiaires.id','=','beneficiaire_translate.beneficaire_id')
		    ->join('associations','beneficiaires.association_id','associations.id')
		    ->join('association_translate','association_translate.association_id','associations.id')
		    ->join('cities_translate','cities_translate.city_id','beneficiaires.city_id')
			->select('beneficiaires.id','birthday','sex','first_name','last_name','beneficiaires.created_at','father_name','mother_name','mother_phone','mother_death_date','brothers_number','father_birthday','death_date','type','handicape','beneficiaire_translate.address','dream','age','house_type','house_price')
		    		->where("beneficiaire_translate.language_id",2)
				->where("association_translate.language_id",2)
				->where("associations.id",$association->id)
				->where("cities_translate.language_id",2)
                         ->orderBy('beneficiaires.id', 'ASC')			 
		    ->get();
    }
    public function headings() : array
	        {
			        return ["id", "date d'anniversaire", "genre","prénom","nom","date de création","père","mère","téléphone mère","date décès mère","nombre des frères","anniversaire père","date décès père","type (0 : père décédé, 1 : parents décédés)","état de santé( 1 : handicapé, 0 : normal)","adresse","rêve","âge","type logement","prix logement"];
    }
}

