<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Socialite;
use App\User;
use Auth;
use Session;

class UserController extends Controller
{
    //
    
    function login () {
	    return Socialite::driver('google')->redirect();
    }
    
    public function showProfile () 
    {
		$user = Auth::user();
		
		$matches = \App\Match::with('game','teams.users.user')->whereHas('teams.users', function ($query) use ($user) {
						$query->where('user_id', $user->id);
					})->get(); 
// dd($matches);
		
		/*
		 *	process additional params
		 *	@status: complete|in-progress|won
		 */
		foreach ($matches as &$match) {
			if ($match->locked_winner_match_team_id) {
/*
   				dd($user->id);
   				
   				dd ($match->teams->where('id', $match->locked_winner_match_team_id)->first()->users->contains('user_id', 1));
*/
				$users_c = $match->teams->where('id', $match->locked_winner_match_team_id)->first();
				if ($users_c && $users_c->users->contains('user_id', $user->id)) {
					$match->status = 'won';
				} else {
					$match->status = 'complete';
				}
			} else {
				$match->status = 'in-progress';
			}		
				
			foreach ($matches as &$match) {
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
			
		}

		// Total alltime points
		$user->alltime_points = \App\Leaderboard::where('user_id', '=', $user->id)->get()->reduce(
			function ($carry, $l) {
				return $l->points_total + $carry;
			}	
		);

		$points_query = \App\Leaderboard::where('user_id','=',$user->id)->orderBy('competition_id', 'desc')->first();
		
		if ($points_query)
			$user->today_points = $points_query->points_total;
		else 
			$user->today_points = 0;
		
		$data = [
			'tab' => 'profile',
			'user' => $user,
			'matches' => $matches
		];
	    return view('user', $data);

    }
    
    public function handleProviderCallback()
	{

		try {
		    $user = Socialite::driver('google')->user();
		}
		catch (GuzzleHttp\Exception\ClientException $e) {
		     dd($e->response);
		}

	    // handle the user by finding them or creating them
	    $auth_user = $this->_findByUsernameOrCreate($user);
	    
	    // then authenticateing them
		Auth::login($auth_user, true);
		
		return redirect ('/');
	}
	
	private function _findByUsernameOrCreate ($user) {
		return User::firstOrCreate ([
			'name' => $user->name,
			'avatar' => $user->avatar,
			'email' => $user->email
		]);
	}
}
