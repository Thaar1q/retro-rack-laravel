<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /** Show checkout form — requires items in cart. */
    public function checkout()
    {
        $items = Cart::with('product')->where('user_id', auth()->id())->get();

        if ($items->isEmpty()) {
            return redirect()->route('keranjang')->with('error', 'Keranjang kosong.');
        }

        $shipping = 50000;
        $subtotal = $items->sum(fn($item) => $item->subtotal());
        $total    = $subtotal + $shipping;

        return view('checkout', compact('items', 'subtotal', 'shipping', 'total'));
    }

    /** Process checkout form submission. */
    public function store(Request $request)
    {
        $data = $request->validate([
            'recipient_name'   => 'required|string|max:255',
            'recipient_phone'  => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'shipping_city'    => 'required|string|max:100',
            'postal_code'      => 'required|string|max:10',
            'notes'            => 'nullable|string|max:500',
        ]);

        $items = Cart::with('product')->where('user_id', auth()->id())->get();

        if ($items->isEmpty()) {
            return redirect()->route('keranjang')->with('error', 'Keranjang kosong.');
        }

        $shipping = 50000;
        $subtotal = $items->sum(fn($item) => $item->subtotal());

        $paymentMethod = $request->input('payment') === 'qris' ? 'QRIS' : 'Transfer Bank';

        DB::transaction(function () use ($data, $items, $subtotal, $shipping, $paymentMethod) {
            $order = Order::create([
                'user_id'          => auth()->id(),
                'invoice_number'   => 'INV-' . date('Y') . '-' . str_pad(Order::count() + 1, 5, '0', STR_PAD_LEFT),
                'total_price'      => $subtotal + $shipping,
                'status'           => 'pending',
                'recipient_name'   => $data['recipient_name'],
                'recipient_phone'  => $data['recipient_phone'],
                'shipping_address' => $data['shipping_address'],
                'shipping_city'    => $data['shipping_city'],
                'postal_code'      => $data['postal_code'],
                'notes'            => $data['notes'] ?? null,
                'payment_method'   => $paymentMethod,
                'shipping_method'  => 'JNE Reguler',
            ]);

            foreach ($items as $item) {
                OrderDetail::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item->product_id,
                    'product_name' => $item->product->name,
                    'price'        => $item->product->price,
                    'quantity'     => $item->quantity,
                ]);

                // Guard: only decrement if stock is sufficient (prevents BIGINT UNSIGNED underflow)
                $product = Product::lockForUpdate()->find($item->product_id);
                if ($product && $product->stock >= $item->quantity) {
                    $product->decrement('stock', $item->quantity);
                }
            }

            Cart::where('user_id', auth()->id())->delete();
        });

        return redirect()->route('checkout.success')->with('success', 'Pesanan berhasil dibuat!');
    }

    public function success()
    {
        // Pass last order to the success view
        $order = Order::with('details')
            ->where('user_id', auth()->id())
            ->latest()
            ->first();

        return view('checkout-success', compact('order'));
    }

    public function history()
    {
        $status = request('status');
        $statusGroups = [
            'berlangsung' => ['pending', 'processing', 'shipped'],
            'selesai'     => ['completed'],
            'dibatalkan'  => ['cancelled'],
        ];

        $orders = Order::with('details.product')
            ->where('user_id', auth()->id())
            ->when($status && isset($statusGroups[$status]), fn($q) => $q->whereIn('status', $statusGroups[$status]))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('riwayat', compact('orders', 'status'));
    }

    public function orderDetail(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);
        $order->load('details.product');
        return view('checkout-success', compact('order'));
    }



    public function track(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);
        return view('tracking', compact('order'));
    }
}
