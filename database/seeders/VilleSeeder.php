<?php

namespace Database\Seeders;

use App\Models\Ville;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VilleSeeder extends Seeder
{
    private $data = [
        [
            "nom" => 'Antananarivo',
            "code" => 'TNR',
            "image" => "/storage/ville/tana.jpg"
        ],
        [
            "nom" => 'Tamatave',
            "code" => 'TMM',
            "image" => "/storage/ville/tamatave.jpg"
        ],
        [
            "nom" => 'Fianarantsoa',
            "code" => 'FNR',
            "image" => "/storage/ville/fianarantsoa.jpg"
        ],
        [
            "nom" => 'Mahajanga',
            "code" => 'MJN',
            "image" => "/storage/ville/majunga.jpg"
        ], 
        [
            "nom" => "Antsirabe",
            "code" => "ATB",
            "image" => "/storage/ville/antsirabe.jpg"
        ],
        [
            "nom" => "Morondava",
            "code" => "MRV",
            "image" => "/storage/ville/morondava.jpg"
        ],
        [
            "nom" => "Farafangana",
            "code" => "FRF",
            "image" => "/storage/ville/farafangana.jpg"
        ],
        [
            'nom' => "Ambositra",
            'code' => "AMT",
            'image' => "/storage/ville/ambositra.jpg"
        ], 
        [
            "nom" => "Manakara",
            "code" => "MKR",
            "image" => "/storage/ville/manakara.jpg"
        ]
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->data as $ville) {
            Ville::create($ville);
        }
    }
}
