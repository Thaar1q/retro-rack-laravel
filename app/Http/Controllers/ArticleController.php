<?php

namespace App\Http\Controllers;

use App\Models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::where('is_published', true)
            ->when(request('tag'), fn($q) => $q->where('tag', request('tag')))
            ->latest('published_at')
            ->paginate(6)
            ->withQueryString();

        return view('artikel', compact('articles'));
    }

    public function show(Article $article)
    {
        abort_if(!$article->is_published, 404);

        $related = Article::where('is_published', true)
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('detail-artikel', compact('article', 'related'));
    }
}
