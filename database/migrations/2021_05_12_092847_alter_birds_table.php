<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterBirdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE taxa MODIFY COLUMN iucn_cat ENUM('EX','EW','CR','EN','VU','NT','LC','DD','NE')");
        DB::statement("ALTER TABLE taxa MODIFY COLUMN gn_status ENUM('I','IG','NG','G0','G','G*')");
        Schema::table('taxa', function (Blueprint $table) {
            $table->dropColumn('sg');

            $table->boolean('prior')->nullable()->change();

            $table->string('euring_code', 6)->nullable()->change();
            $table->string('euring_sci_name', 100)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('taxa', function (Blueprint $table) {
            $table->string('sg', 10)->nullable();
            $table->string('gn_status', 10)->nullable()->change();
            $table->string('euring_code', 6)->change();
            $table->string('euring_sci_name', 100)->unique()->change();
            $table->string('iucn_cat', 2)->nullable()->change();
            $table->enum('prior', [null,'PR','PR+'])->nullable()->change();
        });
    }
}
