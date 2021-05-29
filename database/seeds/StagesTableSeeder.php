<?php

use App\Stage;
use Illuminate\Database\Seeder;

class StagesTableSeeder extends Seeder
{
    protected $stages = [
        'egg',
        'nidicolous',
        'nidifugous',
        'juvenile',
        'immature',
        'fledgling',
        'adult',
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->stages as $stage) {
            Stage::firstOrCreate(['name' => $stage]);
        }
    }
}
