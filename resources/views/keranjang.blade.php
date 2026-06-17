@extends('layouts.app')

@section('title', 'Keranjang Belanja - RetroRack')

@section('content')
<div class="page-bg-gray">
    <div class="container">
        <span class="dash"></span>
        <h1 class="cart-title serif">Keranjang Belanja</h1>
        <p class="cart-subtitle"><strong>{{ $items->count() }}</strong> item dalam keranjang</p>

        <div class="cart-layout">
            <div class="cart-left">
                <div class="cart-list">
                    @forelse($items as $item)
                    <div class="cart-card">
                        @if($item->product->image)
                            <img src="{{ $item->product->imageUrl() }}" alt="{{ $item->product->name }}" class="cart-card-img" style="object-fit: cover;">
                        @else
                            <div class="cart-card-img"></div>
                        @endif
                        <div class="cart-card-body">
                            <div class="cart-card-top">
                                <div>
                                    <h3 class="cart-card-title">{{ $item->product->name }}</h3>
                                    <div style="font-size: 13px; color: var(--color-text-light); margin-top: 8px; display: flex; align-items: center; gap: 8px;">
                                        {{ $item->product->year }} &bull; <span class="badge-condition bg-dark">{{ $item->product->conditionLabel() }}</span>
                                    </div>
                                </div>
                                <form method="POST" action="{{ route('cart.remove', $item) }}" 
                                      @submit.prevent="fetch($event.target.action, { method: 'POST', body: new FormData($event.target), headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } }).then(r => r.json()).then(d => { if(d.success) { window.dispatchEvent(new CustomEvent('cart-updated', { detail: d.cart_count })); showToast('Item dihapus'); $el.closest('.cart-card').remove(); document.getElementById('subtotal-val').innerText = 'Rp ' + d.subtotal; document.getElementById('total-val').innerText = 'Rp ' + d.total; } })">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="background: none; border: none; cursor: pointer;">
                                        <svg class="cart-card-remove" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                    </button>
                                </form>
                            </div>
                            <div class="cart-card-price-row">
                                <div class="cart-card-price">Rp {{ number_format($item->product->price, 0, ',', '.') }}</div>
                                <form method="POST" action="{{ route('cart.update', $item) }}" style="display: flex;" x-data="{ qty: {{ $item->quantity }}, stock: {{ $item->product->stock }} }">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="quantity" :value="qty">
                                    <div class="qty-control">
                                        <button type="button" @click="if(qty > 1) { qty--; fetch($el.closest('form').action, { method: 'POST', body: new FormData($el.closest('form')), headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } }).then(r=>r.json()).then(d => { if(d.success) { document.getElementById('subtotal-val').innerText = 'Rp ' + d.subtotal; document.getElementById('total-val').innerText = 'Rp ' + d.total; } }) }" class="qty-btn">&minus;</button>
                                        <input type="text" class="qty-input" x-model="qty" readonly>
                                        <button type="button" @click="if(qty < stock) { qty++; fetch($el.closest('form').action, { method: 'POST', body: new FormData($el.closest('form')), headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } }).then(r=>r.json()).then(d => { if(d.success) { document.getElementById('subtotal-val').innerText = 'Rp ' + d.subtotal; document.getElementById('total-val').innerText = 'Rp ' + d.total; } }) }" class="qty-btn">&plus;</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div style="text-align: center; padding: 64px 0; color: var(--color-text-light);">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin: 0 auto 16px;"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                        <h3 style="font-size: 20px; font-weight: 600; color: var(--color-dark); margin-bottom: 8px;">Keranjang Masih Kosong</h3>
                        <p style="margin-bottom: 24px;">Temukan perangkat vintage favoritmu di katalog kami.</p>
                        <a href="{{ route('katalog') }}" class="btn btn-dark" style="display: inline-block;">Mulai Belanja</a>
                    </div>
                    @endforelse
                </div>

                <a href="{{ route('katalog') }}" class="btn btn-outline" style="padding: 12px 24px; font-weight: 600;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                    Lanjut Belanja
                </a>
            </div>

            <div class="cart-right">
                <div class="summary-box">
                    <h3 class="summary-title">Ringkasan Pesanan</h3>
                    
                    <div class="summary-row">
                        <span>Subtotal ({{ $items->count() }} item)</span>
                        <span class="summary-val" id="subtotal-val">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Ongkir (estimasi)</span>
                        <span class="summary-val">Rp {{ number_format($shipping, 0, ',', '.') }}</span>
                    </div>

                    <div class="summary-total">
                        <span>Total</span>
                        <span class="val" id="total-val">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    
                    <a href="{{ route('checkout') }}" class="btn btn-dark btn-block" style="padding: 16px;">Lanjut ke Pembayaran</a>
                    
                    <div class="summary-benefits">
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
