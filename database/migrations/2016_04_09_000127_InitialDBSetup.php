<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitialDBSetup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competitions', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });
        Schema::create('matches', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('competition_id')->index();
			$table->integer('game_id');
			$table->integer('locked_winner_match_team_id');
			$table->time('time');
            $table->timestamps();
        });
        Schema::create('match_winners', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('match_id'); // unique key with user_id
			$table->integer('user_id');
			$table->unique(['match_id', 'user_id']);
			$table->integer('winning_team_id');
            $table->timestamps();
        });
        Schema::create('match_teams', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('match_id');
        });
        Schema::create('match_teams_users', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('team_id');
			$table->integer('user_id');
        });
        Schema::create('games', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
			$table->integer('points');
        });
        Schema::create('leaderboard', function (Blueprint $table) {
            $table->integer('competition_id')->index();
            $table->integer('user_id')->index();
			$table->unique(['competition_id', 'user_id']);
			$table->integer('points_total');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('competitions');
        Schema::drop('matches');
        Schema::drop('match_winners');
        Schema::drop('match_teams_users');
        Schema::drop('match_teams');
        Schema::drop('games');
        Schema::drop('leaderboard');

    }
}
