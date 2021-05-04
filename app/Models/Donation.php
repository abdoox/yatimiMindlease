<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Donation extends Model
{
	use CrudTrait; 
	
    protected $table = 'donations';
	protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];
    protected $fillable = ['transaction_id','currency','montant',"project_id","updated_at","created_at"];
    
}
