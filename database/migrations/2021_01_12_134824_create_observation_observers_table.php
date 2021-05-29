<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObservationObserversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('observation_observer', function (Blueprint $table) {
            $table->unsignedBigInteger('observation_id');
            $table->unsignedInteger('observer_id');

            $table->primary(['observation_id', 'observer_id']);

            $table->foreign('observation_id')
                ->references('id')
                ->on('observations')
                ->onDelete('cascade');

            $table->foreign('observer_id')
                ->references('id')
                ->on('observers')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('observation_observer');
    }
}
