<?php

namespace App\Http\Controllers\admin;

use  App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Export4 implements FromCollection, WithHeadings
{
    public function collection()
    {
	    return User::join('beneficiaire_user','beneficiaire_user.user_id','=','users.id')
		    ->select('users.id','users.email',"users.verifie","users.lastname",'users.firstname','users.description','users.provider')
		    ->where('status','validé')
		    ->distinct('users.id')
                    ->get();
    }
    public function headings() : array
                {
                                return ["id", "email", "compte verifié","lastname","firstname","description","réseau"];
    }
}


