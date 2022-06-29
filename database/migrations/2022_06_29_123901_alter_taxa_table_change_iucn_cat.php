<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE taxa MODIFY COLUMN iucn_cat ENUM('EX', 'EW', 'CR', 'EN', 'VU', 'NT', 'LC', 'DD', 'NE')");
    }
}
