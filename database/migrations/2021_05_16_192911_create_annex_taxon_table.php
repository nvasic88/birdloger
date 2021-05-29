<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnexTaxonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('annex_taxon', function (Blueprint $table) {
            $table->unsignedInteger('annex_id');
            $table->unsignedInteger('taxon_id');

            $table->primary(['annex_id', 'taxon_id']);

            $table->foreign('annex_id')
                ->references('id')
                ->on('annexes')
                ->onDelete('cascade');

            $table->foreign('taxon_id')
                ->references('id')
                ->on('taxa')
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
        Schema::dropIfExists('annex_taxon');
    }
}
