<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\ClasseSeeder;
use Database\Seeders\TrajetSeeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@soatrans-lcom.com',
            'password' => Hash::make('password'),
            'role' => 'administrateur'
        ]);

        // $this->call([
        //     ClasseSeeder::class,
        //     VilleSeeder::class,
        //     TrajetSeeder::class,
        //     VehiculeSeeder::class,
        // ]);
    }
}
