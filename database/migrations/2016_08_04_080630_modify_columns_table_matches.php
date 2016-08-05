<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyColumnsTableMatches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `matches` MODIFY `start_time` TIMESTAMP ;');
        DB::statement('ALTER TABLE `matches` MODIFY `end_time` TIMESTAMP ;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE `matches` MODIFY `start_time` DATETIME ;');
        DB::statement('ALTER TABLE `matches` MODIFY `end_time` DATETIME ;');
    }
}
