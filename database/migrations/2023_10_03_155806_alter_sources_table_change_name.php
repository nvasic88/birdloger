<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
        Schema::table('sources', function (Blueprint $table) {
            $table->string('ytid', 11)->after('link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE sources MODIFY COLUMN name ENUM('social_media', 'media', 'ads', 'institutions', 'associates')");
        Schema::table('sources', function (Blueprint $table) {
            $table->dropColumn('ytid');
        });
    }
}
