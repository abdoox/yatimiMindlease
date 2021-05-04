<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class ProjectTranslate extends Model
{
	use CrudTrait; 
	
    protected $table = 'project_translates';
	protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];
    protected $fillable = ['title','description','project_id','language_id'];

    /**
     * Get the project that owns the translate.
     */
    public function project()
    {
        return $this->belongsTo('App\Project');
    }
}
