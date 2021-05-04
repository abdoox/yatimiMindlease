<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Paiement extends Model
{
	use CrudTrait; 
	
    protected $table = 'paiements';
	protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];
    protected $fillable = ['date_paiement','transaction_id','type','user_id','image','montant','status',"updated_at","created_at"];
	
	/*public function setImageAttribute($value) {
        $attribute_name = "image";
        $disk = "uploads";
        $destination_path = "paiement/images";
        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
	}*/
	
	public function user()
    {
        return $this->belongsTo('App\User');
	}
}
