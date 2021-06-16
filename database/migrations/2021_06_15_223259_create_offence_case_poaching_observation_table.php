<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffenceCasePoachingObservationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offence_case_poaching_observation', function (Blueprint $table) {
            $table->unsignedInteger('offence_id');
            $table->unsignedBigInteger('poaching_id');

            $table->primary(['offence_id', 'poaching_id']);

            $table->foreign('offence_id')
                ->references('id')
                ->on('offence_cases')
                ->onDelete('cascade');

            $table->foreign('poaching_id')
                ->references('id')
                ->on('poaching_observations')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offence_case_poaching_observation');
    }
}
