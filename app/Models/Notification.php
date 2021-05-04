<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    //public $timestamps=true;
	protected $table = 'notifications';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];
    protected $fillable = ['title','description','user_id','image','lu'];

	public function user_notification()
    {
        return $this->belongsTo('App\User', "user_id");
    }
}
