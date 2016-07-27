<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->unique('slug', 'slug');
            $table->string('image')->nullable();
            DB::statement('ALTER TABLE posts MODIFY COLUMN published_at timestamp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropUnique('slug');
            $table->dropColumn('image');
            DB::statement('ALTER TABLE posts MODIFY COLUMN published_at datetime');
        });
    }
}
