<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'Maintenance Informatique',
                'slug' => 'maintenance-informatique',
                'description' => 'Entretien préventif et curatif de vos équipements informatiques. Diagnostics rapides et réparations professionnelles.',
                'content' => 'Notre service de maintenance informatique couvre tous les aspects de la gestion de vos équipements informatiques. Nous intervenons rapidement pour diagnostiquer et résoudre les problèmes matériels et logiciels, assurer les mises à jour, optimiser les performances et prévenir les pannes grâce à un entretien préventif régulier.',
                'icon' => 'monitor',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'title' => 'Réseaux & Sécurité',
                'slug' => 'reseaux-securite',
                'description' => 'Installation et configuration de réseaux informatiques sécurisés. Protection de vos données et optimisation de votre connectivité.',
                'content' => 'Nous concevons, installons et maintenons des infrastructures réseau robustes et sécurisées. De la configuration des routeurs et switchs à la mise en place de solutions de cybersécurité avancées, nous assurons la protection de vos données sensibles et l\'optimisation de votre connectivité.',
                'icon' => 'wifi',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'title' => 'Développement d\'Applications',
                'slug' => 'developpement-applications',
                'description' => 'Création d\'applications web et mobiles sur mesure. Solutions logicielles adaptées à vos besoins spécifiques.',
                'content' => 'Notre équipe de développeurs crée des applications web et mobiles sur mesure qui répondent précisément à vos besoins métier. Nous maîtrisons les dernières technologies pour vous livrer des solutions performantes, évolutives et intuitives.',
                'icon' => 'code',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'title' => 'Création Technologique',
                'slug' => 'creation-technologique',
                'description' => 'Montage d\'équipements sur mesure et solutions techniques personnalisées. Conseil et expertise pour vos projets technologiques.',
                'content' => 'Nous spécialisons dans la création de solutions technologiques personnalisées, du montage d\'ordinateurs sur mesure à la configuration d\'équipements spécialisés. Notre expertise technique vous garantit des solutions parfaitement adaptées à vos besoins.',
                'icon' => 'cog',
                'is_active' => true,
                'order' => 4,
            ],
            [
                'title' => 'Innovation & Domotique',
                'slug' => 'innovation-domotique',
                'description' => 'Solutions domotiques et objets connectés pour moderniser votre espace de vie ou de travail. Innovation au service de votre confort.',
                'content' => 'Nous intégrons les dernières technologies de domotique pour transformer votre espace en environnement intelligent et connecté. Contrôle de l\'éclairage, chauffage, sécurité et bien plus encore pour un confort optimal et des économies d\'énergie.',
                'icon' => 'lightbulb',
                'is_active' => true,
                'order' => 5,
            ],
            [
                'title' => 'Conseil & Formation',
                'slug' => 'conseil-formation',
                'description' => 'Accompagnement stratégique et formation technique. Montée en compétences et transfert de savoir-faire technologique.',
                'content' => 'Nos experts vous accompagnent dans vos projets technologiques avec des conseils stratégiques personnalisés. Nous proposons également des formations techniques adaptées à votre niveau pour vous permettre de maîtriser les nouvelles technologies.',
                'icon' => 'academic-cap',
                'is_active' => true,
                'order' => 6,
            ],
        ];

        foreach ($services as $service) {
            DB::table('services')->insert([
                ...$service,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
