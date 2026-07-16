<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'title' => 'PC Gaming Infinity Pro',
                'slug' => 'pc-gaming-infinity-pro',
                'description' => 'PC gaming haute performance avec dernière génération de composants',
                'content' => 'Notre PC Gaming Infinity Pro est conçu pour les joueurs exigeants. Équipé des derniers processeurs Intel Core i9, cartes graphiques NVIDIA RTX 4090, 32GB DDR5, et SSD NVMe ultra-rapide. Refroidissement liquide personnalisé et RGB synchronisé.',
                'price' => 899999.00,
                'category' => 'Ordinateurs',
                'images' => json_encode(['products/pc-gaming-1.jpg', 'products/pc-gaming-2.jpg', 'products/pc-gaming-3.jpg']),
                'specifications' => json_encode([
                    'Processeur' => 'Intel Core i9-13900K',
                    'Carte graphique' => 'NVIDIA RTX 4090 24GB',
                    'Mémoire' => '32GB DDR5 5600MHz',
                    'Stockage' => '2TB NVMe SSD',
                    'Refroidissement' => 'Liquide personnalisé',
                    'Alimentation' => '1000W 80+ Gold'
                ]),
                'is_featured' => true,
                'is_active' => true,
                'order' => 1,
            ],
            [
                'title' => 'Station de Travail Créative',
                'slug' => 'station-travail-creative',
                'description' => 'Station de travail puissante pour créatifs et professionnels',
                'content' => 'Station de travail optimisée pour les créatifs avec processeur AMD Ryzen 9, carte graphique NVIDIA RTX 4070, 64GB DDR5, et stockage hybride ultra-rapide. Parfaite pour le montage vidéo, 3D et design graphique.',
                'price' => 749999.00,
                'category' => 'Ordinateurs',
                'images' => json_encode(['products/workstation-1.jpg', 'products/workstation-2.jpg']),
                'specifications' => json_encode([
                    'Processeur' => 'AMD Ryzen 9 7950X',
                    'Carte graphique' => 'NVIDIA RTX 4070 12GB',
                    'Mémoire' => '64GB DDR5 5600MHz',
                    'Stockage' => '1TB NVMe SSD + 4TB HDD',
                    'Écran' => '4K 32" calibré',
                    'Garantie' => '3 ans sur site'
                ]),
                'is_featured' => true,
                'is_active' => true,
                'order' => 2,
            ],
            [
                'title' => 'Kit Domotique Smart Home',
                'slug' => 'kit-domotique-smart-home',
                'description' => 'Kit complet pour transformer votre maison en maison intelligente',
                'content' => 'Notre kit domotique complet inclut tout ce dont vous avez besoin pour démarrer : hub central, détecteurs de mouvement, capteurs de porte/fenêtre, prises intelligentes, ampoules connectées, et contrôleur universel. Compatible avec Google Home et Alexa.',
                'price' => 249999.00,
                'category' => 'Domotique',
                'images' => json_encode(['products/smart-home-1.jpg', 'products/smart-home-2.jpg', 'products/smart-home-3.jpg']),
                'specifications' => json_encode([
                    'Hub' => 'Central WiFi/Zigbee',
                    'Capteurs' => '4x mouvement, 6x porte/fenêtre',
                    'Prises' => '8x prises intelligentes',
                    'Éclairage' => '6x ampoules RGB',
                    'Contrôle' => 'Télécommande + App mobile',
                    'Compatibilité' => 'Google Home, Alexa, IFTTT'
                ]),
                'is_featured' => false,
                'is_active' => true,
                'order' => 3,
            ],
            [
                'title' => 'Routeur WiFi 6 Pro',
                'slug' => 'routeur-wifi-6-pro',
                'description' => 'Routeur WiFi 6 haute performance pour entreprises',
                'content' => 'Routeur WiFi 6 professionnel avec technologie MU-MIMO, beamforming, et sécurité intégrée. Couverture jusqu\'à 500m², support jusqu\'à 100 appareils simultanés, et débits jusqu\'à 6 Gbps.',
                'price' => 189999.00,
                'category' => 'Réseaux',
                'images' => json_encode(['products/router-1.jpg', 'products/router-2.jpg']),
                'specifications' => json_encode([
                    'Standard' => 'WiFi 6 (802.11ax)',
                    'Débit' => '6 Gbps combiné',
                    'Ports' => '4x Gigabit LAN, 1x WAN',
                    'Couverture' => '500m²',
                    'Appareils' => '100+ simultanés',
                    'Sécurité' => 'Firewall intégré, WPA3'
                ]),
                'is_featured' => false,
                'is_active' => true,
                'order' => 4,
            ],
            [
                'title' => 'Pack Sécurité Caméras HD',
                'slug' => 'pack-securite-cameras-hd',
                'description' => 'Système de surveillance complet avec caméras HD et stockage cloud',
                'content' => 'Pack de surveillance professionnel avec 4 caméras HD 1080p, vision nocturne, détection de mouvement, enregistrement continu 24/7, stockage cloud 30 jours, et application mobile pour consultation en direct.',
                'price' => 329999.00,
                'category' => 'Sécurité',
                'images' => json_encode(['products/security-pack-1.jpg', 'products/security-pack-2.jpg']),
                'specifications' => json_encode([
                    'Caméras' => '4x 1080p HD',
                    'Vision nocturne' => '30m IR',
                    'Stockage' => 'Cloud 30 jours + local',
                    'Détection' => 'Mouvement et personnes',
                    'Application' => 'iOS/Android + Web',
                    'Alertes' => 'Push et email'
                ]),
                'is_featured' => true,
                'is_active' => true,
                'order' => 5,
            ],
        ];

        foreach ($products as $product) {
            DB::table('products')->insert([
                ...$product,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
