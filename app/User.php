<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;
use Auth;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'avatar',
    ];
	protected $guarded = ['id'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function match_teams_user () {
	    return $this->hasMany('\App\MatchTeamsUser');
    }

/* THESE ARE NOT WORKING
    public function teams () {
		$teams = DB::table('match_teams_users')->where('user_id', Auth::user()->id)
									->join('match_teams', 'match_teams.id', '=', 'match_teams_users.team_id')
									->select('match_teams.id')
									->get();
		return \App\MatchTeam::whereRaw('id IN ' . array_get($teams, 'id'))->get();	    
    }
    public function matches () {
		$matches = DB::table('match_teams_users')->where('user_id', Auth::user()->id)
									->join('match_teams', 'match_teams.id', '=', 'match_teams_users.team_id')
									->select('match_teams.match_id')
									->get();		    
		return \App\Match::whereRaw('id IN ' . array_get($matches, 'match_id'))->get();	    
    }
*/
    
    public function leaderboard () {
	    return $this->hasMany('\App\Leaderboard');
    }

	public function getFirstName () {
		return explode(' ', $this->name)[0];
	}   
	
	 
//    AlluserMatches()
    
}
