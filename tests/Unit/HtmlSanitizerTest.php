<?php

namespace Tests\Unit;

use App\Support\HtmlSanitizer;
use Tests\TestCase;

class HtmlSanitizerTest extends TestCase
{
    public function test_it_keeps_allowed_formatting_and_images(): void
    {
        $html = '<h2>Titre</h2><p>Texte <strong>gras</strong> avec <a href="https://example.com">un lien</a>.</p>'
            . '<img src="/storage/media/test.jpg" alt="Test" width="400" height="300">';

        $clean = HtmlSanitizer::sanitize($html);

        $this->assertStringContainsString('<h2>Titre</h2>', $clean);
        $this->assertStringContainsString('<strong>gras</strong>', $clean);
        $this->assertStringContainsString('href="https://example.com"', $clean);
        $this->assertStringContainsString('<img src="/storage/media/test.jpg" alt="Test" width="400" height="300">', $clean);
    }

    public function test_it_strips_scripts_and_event_handlers(): void
    {
        $html = '<p onclick="alert(1)">Injection <script>alert(2)</script></p>';

        $clean = HtmlSanitizer::sanitize($html);

        $this->assertStringNotContainsString('onclick', $clean);
        $this->assertStringNotContainsString('<script', $clean);
        $this->assertStringNotContainsString('alert(2)', $clean);
    }

    public function test_it_strips_javascript_uri_from_image_src(): void
    {
        $html = '<img src="javascript:alert(1)" alt="x">';

        $clean = HtmlSanitizer::sanitize($html);

        $this->assertStringNotContainsString('javascript:', $clean);
    }

    public function test_it_returns_null_for_null_input(): void
    {
        $this->assertNull(HtmlSanitizer::sanitize(null));
    }
}
