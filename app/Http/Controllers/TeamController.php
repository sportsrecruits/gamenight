<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use Session;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
/*
    public function index()
    {
        //
    }
*/

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
/*
    public function create()
    {
        //
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
        //
		$team = new \App\MatchTeam;
		$team->name = Auth::user()->name . "'s Team";
		$team->match()->associate(\App\Match::find($request->input('match_id')));
		$team->save();
		$team->users()->save(new \App\MatchTeamsUser(['team_id' => $team->id, 'user_id' => Auth::user()->id]))->save();		
		
		// redirect to the match using its named route
		return redirect()->route('match.show', $request->input('match_id'))->with('message', 'Team Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
/*
    public function show($id)
    {
        //
    }
*/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
/*
    public function edit($id)
    {
		//
    }
*/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $mode = $request->input('mode');
        
        // determine if you are on the team 
        $team = \App\MatchTeam::with('users','match.teams.users')->findOrFail($id);
        


        switch ($mode) {
	        case 'leave':
	        	$team->users()->where('user_id', Auth::user()->id)->delete();
	        	// if last person to leave delete this team
	        	if (count($team->users) == 1) {
		        	$team->delete();
					if ($team->match->teams->reduce(function ($carry,$team) { return $team->users->count() + $carry;}) == 1) {
			        	$team->match->delete();
			        }
	        	}

	        break;
	        case 'join':
			default:

				$user = Auth::user();
				// check that they do not have a game in progress
// 				$user = \App\User::matchInProgress->find(Auth::user()->id); // NOTE: left here
				$user_in_progress = \App\MatchTeamsUser::whereHas('user', function ($query) use ($user) {
					$query->where('user_id', $user->id);
				})->whereHas('team.match', function ($query) {
					$query->where('locked_winner_match_team_id', 0);
				})->with('team.match')->first();

				if ($user_in_progress) {
					return redirect('match/'.$user_in_progress->team->match->id)->with('message', 'Please select a winner for this match');
				}

				// redirect to that match if they have in progress with flash message saying 'please choose a winner first' 
				
				// new matchTeamsUser
				$save_user = new \App\MatchTeamsUser;
				$save_user->team_id = $id;
				$save_user->user_id = $user->id;
				$save_user->save();
	        	$team->users()->save($save_user);
	        break;
        }
        
        return redirect('/match')->with('message', (($mode == 'leave') ? 'You left the team' : 'You joined the team'));

    }

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
