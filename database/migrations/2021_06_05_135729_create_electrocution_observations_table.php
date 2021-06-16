<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElectrocutionObservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('electrocution_observations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('taxon_suggestion', 255)->nullable();
            $table->integer('distance_from_pillar')->nullable();
            $table->integer('age')->nullable();
            $table->string('position')->nullable();
            $table->string('state')->nullable();
            $table->text('annotation')->nullable();
            $table->integer('number_of_pillars')->nullable();
            $table->string('transmission_line')->nullable();
            $table->time('time_of_departure')->nullable();
            $table->time('time_of_arrival')->nullable();
            $table->integer('duration')->nullable();
            $table->integer('distance')->nullable();
            $table->string('transportation')->nullable();
            $table->unsignedSmallInteger('license');
            $table->boolean('unidentifiable')->default(false);
            $table->unsignedInteger('observed_by_id')->nullable();
            $table->unsignedInteger('identified_by_id')->nullable();
            $table->timestamps();

            $table->foreign('observed_by_id')->references('id')->on('users');
            $table->foreign('identified_by_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('electrocution_observations');
    }
}
