<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $items = Cart::with('product.category')
            ->where('user_id', auth()->id())
            ->get();

        $shipping = 50000;
        $subtotal = $items->sum(fn($item) => $item->subtotal());
        $total    = $subtotal + $shipping;

        return view('keranjang', compact('items', 'subtotal', 'shipping', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'integer|min:1|max:99',
        ]);

        $product = Product::findOrFail($request->product_id);
        $qty = (int) $request->input('quantity', 1);

        if ($product->stock < 1) {
            $msg = 'Produk habis.';
            return $request->wantsJson()
                ? response()->json(['success' => false, 'message' => $msg], 422)
                : back()->with('error', $msg);
        }

        // Upsert: if already in cart, increment; otherwise insert
        $cartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        $newQty = $cartItem ? $cartItem->quantity + $qty : $qty;

        // Cap at available stock
        if ($newQty > $product->stock) {
            $msg = 'Jumlah melebihi stok tersedia (' . $product->stock . ' unit).';
            return $request->wantsJson()
                ? response()->json(['success' => false, 'message' => $msg], 422)
                : back()->with('error', $msg);
        }

        if ($cartItem) {
            $cartItem->update(['quantity' => $newQty]);
        } else {
            Cart::create([
                'user_id'    => auth()->id(),
                'product_id' => $product->id,
                'quantity'   => $qty,
            ]);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => '"' . $product->name . '" ditambahkan ke keranjang.',
                'cart_count' => Cart::where('user_id', auth()->id())->count()
            ]);
        }

        return back()->with('success', '"' . $product->name . '" ditambahkan ke keranjang.');
    }

    public function update(Request $request, Cart $cart)
    {
        abort_if($cart->user_id !== auth()->id(), 403);

        $request->validate(['quantity' => 'required|integer|min:1|max:99']);

        // Cap at product stock
        $maxQty = $cart->product->stock ?? 99;
        $qty    = min((int) $request->quantity, $maxQty);
        $cart->update(['quantity' => $qty]);

        if ($request->wantsJson()) {
            $items = Cart::where('user_id', auth()->id())->get();
            $subtotal = $items->sum(fn($item) => $item->subtotal());
            return response()->json([
                'success' => true,
                'item_total' => number_format($cart->subtotal(), 0, ',', '.'),
                'subtotal' => number_format($subtotal, 0, ',', '.'),
                'total' => number_format($subtotal + 50000, 0, ',', '.')
            ]);
        }
        return back();
    }

    public function remove(Cart $cart)
    {
        abort_if($cart->user_id !== auth()->id(), 403);
        $cart->delete();
        if (request()->wantsJson()) {
            $items = Cart::where('user_id', auth()->id())->get();
            $subtotal = $items->sum(fn($item) => $item->subtotal());
            return response()->json([
                'success' => true,
                'cart_count' => Cart::where('user_id', auth()->id())->count(),
                'subtotal' => number_format($subtotal, 0, ',', '.'),
                'total' => number_format($subtotal + 50000, 0, ',', '.')
            ]);
        }
        return back()->with('success', 'Item dihapus dari keranjang.');
    }
}
