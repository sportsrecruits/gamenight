<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatchTeam extends Model
{
    //
	protected $fillable = ['name']; 
	public $timestamps = false;
	   
    public function users () {
	    return $this->hasMany ('\App\MatchTeamsUser', 'team_id');
    }
    public function match () {
	    return $this->belongsTo ('\App\Match');
    }
}
