<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class News extends Model
{
	use CrudTrait; 
	
    protected $table = 'news';
	protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];
    protected $fillable = ['title','type','detail','image','language_id',"updated_at","created_at"];
	
	/*public function setImageAttribute($value) {
        $attribute_name = "image";
        $disk = "uploads";
        $destination_path = "news/images";
        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
	}*/
	
	public function language()
	{
                return $this->belongsTo('App\Models\Language');
    }
}
