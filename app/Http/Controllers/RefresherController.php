<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
use Session;

class RefresherController extends Controller
{
    //
        
	public function leaderboard() {
		$competition = \App\Competition::orderBy('id', 'desc')->first();
		return response()->json(['updatedAt' => $competition->updated_at], 200);
	}
	
	public function match($id) {
		$match = \App\Match::find($id);
		return response()->json(['updatedAt' => $match->updated_at], 200);
	}
}
