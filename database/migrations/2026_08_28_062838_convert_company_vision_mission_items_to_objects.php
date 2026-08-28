<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * vision/mission passent d'un tableau de chaînes à un tableau d'objets
     * {title, body, icon, image} — même forme que "values" — pour permettre une
     * icône/image par énoncé (voir x-ui.content-list). Convertit chaque chaîne
     * existante en objet équivalent (title = texte, body/icon/image = vides) sans
     * perte de contenu.
     */
    public function up(): void
    {
        DB::table('companies')->get()->each(function ($company) {
            $updates = [];
            foreach (['vision', 'mission', 'values'] as $field) {
                $raw = $company->$field;
                if ($raw === null || $raw === '') {
                    continue;
                }
                $items = json_decode($raw, true);
                if (! is_array($items)) {
                    continue;
                }
                $changed = false;
                $normalized = array_map(function ($item) use (&$changed) {
                    if (is_array($item)) {
                        $merged = array_merge(['title' => '', 'body' => '', 'icon' => null, 'image' => null], $item);
                        if ($merged !== $item) {
                            $changed = true;
                        }
                        return $merged;
                    }
                    $changed = true;
                    return ['title' => (string) $item, 'body' => '', 'icon' => null, 'image' => null];
                }, $items);

                if ($changed) {
                    $updates[$field] = json_encode($normalized, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                }
            }
            if ($updates) {
                DB::table('companies')->where('id', $company->id)->update($updates);
            }
        });
    }

    public function down(): void
    {
        DB::table('companies')->get()->each(function ($company) {
            $updates = [];
            foreach (['vision', 'mission'] as $field) {
                $raw = $company->$field;
                if ($raw === null || $raw === '') {
                    continue;
                }
                $items = json_decode($raw, true);
                if (! is_array($items)) {
                    continue;
                }
                $updates[$field] = json_encode(array_map(
                    fn ($item) => is_array($item) ? ($item['title'] ?? '') : (string) $item,
                    $items
                ), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            }
            if ($updates) {
                DB::table('companies')->where('id', $company->id)->update($updates);
            }
        });
    }
};
