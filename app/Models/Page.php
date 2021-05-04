<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Page extends Model
{
	use CrudTrait; 
	
    protected $table = 'pages';
	protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];
    protected $fillable = ['title','slug','content'];
	
	
}
