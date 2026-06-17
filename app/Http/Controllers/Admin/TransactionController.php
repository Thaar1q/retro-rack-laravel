<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('user')
            ->when($request->search, fn($q) => 
                $q->where('invoice_number', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', fn($q2) => $q2->where('name', 'like', '%' . $request->search . '%'))
            )
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.transaksi', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('user', 'details.product');
        return view('admin.transaksi-detail', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,shipped,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status transaksi berhasil diperbarui.');
    }
}
