<?php

use Illuminate\Database\Seeder;

class GamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
	public function run()
    {
	    $games = array(
		    array('name' => 'foosball', 'points' => 12),
		    array('name' => 'ticket to ride', 'points' => 25),
		    array('name' => 'coup', 'points' => 10),
		    array('name' => 'exploding kittens', 'points' => 10),
		    array('name' => 'cards against humanity', 'points' => 25),
		    array('name' => 'resistance', 'points' => 15),
	    );
		foreach ($games as $game) {
	        DB::table('games')->insert($game);
		}
    }
}
