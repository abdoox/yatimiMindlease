<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;

class Association extends  Authenticatable
{
   // use CrudTrait; 

	        use Notifiable;

    //public $timestamps=true;
	protected $table = 'associations';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];
    protected $fillable = ['name','email','password','phone','city_id'];

	public function association_translate()
    {
        return $this->hasMany(AssociationTranslate::class,"association_id");
 
    }
}
