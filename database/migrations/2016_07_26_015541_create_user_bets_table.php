<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserBetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_bets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('match_id');
            $table->integer('point')->default(0);
            $table->integer('team_id');
            $table->tinyInteger('result')->default(0);
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
        Schema::drop('user_bets');
    }
}
