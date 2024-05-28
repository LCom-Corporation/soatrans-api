<?php

namespace Database\Seeders;

use App\Models\Vehicule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Nette\Utils\Random;

class VehiculeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            Vehicule::create([
                'immatriculation' => rand(1000, 9999).'TAN',
                'nbr_place' => 16,
                'marque' => 'Crafter',
            ]);
        }
    }
}
