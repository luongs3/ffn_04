<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team1_id');
            $table->integer('team2_id');
            $table->tinyInteger('score_club1')->default(0);
            $table->tinyInteger('score_club2')->default(0);
            $table->string('place');
            $table->datetime('start_time')->nullable()->default(null);
            $table->datetime('end_time')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('matches');
    }
}
