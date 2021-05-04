<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBeneficiaireLike extends Model
{
	protected $table = 'user_beneficiaire_like';
	// protected $primaryKey = 'id';
	protected $guarded = ['id'];
	// protected $hidden = ['id'];
	protected $fillable = ['beneficiaire_id','user_id'];
	public $timestamps = true;

}
