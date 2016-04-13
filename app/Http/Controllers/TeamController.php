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
        $team = \App\MatchTeam::with('users','match')->findOrFail($id);
        
        $user = \App\User::find(Auth::user()->id);


        switch ($mode) {
	        case 'leave':
	        	$team->users()->where('user_id', Auth::user()->id)->delete();
	        	// if last person to leave delete this team
	        	if (count($team->users) == 1) {
		        	$team->delete();
		        	$team->match->delete();
	        	}
	        break;
	        case 'join':
			default:
	        	$team->users()->save($user);
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
