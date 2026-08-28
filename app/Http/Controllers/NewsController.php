<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Database\Eloquent\Builder;

class NewsController extends Controller
{
    private const LISTED_TYPES = ['post', 'article', 'announcement'];

    private function visible(Builder $query): Builder
    {
        return $query->published()->where(function ($q) {
            $q->whereNull('published_at')->orWhere('published_at', '<=', now());
        });
    }

    public function index()
    {
        $featured = $this->visible(Content::whereIn('type', self::LISTED_TYPES))
            ->featured()
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        $articles = $this->visible(Content::whereIn('type', self::LISTED_TYPES))
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->paginate(9);

        return view('news', compact('featured', 'articles'));
    }

    public function show($slug)
    {
        $article = $this->visible(Content::where('slug', $slug))->firstOrFail();

        $related = $this->visible(Content::whereIn('type', self::LISTED_TYPES))
            ->where('id', '!=', $article->id)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('news-detail', compact('article', 'related'));
    }
}
