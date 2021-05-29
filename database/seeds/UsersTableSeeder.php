<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::where('name', 'admin')->first();
        $curator = Role::where('name', 'curator')->first();
        $crime = Role::where('name', 'crime')->first();
        $electrocution = Role::where('name', 'electrocution')->first();

        factory(User::class)->create([
            'email' => 'nvasic@singidunum.ac.rs',
        ])->roles()->sync([$admin->id, $curator->id, $crime->id, $electrocution->id]);

        factory(User::class)->create([
            'email' => 'admin@example.com',
        ])->roles()->sync([$admin->id]);

        factory(User::class)->create([
            'email' => 'curator@example.com',
        ])->roles()->sync([$curator->id]);

        factory(User::class)->create([
            'email' => 'crime@example.com',
        ])->roles()->sync([$crime->id]);

        factory(User::class)->create([
            'email' => 'electrocution@example.com',
        ])->roles()->sync([$electrocution->id]);

        factory(User::class)->create([
            'email' => 'member@example.com',
        ]);
    }
}
