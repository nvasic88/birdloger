<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AlterSourcesTableChangeName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE sources MODIFY COLUMN name ENUM('social_media', 'media', 'ads', 'institutions', 'associates', 'youtube')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE sources MODIFY COLUMN name ENUM('social_media', 'media', 'ads', 'institutions', 'associates')");
    }
}
