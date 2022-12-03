<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterElectrocutionObservations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('electrocution_observations', function (Blueprint $table) {
            $table->enum('death_cause', ['electrocution', 'collision'])->nullable();
            $table->string('column_type')->nullable();
            $table->string('console_type')->nullable();
            $table->string('voltage')->nullable();
            $table->string('iba')->nullable();

            $table->time('time_of_corpse_found')->nullable();
            $table->string('pillar_number')->nullable(); // instead of number_of_pillars

            $table->dropColumn('number_of_pillars');
            $table->dropColumn('transportation');
            $table->dropColumn('time_of_departure');
            $table->dropColumn('time_of_arrival');
            $table->dropColumn('distance');
            $table->dropColumn('transmission_line');
            $table->dropColumn('annotation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('electrocution_observations', function (Blueprint $table) {
            $table->integer('number_of_pillars')->nullable(); // should be pillar_number
            $table->string('transportation')->nullable(); // not needed
            $table->time('time_of_departure')->nullable(); // not needed
            $table->time('time_of_arrival')->nullable(); // not needed
            $table->integer('distance')->nullable(); // not needed
            $table->string('transmission_line')->nullable(); // Same as location
            $table->text('annotation')->nullable();

            $table->dropColumn('death_cause');
            $table->dropColumn('column_type');
            $table->dropColumn('console_type');
            $table->dropColumn('voltage');
            $table->dropColumn('iba');
            $table->dropColumn('time_of_corpse_found');
            $table->dropColumn('pillar_number');
        });
    }
}
