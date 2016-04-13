<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatchTeamsUser extends Model
{
    //
	protected $fillable = ['team_id', 'user_id'];
	public $timestamps = false;
	
    public function team () {
	    return $this->belongsTo('\App\MatchTeam');
    }
    
    public function user () {
	    return $this->hasOne('\App\User', 'id', 'user_id');
    }

}
