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

	public function save(array $options = array())
	{
	    if(empty($this->id)) {
	        $this->style = rand(1,26);
	    }
	    return parent::save($options);
	}
}
