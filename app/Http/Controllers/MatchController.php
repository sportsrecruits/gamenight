<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use Carbon\Carbon;
use DB;
use Session;

class MatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = array('matches' => \App\Match::with('competition','teams.users', 'game')->where('created_at', '>', Carbon::today('America/New_York'))->where('locked_winner_match_team_id', '=', '0')->get());
 
 
		foreach ($data['matches'] as &$match) {
			$match->user_in_match = false;
			foreach ($match->teams as &$team) {
				if ($team->users->contains('user_id', Auth::user()->id)) {
					$team->user_on_team = true;
					$match->user_in_match = true;
				} else {
					$team->user_on_team = false;
				}
			}
		}

		$data['message'] = Session::get('message');
        $data['games'] = \App\Game::all();
        $data['tab'] = 'matches';

        /*
	     */
	    return view('matches', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
/*
    public function create(Request $request)
    {

    }
*/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		// create a new team using the current user
		$team = new \App\MatchTeam;
		$team->name = Auth::user()->name . "'s Team";
		$team->save();
		$team->users()->save(new \App\MatchTeamsUser(['team_id' => $team->id, 'user_id' => Auth::user()->id]))->save();		
		

		$match = new \App\Match;
		$match->game()->associate(\App\Game::where('id','=',$request->input('game_id'))->first());
		$match->teams()->save($team);
		
		$match->competition()->associate(\App\Competition::where('created_at', '>', Carbon::today('America/New_York'))->first());
		$match->save();
		
		$team->match()->associate($match)->save();
		
		
		// redirect to the match using its named route
		return redirect()->route('match.show', $match->id)->with('message', 'Match Created');

/* Redirect with flash data and how to access
return redirect('form')->withInput(Request::except('password'));

$username = Request::old('username');
*/    
	}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $match = \App\Match::with('teams.users.user','game')->findOrFail($id);
		$my_user_id = Auth::user()->id;
		
		$user_in_match = false;
		foreach ($match->teams as $index => $team) {
			if ($match->teams[$index]->users->contains('user_id', $my_user_id)) {
				$user_in_match = true;
			}
		}

		$have_i_voted = (bool) DB::select('select * from match_winners where user_id = :user_id AND match_id = :match_id', ['user_id' => $my_user_id, 'match_id' => $match->id]);

		return view ('match', array('message' => Session::get('message'), 'match' => $match, 'have_i_voted' => $have_i_voted, 'tab' => 'matches', 'user_in_match' => $user_in_match)); 
    }

    /**
     * Select a winning team for the match
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function win(Request $request, $id)
    {
        //
        $user = Auth::user();
        $match = \App\Match::with('matchWinners')->find($id);
        $winning_team = \App\MatchTeam::find($request->input('winning_team_id'));

// 		$match_winner = new \App\MatchWinner(['match_id' => $match->id, 'user_id' => $user->id, 'winning_team_id' => $winning_team->id])->save();

		$match_winner = new \App\MatchWinner();
		$match_winner->winning_team_id = $winning_team->id;
		$match_winner->user_id = $user->id;
		$match_winner->match()->associate($match);
		$match_winner->save();

		
//         $result = $match->matchWinners()->save(new \App\MatchWinner(['match_id' => $match->id, 'user_id' => $user->id, 'winning_team_id' => ])); // NOTE: why doesnt ->save() work here?

		// refresh data of already loaded model with ->load
		$match->load('matchWinners','game','teams.users.user');
		
		$tally = [];
		foreach ($match->matchWinners as $winner) {
			if (isset($tally[$winner->winning_team_id])) {
				$tally[$winner->winning_team_id]++;
			} else {
				$tally[$winner->winning_team_id] = 1;
			}
		}
		
		$maxs = array_keys($tally, max($tally));
		
		if ($tally[$maxs[0]] >= count($match->teams)) {
			// LOCK IT IN
			$match->locked_winner_match_team_id = $maxs[0];
			$match->save();

			// update competitino for refreshers				
			$cp = \App\Competition::find($match->competition_id);
			$cp->updated_at = Carbon::now('America/New_York');
			$cp->save();

			foreach ($match->teams->where('id', $match->locked_winner_match_team_id)->first()->users as $team_user) {
				$l_user = $team_user->user;
				$points_awarded_per_user = $match->game->points / 2 * count($match->teams);
				
				// try to find in leaderboard
				$leaderboard = \App\Leaderboard::userDay($l_user->id, $match->competition_id)->first();
				
				if ($leaderboard) {
					$leaderboard->points_total += $points_awarded_per_user;
				} else {
					// create if not found in leaderboard 
					$leaderboard = new \App\Leaderboard;
					$leaderboard->user_id = $l_user->id;
					$leaderboard->competition_id = $match->competition_id;
					$leaderboard->points_total = $points_awarded_per_user;
				}
				$leaderboard->save();

			}
		}

		return redirect()->route('match.index')->with('message', 'Vote Submitted');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
/*
    public function update(Request $request, $id)
    {
        //
    }
*/

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
/*
    public function destroy($id)
    {
        //
    }
*/
}
