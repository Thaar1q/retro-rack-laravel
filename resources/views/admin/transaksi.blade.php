@extends('layouts.admin')

@section('title', 'Kelola Transaksi - Admin RetroRack')

@section('content')
<div class="admin-header-row" style="margin-bottom: 32px;">
    <div>
        <span class="dash"></span>
        <h1 class="admin-page-title serif">Kelola Transaksi</h1>
        <p class="admin-page-subtitle">Manage and monitor all customer transactions.</p>
    </div>
</div>

<div class="admin-stats-grid" style="grid-template-columns: repeat(3, 1fr);">
    <div class="admin-stat-card">
        <div class="stat-card-header">
            <div class="stat-label" style="text-transform: uppercase; letter-spacing: 1px;">TOTAL TRANSAKSI</div>
            <div class="stat-icon" style="background-color: var(--color-bg); border-radius: 50%; color: var(--color-primary); width: 32px; height: 32px;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></div>
        </div>
            <div class="stat-value">{{ \App\Models\Order::count() }}</div>
    </div>
    <div class="admin-stat-card">
        <div class="stat-card-header">
            <div class="stat-label" style="text-transform: uppercase; letter-spacing: 1px;">PESANAN DIPROSES</div>
            <div class="stat-icon" style="background-color: var(--color-bg); border-radius: 50%; color: var(--color-primary); width: 32px; height: 32px;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></div>
        </div>
            <div class="stat-value">{{ \App\Models\Order::whereIn('status', ['pending', 'processing'])->count() }}</div>
    </div>
    <div class="admin-stat-card">
        <div class="stat-card-header">
            <div class="stat-label" style="text-transform: uppercase; letter-spacing: 1px;">TOTAL PENDAPATAN</div>
            <div class="stat-icon" style="background-color: #fef3c7; border-radius: 8px; color: var(--color-primary); width: 32px; height: 32px;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg></div>
        </div>
            <div class="stat-value">Rp {{ number_format(\App\Models\Order::whereIn('status', ['paid', 'shipped', 'completed'])->sum('total_price'), 0, ',', '.') }}</div>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <form method="GET" action="{{ route('admin.transaksi') }}" class="admin-table-controls" style="width: 100%; margin-bottom: 0;">
            <div class="admin-search-wrapper">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <input type="text" name="search" placeholder="Cari ID order, pelanggan..." value="{{ request('search') }}">
                @if(request()->hasAny(['search', 'status']))
                    <a href="{{ route('admin.transaksi') }}" style="color: var(--color-text-light); margin-left: 8px;" title="Reset Filter">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </a>
                @endif
            </div>
            <div style="display: flex; gap: 12px;">
                <select name="status" class="form-input" style="width: 140px; height: 44px;" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Diproses</option>
                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Batal</option>
                </select>
                <div class="admin-search-wrapper" style="width: 160px; justify-content: space-between;">
                    <input type="text" placeholder="Rentang Tanggal" style="font-size: 13px;" readonly>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </div>
                <button type="submit" style="display: none;"></button>
            </div>
        </form>
    </div>
    
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID ORDER</th>
                <th>PELANGGAN</th>
                <th>TANGGAL</th>
                <th>STATUS</th>
                <th>TOTAL</th>
                <th style="text-align: right;">AKSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
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
                <td style="font-family: monospace; font-weight: 600;">{{ $order->invoice_number }}</td>
                <td>
                    <div style="display: flex; align-items: center;">
                        <div class="customer-avatar">{{ strtoupper(substr($order->user->name, 0, 1)) }}</div>
                        {{ $order->user->name }}
                    </div>
                </td>
                <td style="color: var(--color-text-light);">{{ $order->created_at->format('d M Y') }}</td>
                <td><span class="badge-status {{ $badge['class'] }}">{{ $badge['label'] }}</span></td>
                <td style="font-weight: 600;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                <td>
                    <div class="table-actions" style="justify-content: flex-end;">
                        <button class="btn-table-action" title="Detail"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 48px; color: var(--color-text-light);">Tidak ada data transaksi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div style="padding: 24px; border-top: 1px solid var(--color-border);">
        {{ $orders->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
