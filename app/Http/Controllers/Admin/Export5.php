<?php

namespace App\Http\Controllers\admin;

use  App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Export5 implements FromCollection, WithHeadings
{
    public function collection()
    {
            return User::select('users.id','users.email',"users.verifie","users.lastname",'users.firstname','users.description','users.provider')
                    ->distinct('users.id')
                    ->get();
    }
    public function headings() : array
                {
                                return ["id", "email", "compte verifié","lastname","firstname","description","réseau"];
    }
}
