<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Activity extends Model
{
	use CrudTrait; 
	
    protected $table = 'activites';
	protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];
    protected $fillable = ['date',"updated_at","created_at"];
	
	/*public function setImageAttribute($value) {
        $attribute_name = "image";
        $disk = "uploads";
        $destination_path = "news/images";
        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
	}*/
	
	public function activity_benevole()
    {
        return $this->hasMany(ActivityBenevole::class,'activite_id');

	}

    	public function activity_media()
    {
        return $this->hasMany(ActivityMedia::class,'activite_id');

    }
	public function activity_translate()
    {
        return $this->hasMany(ActivityTranslate::class,'activite_id');

    }

}
