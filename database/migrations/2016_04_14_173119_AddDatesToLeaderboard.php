<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDatesToLeaderboard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		Schema::table('leaderboard', function ($table) {
            $table->timestamps();
            $table->increments('id')->index();
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
		Schema::table('leaderboard', function ($table) {
		    $table->dropColumn('created_at');
		    $table->dropColumn('updated_at');
		});    

    }
}
