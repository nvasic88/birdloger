<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sources', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('name', ['social_media', 'media', 'ads', 'institutions', 'associates']);
            $table->string('description')->nullable();
            $table->string('link')->nullable();
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
        Schema::dropIfExists('sources');
    }
}
