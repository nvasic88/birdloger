<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTaxaTableToBirdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('taxa', function (Blueprint $table) {
            //$table->dropColumn('fe_old_id');
            // $table->dropColumn('ancestors_names');

            // name is spices name
            $table->string('type', 2)->default('RS');
            $table->string('spid', 10)->unique();
            $table->boolean('strictly_protected')->default(false);
            $table->string('strictly_note', 100)->nullable();
            $table->boolean('protected')->default(false);
            $table->string('protected_note', 100)->nullable();
            $table->string('iucn_cat', 2)->nullable();
            $table->integer('birdlife_seq')->unique();
            $table->string('birdlife_id', 9)->unique();
            $table->string('ebba_code', 6)->nullable();
            $table->string('euring_code', 6);
            $table->string('euring_sci_name', 100)->unique();
            $table->string('eunis_n2000code', 10)->nullable();
            $table->string('eunis_sci_name', 100)->unique()->nullable();
            $table->boolean('refer')->default(false);
            $table->enum('prior', [null,'PR','PR+'])->nullable();
            $table->string('gn_status', 10)->nullable();
            $table->string('bioras_sci_name',200)->nullable();
            $table->string('full_sci_name',200)->nullable();

            $table->unsignedInteger('family_id')->nullable();
            $table->unsignedInteger('order_id')->nullable();

            $table->foreign('family_id')
                ->references('id')
                ->on('families')
                ->onDelete('set null');

            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('set null');
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
            $table->dropColumn('type');
            $table->dropColumn('spid');
            $table->dropColumn('strictly_protected');
            $table->dropColumn('strictly_note');
            $table->dropColumn('protected');
            $table->dropColumn('protected_note');
            $table->dropColumn('iucn_cat');
            $table->dropColumn('birdlife_seq');
            $table->dropColumn('birdlife_id');
            $table->dropColumn('ebba_code');
            $table->dropColumn('euring_code');
            $table->dropColumn('euring_sci_name');
            $table->dropColumn('eunis_n2000code');
            $table->dropColumn('eunis_sci_name');
            $table->dropColumn('refer');
            $table->dropColumn('prior');
            $table->dropColumn('gn_status');
            $table->dropColumn('bioras_sci_name');
            $table->dropColumn('family_id');
            $table->dropColumn('order_id');
        });
    }
}
