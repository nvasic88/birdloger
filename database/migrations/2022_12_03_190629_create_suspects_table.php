<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuspectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suspects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('place')->nullable();
            $table->string('profile')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('social_media')->nullable();
            $table->text('note')->nullable();

            $table->unsignedBigInteger('poaching_observation_id');
            $table->foreign('poaching_observation_id')
                ->references('id')
                ->on('poaching_observations')
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
        Schema::dropIfExists('suspects');
    }
}
