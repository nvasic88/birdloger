<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterObservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('observations', function (Blueprint $table) {
            $table->enum('number_of', [
                null,
                'jedinka',
                'par',
                'pevajući mužjak',
                'aktivno gnezdo',
                'porodica sa mladuncima',
            ])->after('number')->nullable();
            $table->text('description')->nullable();
            $table->text('comment')->nullable();
            $table->string('data_provider', 100)->after('number_of')->nullable();
            $table->string('data_limit', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('observations', function (Blueprint $table) {
            $table->dropColumn('number_of');
            $table->dropColumn('description');
            $table->dropColumn('comment');
            $table->dropColumn('data_provider');
            $table->dropColumn('data_limit');
        });
    }
}
