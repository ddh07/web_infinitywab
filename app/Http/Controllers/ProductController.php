<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::active()
            ->ordered()
            ->get();

        $featuredProducts = $products
            ->filter(fn($product) => $product->is_featured)
            ->values()
            ->take(3);

        $categoryFilters = $products
            ->pluck('category')
            ->filter()
            ->unique()
            ->values();

        $productHighlights = [
            'total' => $products->count(),
            'featured' => $featuredProducts->count(),
            'avg_price' => $products->avg('price'),
        ];

        return view('products', compact('products', 'featuredProducts', 'categoryFilters', 'productHighlights'));
    }

    public function show($slug)
    {
        $product = Product::active()
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedProducts = Product::active()
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('product-detail', compact('product', 'relatedProducts'));
    }
}
