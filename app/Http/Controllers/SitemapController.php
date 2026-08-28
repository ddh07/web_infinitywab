<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Product;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $xml = Cache::remember('sitemap.xml', 3600, function () {
            $urls = [
                ['loc' => route('home'), 'priority' => '1.0'],
                ['loc' => route('services'), 'priority' => '0.9'],
                ['loc' => route('projects'), 'priority' => '0.8'],
                ['loc' => route('products'), 'priority' => '0.8'],
                ['loc' => route('news'), 'priority' => '0.7'],
                ['loc' => route('about'), 'priority' => '0.7'],
                ['loc' => route('contact'), 'priority' => '0.7'],
                ['loc' => route('company'), 'priority' => '0.5'],
                ['loc' => route('privacy'), 'priority' => '0.3'],
                ['loc' => route('terms'), 'priority' => '0.3'],
            ];

            foreach (Service::active()->ordered()->get() as $service) {
                $urls[] = ['loc' => route('services.show', $service->slug), 'priority' => '0.7', 'lastmod' => $service->updated_at];
            }

            foreach (Project::active()->ordered()->get() as $project) {
                $urls[] = ['loc' => route('projects.show', $project->slug), 'priority' => '0.6', 'lastmod' => $project->updated_at];
            }

            foreach (Product::active()->ordered()->get() as $product) {
                $urls[] = ['loc' => route('products.show', $product->slug), 'priority' => '0.6', 'lastmod' => $product->updated_at];
            }

            $publishedArticles = Content::published()
                ->where(function ($q) {
                    $q->whereNull('published_at')->orWhere('published_at', '<=', now());
                })
                ->get();

            foreach ($publishedArticles as $article) {
                $urls[] = ['loc' => route('news.show', $article->slug), 'priority' => '0.5', 'lastmod' => $article->updated_at];
            }

            return view('sitemap', ['urls' => $urls])->render();
        });

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
