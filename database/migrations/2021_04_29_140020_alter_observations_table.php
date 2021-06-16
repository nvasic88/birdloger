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
                'individual',
                'couple',
                'singing_male',
                'active_nest',
                'family_with_cubs',
            ])->after('number')->nullable();
            $table->string('data_limit', 100)->after('dataset')->nullable();
            $table->string('data_provider', 100)->after('dataset')->nullable();
            $table->text('comment')->after('dataset')->nullable();
            $table->text('description')->after('dataset')->nullable();
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
