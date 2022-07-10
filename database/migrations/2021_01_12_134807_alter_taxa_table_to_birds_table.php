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
            $table->dropColumn('fe_old_id');
            $table->dropColumn('fe_id');
            $table->dropColumn('restricted');
            $table->dropColumn('allochthonous');
            $table->dropColumn('invasive');

            $table->string('rank')->default('species')->change();
            # $table->text('original_identification')->nullable()->after('taxon_id')->change();

            $table->unsignedInteger('family_id')->after('uses_atlas_codes')->nullable();
            $table->unsignedInteger('order_id')->after('uses_atlas_codes')->nullable();

            $table->string('full_sci_name', 200)->after('uses_atlas_codes')->nullable();
            $table->string('bioras_sci_name', 200)->after('uses_atlas_codes')->nullable();
            $table->enum('gn_status', ['I', 'IG', 'NG', 'G0', 'G', 'G*'])->after('uses_atlas_codes')->nullable();
            $table->boolean('prior')->after('uses_atlas_codes')->default(false);
            $table->boolean('refer')->after('uses_atlas_codes')->default(false);
            $table->string('eunis_sci_name', 100)->after('uses_atlas_codes')->nullable();
            $table->string('eunis_n2000code', 10)->after('uses_atlas_codes')->nullable();
            $table->string('euring_sci_name', 100)->after('uses_atlas_codes')->nullable();
            $table->string('euring_code', 6)->after('uses_atlas_codes');
            $table->string('ebba_code', 6)->after('uses_atlas_codes')->nullable();
            $table->string('birdlife_id', 9)->after('uses_atlas_codes')->unique();
            $table->integer('birdlife_seq')->after('uses_atlas_codes')->unique();
            $table->enum('iucn_cat', ['EX', 'EW', 'CR', 'EN', 'VU', 'NT', 'LC', 'DD', 'NE'])->after('uses_atlas_codes')->nullable();
            $table->string('protected_note', 100)->after('uses_atlas_codes')->nullable();
            $table->boolean('protected')->after('uses_atlas_codes')->default(false);
            $table->string('strictly_note', 100)->after('uses_atlas_codes')->nullable();
            $table->boolean('strictly_protected')->after('uses_atlas_codes')->default(false);
            $table->string('spid', 10)->after('uses_atlas_codes')->unique()->index();
            $table->string('type', 2)->after('uses_atlas_codes')->default('RS');

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
            $table->boolean('restricted')->default(false);
            $table->boolean('allochthonous')->default(false);
            $table->boolean('invasive')->default(false);
            $table->string('rank')->change();

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
            $table->dropColumn('full_sci_name');

            $table->dropForeign('taxa_family_id_foreign');
            $table->dropForeign('taxa_order_id_foreign');

            $table->dropColumn('family_id');
            $table->dropColumn('order_id');
        });
    }
}
