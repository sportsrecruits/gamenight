<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    //
    protected $fillable = ['name', 'points'];
    public $timestamps = false;
    
    public function matches () {
	    return $this->hasMany('App\Match');
    }
}
