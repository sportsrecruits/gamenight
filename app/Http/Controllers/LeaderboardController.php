<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
use Session;

class LeaderboardController extends Controller
{
    //
        
    public function index () {
		// make sure there is a competition for today 
		if ($competition = \App\Competition::where('created_at', '>', Carbon::today('America/New_York'))->first()) {
			
		} else {
			$competition = new \App\Competition;
			$competition->save();
		}	
		
	    // lets display this thing
// 	    $leaderboard = \App\Leaderboard::where('competition_id','=',$competition->id)->orderBy('points_total', 'desc')->with('user')->get();
	    $leaderboard = \App\Leaderboard::where('competition_id','=',$competition->id)->orderBy('points_total', 'desc')->with('user')->get();


// dd($leaderboard);		
		$matches = \App\Match::where("locked_winner_match_team_id",'=', 0)->where("competition_id","=",$competition->id)->with('game')->get();
	    
	    return view('leaderboard', array('message' => Session::get('message'), 'leaderboard' => $leaderboard, 'matches' => $matches, 'tab' => 'leaderboard'));
    }
}
