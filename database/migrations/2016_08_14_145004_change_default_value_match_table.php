<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDefaultValueMatchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('matches', function (Blueprint $table) {
            DB::statement('ALTER TABLE `matches` MODIFY `score_team1` TINYINT NULL;');
            DB::statement('ALTER TABLE `matches` MODIFY `score_team2` TINYINT NULL;');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('matches', function (Blueprint $table) {
            DB::statement('ALTER TABLE `matches` MODIFY `score_team1` TINYINT DEFAULT 0;');
            DB::statement('ALTER TABLE `matches` MODIFY `score_team2` TINYINT DEFAULT 0;');
        });
    }
}
