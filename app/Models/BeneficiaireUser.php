<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeneficiaireUser extends Model
{
    protected $table = 'beneficiaire_user';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];

	protected $fillable = ['id','user_id','beneficiaire_id','type','montant','status','date_fin','motif_id'];
//public $timestamps =flase;
}
