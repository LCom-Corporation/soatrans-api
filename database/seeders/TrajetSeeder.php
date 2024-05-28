<?php

namespace Database\Seeders;

use App\Models\Ville;
use App\Models\Classe;
use App\Models\Trajet;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TrajetSeeder extends Seeder
{

    protected $data = [
        "GOLD" => [
            [
                'depart' => 'Antananarivo',
                'arrivee' => 'Antsirabe',
                'tarif' => 25000,
                'point_of_recup' => 'Galana Andrefan\'Ambohijanahary',
            ],
            [
                'depart' => 'Antsirabe',
                'arrivee' => 'Antananarivo',
                'tarif' => 25000,
                'point_of_recup' => 'Galana Andrefan\'Ambohijanahary',
            ],
            [
                'depart' => 'Antananarivo',
                'arrivee' => 'Mahajanga',
                'tarif' => 110000,
                'point_of_recup' => 'Galana Andrefan\'Ambohijanahary',
            ],
            [
                'depart' => 'Mahajanga',
                'arrivee' => 'Antananarivo',
                'tarif' => 110000,
                'point_of_recup' => 'Galana Andrefan\'Ambohijanahary',
            ],
        ],
        "VIP" => [
            [
                'depart' => 'Antananarivo',
                'arrivee' => 'Antsirabe',
                'tarif' => 20000,
                'point_of_recup' => 'Galana Andrefan\'Ambohijanahary',
            ],
            [
                'depart' => 'Antsirabe',
                'arrivee' => 'Antananarivo',
                'tarif' => 20000,
                'point_of_recup' => 'Galana Andrefan\'Ambohijanahary',
            ]
        ],
        "PREMIUM" => [
            [
                'depart' => 'Antananarivo',
                'arrivee' => 'Antsirabe',
                'tarif' => 20000,
                'point_of_recup' => 'Galana Andrefan\'Ambohijanahary',
            ],
            [
                'depart' => 'Antsirabe',
                'arrivee' => 'Antananarivo',
                'tarif' => 20000,
                'point_of_recup' => 'Galana Andrefan\'Ambohijanahary',
            ],
            [
                'depart' => 'Antananarivo',
                'arrivee' => 'Ambositra',
                'tarif' => 30000,
                'point_of_recup' => 'Galana Andrefan\'Ambohijanahary',
            ],
            [
                'depart' => 'Ambositra',
                'arrivee' => 'Antananarivo',
                'tarif' => 30000,
                'point_of_recup' => 'Galana Andrefan\'Ambohijanahary',
            ],
            [
                'depart' => 'Antananarivo',
                'arrivee' => 'Fianarantsoa',
                'tarif' => 45000,
                'point_of_recup' => 'Galana Andrefan\'Ambohijanahary',
            ],
            [
                'depart' => 'Fianarantsoa',
                'arrivee' => 'Antananarivo',
                'tarif' => 45000,
                'point_of_recup' => 'Galana Andrefan\'Ambohijanahary',
            ],
            [
                'depart' => 'Antananarivo',
                'arrivee' => 'Tamatave',
                'tarif' => 40000,
                'point_of_recup' => 'Galana Andrefan\'Ambohijanahary',
            ],
            [
                'depart' => 'Tamatave',
                'arrivee' => 'Antananarivo',
                'tarif' => 40000,
                'point_of_recup' => 'Galana Andrefan\'Ambohijanahary',
            ],
            [
                'depart' => 'Antsirabe',
                'arrivee' => 'Tamatave',
                'tarif' => 50000,
                'point_of_recup' => 'Galana Andrefan\'Ambohijanahary',
            ],
            [
                'depart' => 'Tamatave',
                'arrivee' => 'Antsirabe',
                'tarif' => 50000,
                'point_of_recup' => 'Galana Andrefan\'Ambohijanahary',
            ],
            [
                'depart' => 'Antananarivo',
                'arrivee' => 'Manakara',
                'tarif' => 60000,
                'point_of_recup' => 'Galana Andrefan\'Ambohijanahary',
            ],
            [
                'depart' => 'Manakara',
                'arrivee' => 'Antananarivo',
                'tarif' => 60000,
                'point_of_recup' => 'Galana Andrefan\'Ambohijanahary',
            ],
            [
                'depart' => 'Antananarivo',
                'arrivee' => 'Morondava',
                'tarif' => 60000,
                'point_of_recup' => 'Galana Andrefan\'Ambohijanahary',
            ],
            [
                'depart' => 'Morondava',
                'arrivee' => 'Antananarivo',
                'tarif' => 60000,
                'point_of_recup' => 'Galana Andrefan\'Ambohijanahary',
            ],
            [
                'depart' => 'Antananarivo',
                'arrivee' => 'Mahajanga',
                'tarif' => 65000,
                'point_of_recup' => 'Galana Andrefan\'Ambohijanahary',
            ],
            [
                'depart' => 'Mahajanga',
                'arrivee' => 'Antananarivo',
                'tarif' => 65000,
                'point_of_recup' => 'Galana Andrefan\'Ambohijanahary',
            ],
            [
                'depart' => 'Antananarivo',
                'arrivee' => 'Farafangana',
                'tarif' => 65000,
                'point_of_recup' => 'Galana Andrefan\'Ambohijanahary',
            ],
            [
                "depart" => "Farafangana",
                "arrivee" => "Antananarivo",
                "tarif" => 65000,
                'point_of_recup' => 'Galana Andrefan\'Ambohijanahary',
            ]
        ],
        "LITE" => [
            [
                'depart' => 'Antananarivo',
                'arrivee' => 'Morondava',
                'tarif' => 60000,
                'point_of_recup' => 'Galana Andrefan\'Ambohijanahary',
            ],
            [
                'depart' => 'Morondava',
                'arrivee' => 'Antananarivo',
                'tarif' => 60000,
                'point_of_recup' => 'Galana Andrefan\'Ambohijanahary',
            ]
        ]
        
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->data as $type => $trajets) {
            foreach ($trajets as $trajet) {
                $classe_id = Classe::where('nom', $type)->first()->id;
                $ville_depart_id = Ville::where('nom', $trajet['depart'])->firstOrFail()->id;
                $ville_arrivee_id = Ville::where('nom', $trajet['arrivee'])->firstOrFail()->id;
                Trajet::create([
                    'classe_id' => $classe_id,
                    'ville_depart_id' => $ville_depart_id,
                    'ville_arrivee_id' => $ville_arrivee_id,
                    'tarif' => $trajet['tarif']
                ]);
            }
        }
    }
}
