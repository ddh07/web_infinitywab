<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Avis d'exemple (données fictives), en attendant de vrais témoignages clients.
     * Chaque avis le précise explicitement dans son contenu.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Client exemple A',
                'role' => 'Direction, PME locale',
                'content' => "Intervention rapide et suivi sérieux sur notre infrastructure réseau. (Avis d'exemple, à remplacer par un vrai témoignage client.)",
                'rating' => 5,
                'order' => 1,
            ],
            [
                'name' => 'Client exemple B',
                'role' => 'Responsable informatique, institution',
                'content' => "Équipe réactive pour la maintenance de notre parc informatique. (Avis d'exemple, à remplacer par un vrai témoignage client.)",
                'rating' => 5,
                'order' => 2,
            ],
            [
                'name' => 'Client exemple C',
                'role' => 'Particulier',
                'content' => "Bon accompagnement pour l'installation de nos caméras de sécurité. (Avis d'exemple, à remplacer par un vrai témoignage client.)",
                'rating' => 4,
                'order' => 3,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::updateOrCreate(['name' => $testimonial['name']], $testimonial);
        }
    }
}
