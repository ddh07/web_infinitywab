<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Quels types de services proposez-vous ?',
                'answer' => "Maintenance informatique, réseaux et sécurité (câblage, Wi-Fi, vidéosurveillance, contrôle d'accès), développement de sites web et d'applications, réparation électronique et microsoudure, ainsi que du conseil et des formations. Le détail complet est sur notre page Services.",
                'order' => 1,
            ],
            [
                'question' => 'Sous quel délai me répondez-vous après une prise de contact ?',
                'answer' => 'Nous répondons sous 24h aux demandes envoyées via le formulaire ou par email, du lundi au vendredi.',
                'order' => 2,
            ],
            [
                'question' => 'Comment se déroule une demande de devis ?',
                'answer' => "Vous nous décrivez votre besoin via le formulaire de contact, par téléphone ou WhatsApp. Nous échangeons ensuite avec vous pour cadrer le projet avant de vous transmettre une proposition.",
                'order' => 3,
            ],
            [
                'question' => 'Travaillez-vous avec des entreprises et des particuliers ?',
                'answer' => "Oui. Nous accompagnons aussi bien des entreprises et institutions que des particuliers, selon le service concerné.",
                'order' => 4,
            ],
            [
                'question' => 'Proposez-vous des formations ?',
                'answer' => "Oui, nous organisons régulièrement des sessions de formation pratique (informatique, réparation électronique, installation de caméras, entre autres). Contactez-nous pour connaître les prochaines sessions.",
                'order' => 5,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(['question' => $faq['question']], $faq);
        }
    }
}
