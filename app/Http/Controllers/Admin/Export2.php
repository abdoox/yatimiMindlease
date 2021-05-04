<?php 
namespace App\Http\Controllers\admin;

use  App\Models\Beneficiaire;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Export2 implements FromCollection, WithHeadings
{
	    public function collection()
		        {
				            return beneficiaire::join('beneficiaire_translate','beneficiaires.id','=','beneficiaire_translate.beneficaire_id')
						    ->where("beneficiaire_translate.language_id",2)->where('isfree',1)
						     
						                             ->orderBy('beneficiaires.id', 'ASC')
									                         
									                    ->get();
					        }
	        public function headings() : array
			                {
						                                return ["id", "birthday", "sex","weight","length","created_at","updated_at","image","image_blur","nb_likes","association_id","mother_phone","mother_death_date","brothers_number","father_birthday","death_date","isfree","Last_school_note","lat","lng","type","handicape","house_price","last_name","first_name","father_name","mother_name","leisure","address","biography","school_level","beneficaire_id","language_id","dream","city","age","last_school_name","house_type"];
										    }
}
