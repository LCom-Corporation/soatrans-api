<?php

namespace Database\Seeders;

use App\Models\Classe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClasseSeeder extends Seeder
{

    private $data = [
        [
            'nom' => 'GOLD',
            'image_path' => 'storage/classe/gold.png',
            "details" => [
                [
                    'description' => 'Toyota Hiace High Roof 2021',
                ],
                [
                    'description' => 'Foton View G7 2021',
                ],
                [
                    'description' => '12 places',
                ],
                [
                    'description' => 'Wifi',
                ],
                [
                    'description' => 'Niveau de confort d\'exception',
                ],
                [
                    'description' => 'GPS avec limitation de vitesse',
                ],
                [
                    'description' => 'Bouteilles d\'eau ou Petit déjeuner offert',
                ],
                [
                    'description' => 'Service de remisage et ramassage possible sur le trajet',
                ],

            ],
        ],
        [
            'nom' => 'VIP',
            'image_path' => 'storage/classe/vip.png',
            "details" => [
                [
                    'description' => 'Hyundai Grand Starex',
                ],
                [
                    'description' => '9 places',
                ],
                [
                    'description' => 'Wifi',
                ],
                [
                    'description' => 'Climatisation intégrale',
                ],
                [
                    'description' => 'GPS avec limitation de vitesse',
                ],
                [
                    'description' => 'Bouteilles d\'eau offerte',
                ]
            ],
        ],
        [
            'nom' => 'PREMIUM',
            'image_path' => 'storage/classe/premium.png',
            "details" => [
                [
                    'description' => 'Volswagen Crafter Phase II',
                ],
                [
                    'description' => '16 / 19 / 21 / 22 places',
                ],
                [
                    'description' => 'Wifi',
                ],
                [
                    'description' => 'GPS avec limitation de vitesse',
                ],
                [
                    'description' => 'Ecran Télé',
                ]
            ],
        ],
        [
            'nom' => 'LITE',
            'image_path' => 'storage/classe/lite.png',
            "details" => [
                [
                    'description' => 'Mercedes Sprinter Phase II',
                ],
                [
                    'description' => '16 places',
                ],
                [
                    'description' => 'Wifi',
                ],
                [
                    'description' => 'GPS avec limitation de vitesse',
                ],
                [
                    'description' => 'Bouteille d\'eau offerte',
                ]

            ],
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->data as $class) {
            $classe = Classe::create([
                'nom' => $class['nom'],
                'image_path' => $class['image_path'],
            ]);
            foreach ($class['details'] as $detail) {
                $classe->classeDetails()->create($detail);
            }
        }
    }
}
