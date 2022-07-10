<?php

namespace Database\Seeders;

use App\ObservationType;

use Illuminate\Database\Seeder;

class ObservationTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ObservationType::firstOrCreate(['slug' => 'observed'])->update([
            'en' => ['name' => 'Observed'],
            'hr' => ['name' => 'Opaženo'],
            'sr' => ['name' => 'Посматрано'],
            'sr-Latn' => ['name' => 'Posmatrano'],
        ]);

        ObservationType::firstOrCreate(['slug' => 'call'])->update([
            'en' => ['name' => 'Call'],
            'hr' => ['name' => 'Glasanje'],
            'sr' => ['name' => 'Оглашавање'],
            'sr-Latn' => ['name' => 'Oglašavanje'],
        ]);
    }
}
