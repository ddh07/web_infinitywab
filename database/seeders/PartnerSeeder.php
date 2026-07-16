<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partners = [
            [
                'name' => 'Microsoft',
                'description' => 'Leader mondial des logiciels et solutions cloud',
                'website' => 'https://microsoft.com',
                'logo' => 'images/partners/microsoft.png',
                'category' => 'technologique',
                'sort_order' => 1,
                'is_active' => true
            ],
            [
                'name' => 'Cisco',
                'description' => 'Solutions de réseautique et cybersécurité',
                'website' => 'https://cisco.com',
                'logo' => 'images/partners/cisco.png',
                'category' => 'technologique',
                'sort_order' => 2,
                'is_active' => true
            ],
            [
                'name' => 'Oracle',
                'description' => 'Solutions de base de données et cloud',
                'website' => 'https://oracle.com',
                'logo' => 'images/partners/oracle.png',
                'category' => 'technologique',
                'sort_order' => 3,
                'is_active' => true
            ],
            [
                'name' => 'AWS',
                'description' => 'Amazon Web Services - Cloud Computing',
                'website' => 'https://aws.amazon.com',
                'logo' => 'images/partners/aws.png',
                'category' => 'technologique',
                'sort_order' => 4,
                'is_active' => true
            ],
            [
                'name' => 'Banque Atlantique',
                'description' => 'Partenaire financier pour vos projets',
                'website' => 'https://banque-atlantique.bf',
                'logo' => 'images/partners/banque-atlantique.png',
                'category' => 'financier',
                'sort_order' => 5,
                'is_active' => true
            ],
            [
                'name' => 'UBA Burkina',
                'description' => 'Partenaire bancaire pour le développement',
                'website' => 'https://uba.bf',
                'logo' => 'images/partners/uba.png',
                'category' => 'financier',
                'sort_order' => 6,
                'is_active' => true
            ]
        ];

        foreach ($partners as $partner) {
            Partner::create($partner);
        }
    }
}
