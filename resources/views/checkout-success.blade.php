@extends('layouts.app')

@section('title', 'Pesanan Berhasil - RetroRack')

@section('content')
<div class="page-bg-gray">
    <div class="container">
        <div class="success-header">
            <div class="success-icon">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            </div>
            <h1 class="success-title">Pesanan Dikonfirmasi!</h1>
            @if($order)
            <div class="success-order-id">{{ $order->invoice_number }} &bull; {{ $order->created_at->translatedFormat('d F Y, H:i') }} WIB</div>
            @endif
            <p class="success-desc">Terima kasih! Pesananmu sedang kami proses dan akan segera dikirimkan.</p>
            <div class="success-email-notice">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                Konfirmasi juga dikirim ke email kamu
            </div>
        </div>

        <div class="cart-layout">
            <div class="checkout-left">
                <div class="info-box" style="margin-bottom: 24px;">
                    <h2 class="checkout-section-title">Rincian Pesanan</h2>

                    @if($order)
                    <div style="margin-bottom: 24px;">
                        @foreach($order->details as $index => $detail)
                        <div class="order-list-item">
                            <div class="order-list-left">
                                <span class="order-num">{{ $index + 1 }}</span>
                                <div class="order-details">
                                    <span style="font-weight: 600; color: var(--color-dark);">{{ $detail->product_name }}</span>
                                    <div style="font-size: 11px; color: var(--color-text-light);">
                                        Qty: {{ $detail->quantity }}
                                    </div>
                                </div>
                            </div>
                            <span style="font-weight: 700; color: var(--color-dark);">Rp {{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>

                    @php
                        $subtotal = $order->details->sum(fn($d) => $d->price * $d->quantity);
                        $shipping = $order->total_price - $subtotal;
                    @endphp
                    <div class="summary-row" style="border-top: 1px solid var(--color-border); padding-top: 24px;">
                        <span>Subtotal</span>
                        <span class="summary-val">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Ongkos Kirim</span>
                        <span class="summary-val">Rp {{ number_format($shipping, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-total" style="margin-bottom: 0;">
                        <span>Total</span>
                        <span class="val">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                    @else
                    <p style="color: var(--color-text-light); font-style: italic;">Detail pesanan tidak tersedia.</p>
                    @endif
                </div>

                <div class="info-box">
                    <h2 class="checkout-section-title">Metode &amp; Pengiriman</h2>
                    <div style="display: flex; flex-direction: column; gap: 16px;">
                        <div style="border: 1px solid var(--color-border); padding: 16px 20px; border-radius: 12px; display: flex; justify-content: space-between; align-items: center; background-color: var(--color-bg);">
                            <div style="display: flex; align-items: center; gap: 16px;">
                                <div style="width: 40px; height: 40px; background-color: #fef3c7; color: #d97706; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                </div>
                                <div style="display: flex; flex-direction: column;">
                                    <span style="font-size: 10px; font-weight: 700; color: var(--color-text-light); text-transform: uppercase;">Metode Pembayaran</span>
                                    <span style="font-weight: 600; color: var(--color-dark);">{{ $order ? $order->payment_method : 'Transfer Bank' }}</span>
                                </div>
                            </div>
                        </div>

                        <div style="border: 1px solid var(--color-border); padding: 16px 20px; border-radius: 12px; display: flex; justify-content: space-between; align-items: center; background-color: var(--color-bg);">
                            <div style="display: flex; align-items: center; gap: 16px;">
                                <div style="width: 40px; height: 40px; background-color: #fef3c7; color: #d97706; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                                </div>
                                <div style="display: flex; flex-direction: column;">
                                    <span style="font-size: 10px; font-weight: 700; color: var(--color-text-light); text-transform: uppercase;">Metode Pengiriman</span>
                                    <span style="font-weight: 600; color: var(--color-dark);">{{ $order ? $order->shipping_method : 'JNE Reguler' }} &mdash; estimasi 3-4 hari kerja</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="checkout-right">
                <div class="summary-box">
                    <h3 class="summary-title" style="margin-bottom: 32px;">Informasi Penerima</h3>

                    @if($order)
                    <div class="info-row">
                        <div class="info-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        </div>
                        <div class="info-content">
                            <span class="info-label">ALAMAT</span>
                            <span class="info-val">{{ $order->recipient_name }}</span>
                            <span class="info-sub">{{ $order->shipping_address }},<br>{{ $order->shipping_city }}, {{ $order->postal_code }}</span>
                        </div>
                    </div>

                    <div class="info-row" style="margin-bottom: 32px;">
                        <div class="info-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.18C2 2.09 2.47 2 3.08 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.29 6.29l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        </div>
                        <div class="info-content">
                            <span class="info-label">KONTAK</span>
                            <span class="info-sub">{{ $order->recipient_phone }}</span>
                        </div>
                    </div>
                    @endif

                    <a href="{{ route('riwayat') }}" class="btn btn-primary btn-block" style="margin-bottom: 12px; padding: 14px;">Lacak Pesanan &rarr;</a>
                    <a href="{{ route('home') }}" class="btn btn-outline btn-block" style="padding: 14px;">Lanjut Belanja</a>

                    <div style="text-align: center; margin-top: 24px; font-size: 12px; color: var(--color-text-light);">
                        Butuh bantuan? <a href="#" style="color: var(--color-primary); font-weight: 600;">Hubungi tim kami</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="trust-badges">
            <div class="trust-badge-item">
                <div class="trust-icon" style="width: 48px; height: 48px; background-color: #fef3c7; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><polyline points="9 12 11 14 15 10"></polyline></svg>
                </div>
                <div class="trust-title">Pembayaran Aman</div>
                <div class="trust-desc">Transaksi terenkripsi &amp; terlindungi</div>
            </div>
            <div class="trust-badge-item">
                <div class="trust-icon" style="width: 48px; height: 48px; background-color: #fef3c7; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                </div>
                <div class="trust-title">Kurir Terpercaya</div>
                <div class="trust-desc">Mitra kurir resmi &amp; berpengalaman</div>
            </div>
            <div class="trust-badge-item">
                <div class="trust-icon" style="width: 48px; height: 48px; background-color: #fef3c7; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                </div>
                <div class="trust-title">Garansi Keaslian</div>
                <div class="trust-desc">Setiap produk diverifikasi tim kami</div>
            </div>
        </div>
    </div>
</div>
@endsection
