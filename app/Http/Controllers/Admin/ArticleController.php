<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with('author');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('is_published', $request->status);
        }

        $articles = $query->latest()->paginate(10)->withQueryString();
        return view('admin.artikel', compact('articles'));
    }

    public function create()
    {
        return view('admin.artikel-create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'tag'          => 'nullable|string|max:50',
            'excerpt'      => 'nullable|string|max:500',
            'body'         => 'required|string',
            'image'        => 'nullable|image|max:2048',
            'is_published' => 'boolean',
        ]);

        $data['user_id']      = auth()->id();
        $data['slug']         = Str::slug($data['title']);
        $data['is_published'] = $request->boolean('is_published');
        $data['published_at'] = $data['is_published'] ? now() : null;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('articles', 'public');
        }

        Article::create($data);

        return redirect()->route('admin.artikel')->with('success', 'Artikel berhasil disimpan.');
    }

    public function edit(Article $article)
    {
        return view('admin.artikel-edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'tag'          => 'nullable|string|max:50',
            'excerpt'      => 'nullable|string|max:500',
            'body'         => 'required|string',
            'image'        => 'nullable|image|max:2048',
            'is_published' => 'boolean',
        ]);

        $data['is_published'] = $request->boolean('is_published');

        // Only stamp published_at the first time it's published
        if ($data['is_published'] && !$article->published_at) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('articles', 'public');
        }

        $article->update($data);

        return redirect()->route('admin.artikel')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('admin.artikel')->with('success', 'Artikel berhasil dihapus.');
    }
}
