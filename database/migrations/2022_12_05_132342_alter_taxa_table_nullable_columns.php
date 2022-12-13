<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AlterTaxaTableNullableColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('taxa', function ($table) {
            $table->string('euring_code', 6)->nullable()->change();
            $table->string('birdlife_id', 9)->nullable()->change();
            $table->integer('birdlife_seq')->nullable()->change();
            $table->string('type', 2)->nullable()->change();
            $table->string('spid', 10)->nullable()->change();
            $table->dropForeign('taxa_family_id_foreign');
            $table->dropForeign('taxa_order_id_foreign');
            $table->dropColumn('family_id');
            $table->dropColumn('order_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('taxa', function ($table) {
        });
    }
}
