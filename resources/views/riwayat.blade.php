@extends('layouts.app')

@section('title', 'Riwayat Pesanan - RetroRack')

@section('content')
<div class="page-bg-gray">
    <div class="container" style="max-width: 1000px;">
        <span class="dash"></span>
        <h1 class="cart-title serif">Riwayat Pesanan</h1>
        <p class="cart-subtitle" style="margin-bottom: 32px;">Lacak dan tinjau kembali koleksi retro yang telah Anda pesan.</p>

        {{-- Status Filter Tabs --}}
        <div class="history-controls">
            <div class="history-tabs">
                <a href="{{ route('riwayat') }}"
                   class="tab-item {{ !$status ? 'active' : '' }}">
                    Semua
                </a>
                <a href="{{ route('riwayat', ['status' => 'berlangsung']) }}"
                   class="tab-item {{ $status === 'berlangsung' ? 'active' : '' }}">
                    Berlangsung
                </a>
                <a href="{{ route('riwayat', ['status' => 'selesai']) }}"
                   class="tab-item {{ $status === 'selesai' ? 'active' : '' }}">
                    Selesai
                </a>
                <a href="{{ route('riwayat', ['status' => 'dibatalkan']) }}"
                   class="tab-item {{ $status === 'dibatalkan' ? 'active' : '' }}">
                    Dibatalkan
                </a>
            </div>
        </div>

        <div class="history-list">
            @forelse($orders as $order)
            @php
                $firstDetail = $order->details->first();
                $firstProduct = $firstDetail?->product;
                $extraCount   = $order->details->count() - 1;

                $statusMap = [
                    'pending'    => ['label' => 'MENUNGGU',   'class' => 'bg-warning'],
                    'processing' => ['label' => 'DIPROSES',   'class' => 'bg-warning'],
                    'shipped'    => ['label' => 'DIKIRIM',    'class' => 'bg-warning'],
                    'completed'  => ['label' => 'SELESAI',    'class' => 'status-success'],
                    'cancelled'  => ['label' => 'DIBATALKAN', 'class' => 'status-cancelled'],
                ];
                $statusInfo = $statusMap[$order->status] ?? ['label' => strtoupper($order->status), 'class' => 'bg-dark'];
                $isActive   = in_array($order->status, ['pending', 'processing', 'shipped']);
            @endphp
            <div class="history-card">
                {{-- Product image --}}
                <div class="history-card-img {{ $extraCount > 0 ? 'multi-img' : '' }}">
                    @if($extraCount > 0)
                        @if($firstProduct?->image)
                            <img src="{{ $firstProduct->imageUrl() }}" alt="" class="img-stack-1" style="object-fit: cover;">
                        @else
                            <div class="img-stack-1"></div>
                        @endif
                        <div class="img-stack-2"></div>
                        <div class="img-stack-count">+{{ $extraCount }}</div>
                    @elseif($firstProduct?->image)
                        <img src="{{ $firstProduct->imageUrl() }}" alt="{{ $firstProduct->name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 12px;">
                    @endif
                </div>

                <div class="history-card-body">
                    <div class="history-card-info">
                        <div class="order-id">ORDER {{ $order->invoice_number }}</div>
                        <h3 class="history-item-title">
                            {{ $firstDetail ? $firstDetail->product_name : 'Pesanan' }}
                            @if($extraCount > 0)
                                <span style="font-size: 14px; font-weight: 400; color: var(--color-text-light);">+{{ $extraCount }} item</span>
                            @endif
                        </h3>
                        <div class="history-meta">Dipesan {{ $order->created_at->translatedFormat('d M Y') }}</div>
                        <div class="history-price">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                    </div>

                    <div class="history-card-status">
                        <span class="status-badge {{ $statusInfo['class'] }}">{{ $statusInfo['label'] }}</span>
                    </div>

                    <div class="history-card-actions">
                        <a href="{{ $isActive ? route('order.track', $order) : route('order.detail', $order) }}" class="btn {{ $isActive ? 'btn-dark' : 'btn-outline' }}" style="padding: 10px 20px; font-size: 13px; margin-bottom: 8px; width: 100%;">
                            {{ $isActive ? 'Lacak Pesanan' : 'Lihat Detail' }}
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state" style="padding: 80px 40px;">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--color-text-light); margin-bottom: 16px;"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>
                <h3 style="font-family: var(--font-serif); font-size: 24px; color: var(--color-dark); margin-bottom: 8px;">Belum Ada Pesanan</h3>
                <p style="color: var(--color-text); margin-bottom: 24px; max-width: 400px;">
                    @if($status)
                        Tidak ada pesanan dengan status "{{ $status }}".
                    @else
                        Anda belum melakukan pemesanan apa pun.
                    @endif
                </p>
                <a href="{{ route('katalog') }}" class="btn btn-dark" style="padding: 12px 24px;">Mulai Belanja</a>
            </div>
            @endforelse
        </div>

        @if($orders->hasPages())
        <div class="pagination" style="margin-top: 48px; justify-content: center;">
            {{ $orders->links() }}
        </div>
        @endif

        <div class="cta-banner" style="margin-top: 80px;">
            <div class="cta-content">
                <span class="dash" style="margin: 0 auto 16px auto;"></span>
                <h2 class="serif" style="font-size: 40px; margin-bottom: 24px; color: var(--color-dark);">Punya Koleksi Retro?</h2>
                <p style="font-size: 15px; color: var(--color-text); max-width: 600px; margin: 0 auto 32px auto; line-height: 1.6;">
                    Bergabung sebagai penjual dan bagikan koleksi vintage Anda dengan komunitas pecinta retro di seluruh dunia.
                </p>
                <a href="#" class="btn btn-primary" style="padding: 14px 32px;">Daftar Sebagai Penjual &rarr;</a>
            </div>
        </div>
    </div>
</div>
@endsection
