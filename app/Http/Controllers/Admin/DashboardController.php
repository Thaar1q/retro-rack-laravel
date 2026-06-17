<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Article;

class DashboardController extends Controller
{
    public function index()
    {
        $todayRevenue = Order::whereIn('status', ['paid', 'shipped', 'completed'])->whereDate('created_at', today())->sum('total_price');
        $yesterdayRevenue = Order::whereIn('status', ['paid', 'shipped', 'completed'])->whereDate('created_at', today()->subDay())->sum('total_price');
        $revenueTrend = $yesterdayRevenue > 0 ? (($todayRevenue - $yesterdayRevenue) / $yesterdayRevenue) * 100 : ($todayRevenue > 0 ? 100 : 0);

        $todayOrders = Order::whereDate('created_at', today())->count();
        $yesterdayOrders = Order::whereDate('created_at', today()->subDay())->count();
        $ordersTrend = $todayOrders - $yesterdayOrders;
        
        $todayUsers = User::whereDate('created_at', today())->count();

        $stats = [
            'total_products'  => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'total_users'     => User::where('role', 'user')->count(),
            'users_trend'     => $todayUsers,
            'total_orders'    => Order::count(),
            'today_orders'    => $todayOrders,
            'orders_trend'    => $ordersTrend,
            'total_revenue'   => Order::whereIn('status', ['paid', 'shipped', 'completed'])->sum('total_price'),
            'revenue_trend'   => $revenueTrend,
        ];

        $recentOrders = Order::with('user')->latest()->take(5)->get();
        $lowStockProducts = Product::where('stock', '<=', 5)->where('is_active', true)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'lowStockProducts'));
    }
}
