<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterElectrocutionObservationsChangeState extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE electrocution_observations MODIFY COLUMN state ENUM('alive', 'fresh_corpse', 'in_decay_state', 'corpse_remains', 'dry_remains', 'fresh_remains')");
        DB::statement("ALTER TABLE electrocution_observations MODIFY COLUMN position ENUM('ground', 'pillar')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('electrocution_observations', function (Blueprint $table) {
            $table->string('position')->nullable()->change();
            $table->string('state')->nullable()->change();
        });
    }
}
