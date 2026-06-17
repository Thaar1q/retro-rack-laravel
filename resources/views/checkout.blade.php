@extends('layouts.app')

@section('title', 'Pembayaran - RetroRack')

@section('content')
<div class="page-bg-gray">
    <div class="container">
        <span class="dash"></span>
        <h1 class="cart-title serif" style="margin-bottom: 24px;">Pembayaran</h1>

        <div class="checkout-steps">
            <div class="step-item">
                <span class="step-num">1</span>
                <span>Keranjang</span>
            </div>
            <div class="step-line"></div>
            <div class="step-item active">
                <span class="step-num">2</span>
                <span>Pembayaran</span>
            </div>
            <div class="step-line"></div>
            <div class="step-item">
                <span class="step-num">3</span>
                <span>Konfirmasi</span>
            </div>
        </div>

        <div class="cart-layout">
                <form method="POST" action="{{ route('checkout.store') }}">
                @csrf

                @if($errors->any())
                <div style="background: #fee2e2; border: 1px solid #fca5a5; border-radius: 8px; padding: 16px; margin-bottom: 24px;">
                    <ul style="margin: 0; padding-left: 20px; color: #b91c1c; font-size: 14px;">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
                @endif

                {{-- Informasi Kontak --}}
                <div class="checkout-section">
                    <h2 class="checkout-section-title">Informasi Kontak</h2>
                    <div class="form-group">
                        <label class="form-label">Nama Penerima</label>
                        <input type="text" name="recipient_name" class="form-input" placeholder="Masukkan nama lengkap" value="{{ old('recipient_name', auth()->user()->name) }}" minlength="3" maxlength="100" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="tel" name="recipient_phone" class="form-input" placeholder="08xx xxxx xxxx" value="{{ old('recipient_phone') }}" pattern="[0-9]{9,15}" title="Nomor telepon harus berupa angka 9-15 digit" required>
                    </div>
                </div>

                {{-- Alamat Pengiriman --}}
                <div class="checkout-section">
                    <h2 class="checkout-section-title">Alamat Pengiriman</h2>
                    <div class="form-group">
                        <label class="form-label">Alamat Lengkap</label>
                        <input type="text" name="shipping_address" class="form-input" placeholder="Jl. Nama Jalan No. XX, RT/RW" value="{{ old('shipping_address') }}" minlength="10" maxlength="255" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Kota</label>
                            <input type="text" name="shipping_city" class="form-input" placeholder="Jakarta" value="{{ old('shipping_city') }}" minlength="3" maxlength="100" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kode Pos</label>
                            <input type="text" name="postal_code" class="form-input" placeholder="12345" value="{{ old('postal_code') }}" pattern="[0-9]{5}" title="Kode pos harus berupa 5 digit angka" maxlength="5" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Catatan <span style="font-weight:400; color:var(--color-text-light);">(opsional)</span></label>
                        <input type="text" name="notes" class="form-input" placeholder="Instruksi pengiriman, patokan, dll." value="{{ old('notes') }}" maxlength="255">
                    </div>
                </div>

                {{-- Metode Pembayaran --}}
                <div class="checkout-section">
                    <h2 class="checkout-section-title">Metode Pembayaran</h2>
                    <label class="radio-card">
                        <div class="radio-content">
                            <input type="radio" name="payment" value="transfer" checked>
                            <div class="radio-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg></div>
                            <div class="radio-text">
                                <span class="radio-title">Transfer Bank</span>
                                <span class="radio-desc">BCA, Mandiri, BNI</span>
                            </div>
                        </div>
                        <span class="badge-popular">POPULER</span>
                    </label>
                    <label class="radio-card">
                        <div class="radio-content">
                            <input type="radio" name="payment" value="qris">
                            <div class="radio-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><rect x="7" y="7" width="3" height="3"></rect><rect x="14" y="7" width="3" height="3"></rect><rect x="7" y="14" width="3" height="3"></rect><rect x="14" y="14" width="3" height="3"></rect></svg></div>
                            <div class="radio-text">
                                <span class="radio-title">QRIS</span>
                                <span class="radio-desc">Scan QR dari aplikasi manapun</span>
                            </div>
                        </div>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-block" style="padding: 18px; font-size: 16px;">Konfirmasi Pesanan &rarr;</button>
                </form>

            <div class="checkout-right">
                <div class="summary-box">
                    <h3 class="summary-title">Ringkasan Pesanan</h3>
                    
                    <div class="summary-mini-list">
                        @foreach($items as $item)
                        <div class="summary-mini-item">
                            @if($item->product->image)
                                <img src="{{ $item->product->imageUrl() }}" alt="{{ $item->product->name }}" class="mini-img">
                            @else
                                <div class="mini-img"></div>
                            @endif
                            <div class="mini-info">
                                <span class="mini-title">{{ $item->product->name }}</span>
                                <div class="mini-meta">{{ $item->product->year }} &bull; <span class="badge-condition bg-dark" style="padding:2px 4px; font-size:8px;">{{ $item->product->conditionLabel() }}</span></div>
                            </div>
                            <div class="mini-price">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</div>
                        </div>
                        @endforeach
                    </div>

                    <div class="summary-row" style="border-top: 1px solid var(--color-border); padding-top: 16px;">
                        <span>Subtotal ({{ $items->count() }} item)</span>
                        <span class="summary-val">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Ongkir (estimasi)</span>
                        <span class="summary-val">Rp {{ number_format($shipping, 0, ',', '.') }}</span>
                    </div>

                    <div class="summary-total">
                        <span>Total</span>
                        <span class="val">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="summary-benefits" style="margin-top: 0; margin-bottom: 24px;">
                        <div class="summary-benefit-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            Pembayaran aman & terpercaya
                        </div>
                        <div class="summary-benefit-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            Garansi keaslian produk
                        </div>
                        <div class="summary-benefit-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            Pengembalian mudah
                        </div>
                    </div>

                    <div style="text-align: center;">
                        <a href="{{ route('keranjang') }}" style="font-size: 13px; color: var(--color-text-light); font-weight: 600;">&larr; Kembali ke Keranjang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
