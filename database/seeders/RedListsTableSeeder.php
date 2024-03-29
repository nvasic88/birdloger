<?php

namespace Database\Seeders;

use App\RedList;
use Illuminate\Database\Seeder;

class RedListsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RedList::firstOrCreate(['slug' => 'global'])->update([
            'en' => ['name' => 'Global'],
            'hr' => ['name' => 'Globalna'],
            'sr' => ['name' => 'Глобална'],
            'sr-Latn' => ['name' => 'Globalna'],
        ]);

        RedList::firstOrCreate(['slug' => 'europe'])->update([
            'en' => ['name' => 'Europe'],
            'hr' => ['name' => 'Evropa'],
            'sr' => ['name' => 'Европа'],
            'sr-Latn' => ['name' => 'Evropa'],
        ]);
    }
}
