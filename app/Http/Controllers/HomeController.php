<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
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

        return view('welcome', compact('featuredProducts', 'latestArticles', 'categories'));
    }
}
