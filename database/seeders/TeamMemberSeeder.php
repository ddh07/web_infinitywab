<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    /**
     * Profils d'exemple (données fictives), en attendant les vrais membres de
     * l'équipe. Chaque profil le précise explicitement dans sa bio.
     */
    public function run(): void
    {
        $members = [
            [
                'name' => 'Membre exemple 1',
                'role' => 'Direction générale',
                'bio' => "Pilote la vision et la stratégie de l'entreprise. (Profil d'exemple, à remplacer par un vrai membre de l'équipe.)",
                'order' => 1,
            ],
            [
                'name' => 'Membre exemple 2',
                'role' => 'Responsable technique',
                'bio' => "Supervise les interventions réseaux, sécurité et développement. (Profil d'exemple, à remplacer par un vrai membre de l'équipe.)",
                'order' => 2,
            ],
            [
                'name' => 'Membre exemple 3',
                'role' => 'Chargé(e) de projets',
                'bio' => "Coordonne le suivi client et la livraison des projets. (Profil d'exemple, à remplacer par un vrai membre de l'équipe.)",
                'order' => 3,
            ],
        ];

        foreach ($members as $member) {
            TeamMember::updateOrCreate(['name' => $member['name']], $member);
        }
    }
}
