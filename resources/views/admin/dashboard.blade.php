@extends('layouts.admin')

@section('title', 'Dashboard Admin - RetroRack')

@section('content')
<div class="admin-header-row">
    <div>
        <span class="dash"></span>
        <h1 class="admin-page-title serif">Dashboard Admin</h1>
        <p class="admin-page-subtitle">Ringkasan aktivitas harian RetroRack</p>
    </div>
</div>

<div class="admin-stats-grid">
    <div class="admin-stat-card">
        <div class="stat-card-header">
            <div class="stat-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg></div>
            <div class="stat-trend {{ $stats['revenue_trend'] >= 0 ? 'up' : 'down' }}">{!! $stats['revenue_trend'] >= 0 ? '&uarr;' : '&darr;' !!} {{ $stats['revenue_trend'] > 0 ? '+' : '' }}{{ number_format($stats['revenue_trend'], 1) }}%</div>
        </div>
        <div class="stat-value">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
        <div class="stat-label">Total Penjualan</div>
    </div>
    <div class="admin-stat-card">
        <div class="stat-card-header">
            <div class="stat-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg></div>
        </div>
        <div class="stat-value">{{ $stats['active_products'] }}</div>
        <div class="stat-label">Produk Aktif</div>
    </div>
    <div class="admin-stat-card">
        <div class="stat-card-header">
            <div class="stat-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg></div>
            <div class="stat-trend {{ $stats['orders_trend'] >= 0 ? 'up' : 'down' }}">{!! $stats['orders_trend'] >= 0 ? '&uarr;' : '&darr;' !!} {{ $stats['orders_trend'] > 0 ? '+' : '' }}{{ $stats['orders_trend'] }}</div>
        </div>
        <div class="stat-value">{{ $stats['today_orders'] }}</div>
        <div class="stat-label">Pesanan Hari Ini</div>
    </div>
    <div class="admin-stat-card">
        <div class="stat-card-header">
            <div class="stat-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg></div>
            <div class="stat-trend {{ $stats['users_trend'] >= 0 ? 'up' : 'down' }}">{!! $stats['users_trend'] >= 0 ? '&uarr;' : '&darr;' !!} {{ $stats['users_trend'] > 0 ? '+' : '' }}{{ $stats['users_trend'] }}</div>
        </div>
        <div class="stat-value">{{ $stats['total_users'] }}</div>
        <div class="stat-label">Total Pelanggan</div>
    </div>
</div>

<div class="admin-action-grid">
    <a href="{{ route('admin.produk.create') }}" class="admin-action-card">
        <div class="action-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
        </div>
        <div class="action-title">Tambah Produk</div>
    </a>
    <a href="{{ route('admin.artikel.create') }}" class="admin-action-card">
        <div class="action-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
        </div>
        <div class="action-title">Tulis Artikel</div>
    </a>
    <a href="{{ route('admin.transaksi') }}" class="admin-action-card">
        <div class="action-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
        </div>
        <div class="action-title">Kelola Pesanan</div>
    </a>
    <a href="{{ route('admin.pengguna') }}" class="admin-action-card">
        <div class="action-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
        </div>
        <div class="action-title">Kelola Pengguna</div>
    </a>
</div>

@if($lowStockProducts->count() > 0)
<div class="admin-card" style="border-left: 4px solid #dc2626; margin-bottom: 32px;">
    <div class="admin-card-header" style="border-bottom: none; padding-bottom: 0;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
            <h2 class="admin-card-title" style="color: #dc2626;">Peringatan Stok Menipis</h2>
        </div>
        <a href="{{ route('admin.produk') }}" style="font-size: 11px; font-weight: 700; color: var(--color-primary); text-transform: uppercase; letter-spacing: 1px;">KELOLA STOK &rarr;</a>
    </div>
    <div style="padding: 24px;">
        <ul style="list-style: none; padding: 0; margin: 0; display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 16px;">
            @foreach($lowStockProducts as $product)
            <li style="background-color: #fee2e2; border-radius: 8px; padding: 16px; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <div style="font-weight: 600; color: #991b1b; margin-bottom: 4px;">{{ $product->name }}</div>
                    <div style="font-size: 12px; color: #b91c1c; font-family: monospace;">SKU: {{ $product->id }}</div>
                </div>
                <div style="font-size: 18px; font-weight: 700; color: #dc2626;">{{ $product->stock }} sisa</div>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h2 class="admin-card-title">Pesanan Terbaru</h2>
            <div style="font-size: 13px; color: var(--color-text-light); margin-top: 4px;">Aktivitas pesanan terakhir</div>
        </div>
        <a href="{{ route('admin.transaksi') }}" style="font-size: 11px; font-weight: 700; color: var(--color-primary); text-transform: uppercase; letter-spacing: 1px;">LIHAT SEMUA &rarr;</a>
    </div>
    
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID ORDER</th>
                <th>PELANGGAN</th>
                <th>TANGGAL</th>
                <th>TOTAL</th>
                <th>STATUS</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentOrders as $order)
            @php
                $statusMap = [
                    'pending'    => ['label' => 'MENUNGGU',   'class' => 'bg-warning'],
                    'processing' => ['label' => 'DIPROSES',   'class' => 'bg-warning'],
                    'shipped'    => ['label' => 'DIKIRIM',    'class' => 'status-success'],
                    'completed'  => ['label' => 'SELESAI',    'class' => 'status-success'],
                    'cancelled'  => ['label' => 'BATAL',      'class' => 'status-cancelled'],
                ];
                $badge = $statusMap[$order->status] ?? ['label' => strtoupper($order->status), 'class' => 'bg-dark'];
            @endphp
            <tr onclick="window.location='{{ route('admin.transaksi.detail', $order) }}'">
                <td style="font-family: monospace;">{{ $order->invoice_number }}</td>
                <td>
                    <div style="display: flex; align-items: center;">
                        <div class="customer-avatar">{{ strtoupper(substr($order->user->name, 0, 1)) }}</div>
                        {{ $order->user->name }}
                    </div>
                </td>
                <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                <td style="font-weight: 600;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                <td><span class="badge-status {{ $badge['class'] }}">{{ $badge['label'] }}</span></td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 48px; color: var(--color-text-light);">Belum ada pesanan masuk.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
