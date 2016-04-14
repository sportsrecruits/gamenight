<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
 */

Route::get('/test', function () {

    echo Carbon\Carbon::now('America/New_York');

});

Route::get('/', 'LeaderboardController@index');

Route::group(['middleware' => 'auth'], function () {
    // creates a competition if necesarry
    // displays the leaderboard
    // loads up all of the players that have any points

    Route::resource('match', 'MatchController');
    Route::post('match/win/{id}', 'MatchController@win');
    // REST matches
    // save match_winners

    Route::resource('team', 'TeamController');
    // REST teams
    // add players to teams

    Route::get('user/', 'UserController@showProfile');
});

Route::get('login', 'UserController@login');
Route::get('logout', function () {
    Auth::logout();
});

Route::get('oauth_callback/', 'UserController@handleProviderCallback');

// login and signup
// stats
// easter eggs
