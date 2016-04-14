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

		$data = [
			'tab' => 'profile',
			'user' => Auth::user(),
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
