<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Project extends Model
{
	use CrudTrait; 
	
    protected $table = 'projects';
	protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];
    protected $fillable = ['reference','image', 'status', 'needed','collected'];
	
	/*public function setImageAttribute($value) {
        $attribute_name = "image";
        $disk = "uploads";
        $destination_path = "project/images";
        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
	}*/

        public function project_media()
    {
        return $this->hasMany(ProjectMedia::class,'project_id');

    }
        public function project_advancement()
    {
        return $this->hasMany(ProjectAdvancement::class,'project_id');

    }
       public function project_translates()
    {
        return $this->hasMany(ProjectTranslate::class,'project_id');

    }
 

}
