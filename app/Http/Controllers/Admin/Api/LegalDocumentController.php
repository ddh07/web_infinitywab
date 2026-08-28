<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\LegalDocument;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LegalDocumentController extends Controller
{
    private const SLUGS = ['confidentialite', 'conditions-utilisation', 'accessibilite'];
    private const ALLOWED_EXTENSIONS = ['pdf', 'md', 'markdown', 'txt'];

    public function index()
    {
        $documents = LegalDocument::with('media')->whereIn('slug', self::SLUGS)->get()->keyBy('slug');

        $payload = collect(self::SLUGS)
            ->map(fn ($slug) => $documents->get($slug) ?? ['slug' => $slug])
            ->values();

        return response()->json($payload);
    }

    public function upload(Request $request, string $slug)
    {
        abort_unless(in_array($slug, self::SLUGS, true), 404);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'media_id' => [
                'required',
                'integer',
                'exists:media,id',
                function ($attribute, $value, $fail) {
                    $extension = strtolower(pathinfo(Media::find($value)?->original_filename ?? '', PATHINFO_EXTENSION));
                    if (! in_array($extension, self::ALLOWED_EXTENSIONS, true)) {
                        $fail('Le fichier choisi dans la bibliothèque doit être un PDF ou un document Markdown (.md, .txt).');
                    }
                },
            ],
        ]);

        $media = Media::findOrFail($validated['media_id']);
        $extension = strtolower(pathinfo($media->original_filename, PATHINFO_EXTENSION));
        $format = $extension === 'pdf' ? 'pdf' : 'markdown';

        $document = LegalDocument::firstOrNew(['slug' => $slug]);
        $document->title = $validated['title'];
        $document->format = $format;
        $document->media_id = $media->id;
        // Le markdown est mis en cache en base pour être rendu sans relire le fichier
        // à chaque affichage public ; le PDF, lui, est simplement servi via l'URL du média.
        $document->body = $format === 'markdown' ? Storage::disk($media->disk)->get($media->path) : null;
        $document->save();

        return response()->json($document->load('media'), 201);
    }

    public function destroy(string $slug)
    {
        abort_unless(in_array($slug, self::SLUGS, true), 404);

        $document = LegalDocument::where('slug', $slug)->first();

        if (! $document) {
            return response()->json(['message' => 'Aucun document personnalisé pour ce slug.'], 404);
        }

        // Le fichier média n'est pas supprimé : il reste dans la bibliothèque, où il
        // peut être réutilisé ou géré indépendamment de ce document légal.
        $document->delete();

        return response()->json(['message' => 'Document légal réinitialisé au contenu par défaut.']);
    }
}
