<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBeneficiaireMessage extends Model
{
	protected $table = 'beneficiaire_user_message';
	// protected $primaryKey = 'id';
	protected $guarded = ['id'];
	// protected $hidden = ['id'];
	protected $fillable = ['beneficiaire_id','user_id','message'];
	public $timestamps = true;

}
