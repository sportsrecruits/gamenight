<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatchWinner extends Model
{
    //
	protected $fillable = ['match_id', 'user_id', 'winning_team_id'];
// 	protected $guarded = [];	
    public function match () {
	    return $this->belongsTo('App\Match');
    }
    
    public function user () {
	    return $this->belongsTo('App\User', 'id', 'user_id');
    }
    
}
