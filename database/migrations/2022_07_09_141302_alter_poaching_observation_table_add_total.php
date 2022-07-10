<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPoachingObservationTableAddTotal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('poaching_observations', function (Blueprint $table) {
            $table->integer('total')->nullable()->after('indigenous');
            $table->string('locality')->nullable()->after('exact_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('poaching_observations', function (Blueprint $table) {
            $table->dropColumn('total');
            $table->dropColumn('locality');
        });
    }
}
