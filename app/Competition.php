<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    //
    public function matches () {
	    return $this->hasMany('App\Match');
    }
    
}
