<?php

namespace Tests\Feature;

use App\Models\LegalDocument;
use Tests\TestCase;

class LegalPagesDraftTest extends TestCase
{
    public function test_privacy_page_shows_placeholder_when_no_document(): void
    {
        $response = $this->get(route('privacy'));

        $response->assertOk();
        $response->assertSee('en cours de préparation');
        $response->assertDontSee('Brouillon');
        $response->assertDontSee('Préambule et responsable du traitement');
    }

    public function test_terms_page_shows_placeholder_when_no_document(): void
    {
        $response = $this->get(route('terms'));

        $response->assertOk();
        $response->assertSee('en cours de préparation');
        $response->assertDontSee('Brouillon');
        $response->assertDontSee("Objet et acceptation");
    }

    public function test_privacy_page_shows_full_content_when_document_exists(): void
    {
        LegalDocument::create([
            'slug' => 'confidentialite',
            'title' => 'Politique de confidentialité',
            'format' => 'markdown',
            'body' => 'Contenu validé par notre conseil juridique.',
        ]);

        $response = $this->get(route('privacy'));

        $response->assertOk();
        $response->assertDontSee('en cours de préparation');
        $response->assertSee('Contenu validé par notre conseil juridique.', false);
    }
}
