<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WallsBeneficiaire extends Model
{
	protected $table = 'walls_beneficiaire';
	// protected $primaryKey = 'id';
	protected $guarded = ['id'];
	// protected $hidden = ['id'];
	protected $fillable = ['beneficiaire_id','type','title','description',"image","type","language_id"];
	public $timestamps = true;
	
}
