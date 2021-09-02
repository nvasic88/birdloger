<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterFieldObservationsTableAddNewIds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('field_observations', function (Blueprint $table) {
            $table->string('fid', 101)->nullable()->after('taxon_suggestion');
            $table->integer('rid')->nullable()->after('taxon_suggestion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('field_observations', function (Blueprint $table) {
            $table->dropColumn('rid');
            $table->dropColumn('fid');
        });
    }
}
