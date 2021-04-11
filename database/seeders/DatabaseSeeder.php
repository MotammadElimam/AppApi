<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $owner = Role::create([
        'name' => 'seller',
        'display_name' => 'seller', // optional
        'description' => 'User is the owner of a given products', // optional
]); 
    }
}
