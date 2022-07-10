<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoachingObservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poaching_observations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('taxon_suggestion', 255)->nullable();
            $table->boolean('indigenous')->default(false);
            $table->integer('dead_from_total')->nullable();
            $table->integer('alive_from_total')->nullable();
            $table->boolean('exact_number')->nullable();
            $table->string('place')->nullable();
            $table->string('municipality')->nullable();
            $table->string('data_id')->nullable();
            $table->string('folder_id')->nullable();
            $table->string('file')->nullable();
            $table->boolean('in_report')->default(false);
            $table->text('offence_details')->nullable();
            $table->boolean('case_reported')->default(false);
            $table->string('case_reported_by')->nullable();
            $table->enum('verdict', ['yes', 'no', 'rejected'])->nullable();
            $table->date('verdict_date')->nullable();
            $table->enum('proceeding', ['misdemeanor', 'criminal'])->nullable();
            $table->integer('sanction_rsd')->nullable();
            $table->integer('sanction_eur')->nullable();
            $table->integer('community_sentence')->nullable();
            $table->boolean('opportunity')->default(false)->nullable();
            $table->text('annotation')->nullable();
            $table->string('suspect_name')->nullable();
            $table->string('suspect_place')->nullable();
            $table->string('suspect_profile')->nullable();
            $table->text('suspect_note')->nullable();
            $table->integer('suspects_number')->nullable();
            $table->string('associates')->nullable();
            $table->integer('cites')->nullable();
            $table->string('origin_of_individuals')->nullable();
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
        Schema::dropIfExists('poaching_observations');
    }
}
