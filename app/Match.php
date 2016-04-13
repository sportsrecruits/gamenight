<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    //
    protected $fillable = ['locked_winner_match_team_id'];
    
    public function teams () {
	    return $this->hasMany('App\MatchTeam');
    }
    public function game () {
	    return $this->belongsTo('App\Game');
    }
    public function competition () {
	    return $this->belongsTo('App\Competition');
    }
    public function matchWinners () {
	    return $this->hasMany('App\MatchWinner', 'match_id', 'id');
    }
    
/*
    public function declareWinner ($team_id) {
	    // record into match winners
	    // count match winners 
	    // if enough match winners
	    	// record winning team into matches as locked_winner_match_team_id
	    	// disperse points according to match's game 
    }
*/
}
