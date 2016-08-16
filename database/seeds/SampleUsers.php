<?php

use Illuminate\Database\Seeder;

class SampleUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
	    $users = array(
		    array('name' => 'Chris Meade', 'email' => 'cm@lax.com', 'avatar' => 'http://sportsrecruits.co/images/circle-profiles/chris.png'),
		    array('name' => 'Norb Bielan', 'email' => 'nb@lax.com', 'avatar' => 'http://sportsrecruits.co/images/circle-profiles/norb.png'),
		    array('name' => 'Spike Malangone', 'email' => 'sm@lax.com', 'avatar' => 'http://sportsrecruits.co/images/circle-profiles/spike.png'),
		    array('name' => 'Patrick Ng', 'email' => 'pn@lax.com', 'avatar' => 'http://sportsrecruits.co/images/circle-profiles/patrick.png')

	    );
		foreach ($users as $user) {
	        DB::table('users')->insert($user);
		}

		for ($i = 0; $i < 5; $i++) {

			$match = new \App\Match;
			$match->game()->associate(\App\Game::find(rand(1,3)));
			$match->competition_id = 1;
			$match->save();
			
			$team1 = new \App\MatchTeam;
			$team1->save();
			$team1->match()->associate($match);
			$team1->users()->saveMany([\App\User::find(1), \App\User::find(2)]);			

			$team2 = new \App\MatchTeam;
			$team2->save();
			$team2->match()->associate($match);
			$team2->users()->saveMany([\App\User::find(3), \App\User::find(4)]);		

			$match->teams()->saveMany([$team1, $team2]);
			$match->save();
		}		
    }
}
