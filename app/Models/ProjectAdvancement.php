<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectAdvancement extends Model
{
	protected $table = 'project_real_advancement';
	// protected $primaryKey = 'id';
	protected $guarded = ['id'];
	// protected $hidden = ['id'];
	protected $fillable = ['project_id','type','title','description',"image","language_id"];
	public $timestamps = true;
	
}
