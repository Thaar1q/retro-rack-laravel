<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $featuredProducts = Product::where('is_active', true)
                ->latest()
                ->take(7)
                ->get();

            $latestArticles = Article::where('is_published', true)
                ->latest('published_at')
                ->take(3)
                ->get();

            $categories = Category::withCount(['products' => function ($q) {
                $q->where('is_active', true);
            }])->get();
        } catch (\Throwable $e) {
            // DB unreachable — return empty collections so the page still renders.
            // The error is logged to stderr (visible in Vercel function logs).
            logger()->error('HomeController DB error: ' . $e->getMessage());
            $featuredProducts = new Collection();
            $latestArticles   = new Collection();
            $categories       = new Collection();
        }

        return view('welcome', compact('featuredProducts', 'latestArticles', 'categories'));
    }
}
