<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(StagesTableSeeder::class);
        $this->call(ObservationTypesTableSeeder::class);
        $this->call(AnnexesTableSeeder::class);
        $this->call(OffenceCasesTableSeeder::class);

        // $this->call(UsersTableSeeder::class);
        // $this->call(TaxaTableSeeder::class);
        // $this->call(TerritorySpecificTableSeeder::class);
        // $this->call(RedListsTableSeeder::class);
        // $this->call(ConservationLegislationsTableSeeder::class);
        // $this->call(ConservationDocumentsTableSeeder::class);

    }
}
