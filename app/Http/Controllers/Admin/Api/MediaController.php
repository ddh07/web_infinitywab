<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Throwable;

class MediaController extends Controller
{
    private const IMAGE_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'ico'];
    private const DOCUMENT_EXTENSIONS = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'csv', 'zip', 'txt', 'md', 'markdown'];
    private const THUMBNAIL_SIZE = 400;

    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 24);
        $perPage = $perPage < 1 ? 24 : min($perPage, 100);

        $media = Media::query()
            ->ofType($request->query('type'))
            ->search($request->query('search'))
            ->latest()
            ->paginate($perPage);

        return response()->json($media);
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'max:10240',
                'mimes:' . implode(',', [...self::IMAGE_EXTENSIONS, ...self::DOCUMENT_EXTENSIONS]),
            ],
        ]);

        $file = $request->file('file');
        $extension = strtolower($file->getClientOriginalExtension());
        $isImage = in_array($extension, self::IMAGE_EXTENSIONS, true);

        $filename = Str::uuid() . '.' . $extension;
        $path = $file->storeAs('media', $filename, 'public');

        [$thumbnailPath, $width, $height] = $isImage
            ? $this->makeThumbnail($path, $filename)
            : [null, null, null];

        $media = Media::create([
            'disk' => 'public',
            'path' => $path,
            'thumbnail_path' => $thumbnailPath,
            'original_filename' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'type' => $isImage ? 'image' : 'file',
            'width' => $width,
            'height' => $height,
            'uploaded_by' => $request->user()?->id,
        ]);

        return response()->json($media, 201);
    }

    public function destroy($id)
    {
        $media = Media::findOrFail($id);

        Storage::disk($media->disk)->delete(array_filter([$media->path, $media->thumbnail_path]));

        $media->delete();

        return response()->json(['message' => 'Fichier supprimé avec succès']);
    }

    /**
     * @return array{0: ?string, 1: ?int, 2: ?int} [thumbnail_path, width, height]
     */
    private function makeThumbnail(string $path, string $filename): array
    {
        try {
            $manager = new ImageManager(new Driver());
            $image = $manager->decodePath(Storage::disk('public')->path($path));
            $width = $image->width();
            $height = $image->height();

            $thumbnailPath = 'media/thumbs/' . $filename;
            Storage::disk('public')->makeDirectory('media/thumbs');
            $image->cover(self::THUMBNAIL_SIZE, self::THUMBNAIL_SIZE)
                ->save(Storage::disk('public')->path($thumbnailPath));

            return [$thumbnailPath, $width, $height];
        } catch (Throwable) {
            // L'upload reste valide même si la génération de miniature échoue
            // (fichier image corrompu/format exotique) : repli sur l'icône générique.
            return [null, null, null];
        }
    }
}
