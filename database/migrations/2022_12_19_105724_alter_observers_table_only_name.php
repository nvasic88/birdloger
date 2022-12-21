<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterObserversTableOnlyName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('observers', function (Blueprint $table) {
            $table->dropColumn('firstName');
            $table->dropColumn('lastName');

            $table->string('name', 150)->after('id')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('observers', function (Blueprint $table) {
            $table->dropColumn('name');

            $table->string('lastName', 50)->after('id');
            $table->string('firstName', 50)->after('id');

        });
    }
}
