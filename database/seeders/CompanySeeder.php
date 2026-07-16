<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::create([
            'name' => 'Infinity WAB',
            'description' => 'L\'excellence technologique africaine au service de l\'innovation. Nous transformons les idées en solutions digitales puissantes pour un avenir numérique prospère au Burkina Faso et en Afrique.',
            'vision' => 'Devenir le leader technologique de référence en Afrique de l\'Ouest, en créant des solutions qui anticipent les besoins de demain.',
            'mission' => 'Propulser la transformation digitale des entreprises africaines grâce à des solutions technologiques innovantes, adaptées et accessibles, tout en formant la prochaine génération de talents technologiques.',
            'email' => 'contact@infinity-wab.bf',
            'phone' => '+226 XX XX XX XX',
            'address' => 'Ouagadougou, Burkina Faso',
            'website' => 'https://infinity-wab.bf',
            'founded_year' => '2017',
            'employees_count' => 25,
            'social_links' => [
                'facebook' => 'https://facebook.com/infinity-wab',
                'twitter' => 'https://twitter.com/infinity_wab',
                'linkedin' => 'https://linkedin.com/company/infinity-wab',
                'instagram' => 'https://instagram.com/infinity_wab'
            ],
            'stats' => [
                'years_experience' => 7,
                'projects_completed' => 250,
                'satisfied_clients' => 150,
                'support_availability' => '24/7',
                'countries_served' => 8,
                'technologies_mastered' => 15
            ],
            'is_active' => true
        ]);
    }
}
