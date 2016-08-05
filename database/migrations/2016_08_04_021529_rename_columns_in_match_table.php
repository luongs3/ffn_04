<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnsInMatchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('matches', function ($table) {
            $table->renameColumn('score_club1', 'score_team1');
            $table->renameColumn('score_club2', 'score_team2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('matches', function ($table) {
            $table->renameColumn('score_team1', 'score_club1');
            $table->renameColumn('score_team2', 'score_club2');
        });
    }
}
