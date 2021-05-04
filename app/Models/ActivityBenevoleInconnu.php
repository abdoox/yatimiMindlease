<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class ActivityBenevoleInconnu extends Model
{
        use CrudTrait;

    protected $table = 'activite_benevole_inconnu';
        //protected $primaryKey = 'id';
    public $timestamps = true;
    //protected $guarded = ['id'];
    //protected $fillable = ['title','description','project_id','language_id'];

    /**
     * Get the project that owns the translate.
     */

}
