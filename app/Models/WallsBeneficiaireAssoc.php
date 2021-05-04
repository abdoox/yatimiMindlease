<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WallsBeneficiaireAssoc extends Model
{
	protected $table = 'walls_beneficiaire_assoc';
	// protected $primaryKey = 'id';
	protected $guarded = ['id'];
	// protected $hidden = ['id'];
	protected $fillable = ['beneficiaire_id','type','title','description',"image","type","language_id"];
	public $timestamps = true;
	
}
