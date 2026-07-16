<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title' => 'Site E-commerce TechShop',
                'slug' => 'site-e-commerce-techshop',
                'description' => 'Plateforme e-commerce complète avec gestion des stocks et paiements en ligne',
                'content' => 'Développement d\'une plateforme e-commerce moderne pour TechShop, incluant un catalogue de produits, un panier d\'achat, une gestion des stocks en temps réel, et une intégration sécurisée des paiements. Le site est optimisé pour le mobile et inclut un tableau de bord administratif complet.',
                'client' => 'TechShop BF',
                'category' => 'E-commerce',
                'project_date' => '2024-03-15',
                'image' => 'projects/techshop.jpg',
                'status' => 'termine',
                'is_featured' => true,
                'is_active' => true,
                'order' => 1,
            ],
            [
                'title' => 'Application Mobile Banking',
                'slug' => 'application-mobile-banking',
                'description' => 'Application mobile de banque avec authentification biométrique et transactions sécurisées',
                'content' => 'Création d\'une application mobile bancaire complète avec authentification biométrique, consultation des soldes, virements, paiement de factures, et notification push en temps réel. L\'application respecte les normes de sécurité bancaire les plus strictes.',
                'client' => 'Banque Nationale du Burkina',
                'category' => 'Application Mobile',
                'project_date' => '2024-02-20',
                'image' => 'projects/banking-app.jpg',
                'status' => 'en_cours',
                'is_featured' => true,
                'is_active' => true,
                'order' => 2,
            ],
            [
                'title' => 'Réseau Entreprise SOGEB',
                'slug' => 'reseau-entreprise-sogeb',
                'description' => 'Infrastructure réseau complète pour une entreprise de 200 employés',
                'content' => 'Mise en place d\'une infrastructure réseau complète incluant le câblage structuré, la configuration des switchs et routeurs, la mise en place de VLANs, l\'installation de pare-feu et la configuration VPN pour le télétravail.',
                'client' => 'SOGEB',
                'category' => 'Infrastructure',
                'project_date' => '2024-01-10',
                'image' => 'projects/sogeb-network.jpg',
                'status' => 'en_attente',
                'is_featured' => false,
                'is_active' => true,
                'order' => 3,
            ],
            [
                'title' => 'Système de Gestion Scolaire',
                'slug' => 'systeme-gestion-scolaire',
                'description' => 'Plateforme de gestion complète pour établissement scolaire',
                'content' => 'Développement d\'un système de gestion scolaire intégrant la gestion des étudiants, des professeurs, des cours, des notes, des absences, et la communication avec les parents. Le système inclut un portail élève et parent.',
                'client' => 'Lycée Municipal de Ouagadougou',
                'category' => 'Application Web',
                'project_date' => '2023-12-05',
                'image' => 'projects/school-system.jpg',
                'status' => 'termine',
                'is_featured' => true,
                'is_active' => true,
                'order' => 4,
            ],
            [
                'title' => 'Solution Domotique Villa Moderne',
                'slug' => 'solution-domotique-villa-moderne',
                'description' => 'Installation complète domotique pour résidence de luxe',
                'content' => 'Installation d\'un système domotique complet contrôlant l\'éclairage, le chauffage, la climatisation, la sécurité, les volets roulants et l\'audiovisuel. Le système est contrôlable via smartphone et assistant vocal.',
                'client' => 'Client Privé',
                'category' => 'Domotique',
                'project_date' => '2023-11-20',
                'image' => 'projects/smart-home.jpg',
                'status' => 'termine',
                'is_featured' => false,
                'is_active' => true,
                'order' => 5,
            ],
        ];

        foreach ($projects as $project) {
            DB::table('projects')->insert([
                ...$project,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
