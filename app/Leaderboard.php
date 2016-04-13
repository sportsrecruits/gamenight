<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leaderboard extends Model
{
    //
    public $table = "leaderboard";
    public $timestamps = false;
    
    public function scopeUserDay ($query, $user_id, $competition_id) {
	    return $query->where('user_id','=',$user_id)->where('competition_id','=',$competition_id);
    }
    
    public function user () {
	    return $this->belongsTo('\App\User');
    }
}
