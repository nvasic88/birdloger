<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterPoachingObservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE poaching_observations MODIFY COLUMN verdict ENUM('yes', 'no', 'rejected', 'declined', 'in_progress')");
        Schema::table('poaching_observations', function (Blueprint $table) {
            $table->dropColumn('suspect_name');
            $table->dropColumn('suspect_place');
            $table->dropColumn('suspect_profile');
            $table->dropColumn('suspect_note');
            $table->dropColumn('suspects_number');

            $table->enum('case_against', ['individual', 'legal_entity'])->nullable();
            $table->string('case_against_mb')->nullable();
            $table->string('case_against_pib')->nullable();
            $table->string('case_submitted_to')->nullable();
            $table->string('case_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE poaching_observations MODIFY COLUMN verdict ENUM('yes', 'no', 'rejected')");
        Schema::table('poaching_observations', function (Blueprint $table) {
            $table->string('suspect_name')->nullable();
            $table->string('suspect_place')->nullable();
            $table->string('suspect_profile')->nullable();
            $table->text('suspect_note')->nullable();
            $table->integer('suspects_number')->nullable();

            $table->dropColumn('case_against');
            $table->dropColumn('case_against_mb');
            $table->dropColumn('case_against_pib');
            $table->dropColumn('case_submitted_to');
            $table->dropColumn('case_name');
        });
    }
}
