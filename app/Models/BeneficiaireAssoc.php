<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeneficiaireAssoc extends Model
{
    //public $timestamps=true;
	protected $table = 'beneficiaires_assoc';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];
    protected $fillable = ['birthday','handicape','sex','weight','length','Last_school_note','image','lat','lng','type','city_id','handicape','house_price'];

	public function images_beneficiaire()
    {
        return $this->hasMany(Photo::class);
 
    }
	public function walls_beneficiaire()
    {
        return $this->hasMany(WallsBeneficiaire::class);
 
    }
	public function beneficiaire_translate()
    {
        return $this->hasMany(Beneficiairetranslate::class,"beneficaire_id");
 
    }

     public function notes_beneficiaire()
    {
        return $this->hasMany(BeneficiaireNote::class,"beneficiaire_id");

    }

	 public function handicape_beneficiaire()
    {
        return $this->hasMany(BeneficiaireHandicapeTranslate::class,"beneficiaire_id");

    }

}
