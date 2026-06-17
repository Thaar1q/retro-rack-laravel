<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->where('is_active', true);

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('condition')) {
            $query->whereIn('condition', (array) $request->condition);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', (int) str_replace('.', '', $request->min_price));
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', (int) str_replace('.', '', $request->max_price));
        }

        $sortOptions = [
            'terbaru'          => ['created_at', 'desc'],
            'harga_tertinggi'  => ['price', 'desc'],
            'harga_terendah'   => ['price', 'asc'],
        ];

        [$sortCol, $sortDir] = $sortOptions[$request->sort ?? 'terbaru'];
        $query->orderBy($sortCol, $sortDir);

        $products   = $query->paginate(8)->withQueryString();
        $categories = Category::withCount(['products' => fn($q) => $q->where('is_active', true)])->get();

        return view('katalog', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        abort_if(!$product->is_active, 404);

        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(3)
            ->get();

        return view('detail-produk', compact('product', 'related'));
    }
}
