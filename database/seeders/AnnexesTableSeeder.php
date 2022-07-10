<?php

namespace Database\Seeders;

use App\Annex;
use Illuminate\Database\Seeder;

class AnnexesTableSeeder extends Seeder
{
    protected $annexes = [
        '1',
        '2a',
        '2b',
        '3a',
        '3b',
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->annexes as $annex) {
            Annex::firstOrCreate(['name' => $annex]);
        }
    }
}
