<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AlterTaxaTableChangeIucnCat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE taxa MODIFY COLUMN iucn_cat ENUM('EX', 'EW', 'CR', 'EN', 'VU', 'NT', 'LC', 'DD', 'NE', 'NR')");
        DB::statement('ALTER TABLE taxa MODIFY COLUMN euring_code VARCHAR(6)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE taxa MODIFY COLUMN iucn_cat ENUM('EX', 'EW', 'CR', 'EN', 'VU', 'NT', 'LC', 'DD', 'NE')");
        DB::statement('ALTER TABLE taxa MODIFY COLUMN euring_code VARCHAR(6) NOT NULL');
    }
}
