<?php

namespace Database\Seeders;

use App\OffenceCase;
use Illuminate\Database\Seeder;

class OffenceCasesTableSeeder extends Seeder
{
    protected $offenceCases = [
        'killing',
        'catching',
        'poisoning',
        'owning',
        'trading',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->offenceCases as $offence) {
            OffenceCase::firstOrCreate(['name' => $offence]);
        }
    }
}
