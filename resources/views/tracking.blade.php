@extends('layouts.app')

@section('title', 'Lacak Pesanan - RetroRack')

@section('content')
<div class="page-bg-gray">
    <div class="container">
        <span class="dash"></span>
        <h1 class="cart-title serif" style="margin-bottom: 24px;">Lacak Pesanan</h1>

        <div class="cart-layout">
            <div class="checkout-left">
                <div class="info-box">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; border-bottom: 1px solid var(--color-border); padding-bottom: 24px;">
                        <div>
                            <div style="font-size: 11px; font-weight: 700; color: var(--color-text-light); text-transform: uppercase; margin-bottom: 4px;">NOMOR INVOICE</div>
                            <div style="font-weight: 700; font-size: 18px; color: var(--color-dark);">{{ $order->invoice_number }}</div>
                        </div>
                        <div style="text-align: right;">
                            <div style="font-size: 11px; font-weight: 700; color: var(--color-text-light); text-transform: uppercase; margin-bottom: 4px;">STATUS PESANAN</div>
                            <div style="font-weight: 700; color: var(--color-primary);"><span class="badge-status" style="background: var(--color-dark); color: white;">{{ strtoupper($order->statusLabel()) }}</span></div>
                        </div>
                    </div>

                    <div style="position: relative; margin-top: 32px; padding-left: 16px;">
                        <!-- Timeline Line -->
                        <div style="position: absolute; left: 24px; top: 12px; bottom: 12px; width: 2px; background-color: var(--color-border);"></div>
                        
                        @php
                            $statuses = [
                                'pending'   => ['Menunggu Pembayaran', 'Segera lakukan pembayaran.'],
                                'paid'      => ['Pembayaran Dikonfirmasi', 'Pesanan sedang disiapkan.'],
                                'shipped'   => ['Dalam Pengiriman', 'Pesanan sedang dalam perjalanan.'],
                                'completed' => ['Pesanan Selesai', 'Pesanan telah diterima.']
                            ];
                            $statusKeys = array_keys($statuses);
                            $currentIndex = array_search($order->status, $statusKeys);
                            if ($order->status === 'cancelled') {
                                $currentIndex = -1; // special case
                            }
                        @endphp

                        @if($order->status === 'cancelled')
                        <div style="position: relative; margin-bottom: 32px; display: flex; gap: 16px;">
                            <div style="width: 18px; height: 18px; border-radius: 50%; background-color: #ef4444; z-index: 1; border: 4px solid var(--color-white); margin-left: -1px; margin-top: 2px;"></div>
                            <div>
                                <div style="font-weight: 700; font-size: 15px; color: var(--color-dark); margin-bottom: 4px;">Pesanan Dibatalkan</div>
                                <div style="font-size: 13px; color: var(--color-text-light);">Pesanan dibatalkan.</div>
                            </div>
                        </div>
                        @else
                            @foreach($statuses as $key => $info)
                            @php
                                $isCompleted = $currentIndex >= array_search($key, $statusKeys);
                                $isActive = $currentIndex === array_search($key, $statusKeys);
                                $color = $isCompleted ? 'var(--color-primary)' : 'var(--color-border)';
                                if ($isActive) $color = 'var(--color-dark)';
                            @endphp
                            <div style="position: relative; margin-bottom: 32px; display: flex; gap: 16px; opacity: {{ $isCompleted ? '1' : '0.5' }};">
                                <div style="width: 18px; height: 18px; border-radius: 50%; background-color: {{ $color }}; z-index: 1; border: 4px solid var(--color-white); margin-left: -1px; margin-top: 2px;"></div>
                                <div>
                                    <div style="font-weight: 700; font-size: 15px; color: {{ $isActive ? 'var(--color-dark)' : 'inherit' }}; margin-bottom: 4px;">{{ $info[0] }}</div>
                                    <div style="font-size: 13px; color: var(--color-text-light);">{{ $isCompleted ? $info[1] : 'Menunggu update selanjutnya.' }}</div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <div class="checkout-right">
                <div class="summary-box">
                    <h3 class="summary-title" style="margin-bottom: 24px;">Detail Pengiriman</h3>

                    <div class="info-row">
                        <div class="info-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        </div>
                        <div class="info-content">
                            <span class="info-label">KURIR PENGIRIMAN</span>
                            <span class="info-val">{{ $order->shipping_method }}</span>
                            @if($order->status == 'shipped' || $order->status == 'completed')
                            <span class="info-sub" style="color: var(--color-primary); font-weight: 600; margin-top: 4px;">Resi: RR-{{ rand(1000000, 9999999) }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="info-row" style="margin-top: 24px;">
                        <div class="info-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        </div>
                        <div class="info-content">
                            <span class="info-label">ALAMAT TUJUAN</span>
                            <span class="info-val">{{ $order->recipient_name }}</span>
                            <span class="info-sub">{{ $order->shipping_address }},<br>{{ $order->shipping_city }}, {{ $order->postal_code }}</span>
                        </div>
                    </div>

                    <a href="{{ route('riwayat') }}" class="btn btn-outline btn-block" style="margin-top: 32px; padding: 14px;">Kembali ke Riwayat</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
