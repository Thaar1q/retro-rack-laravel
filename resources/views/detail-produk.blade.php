@extends('layouts.app')

@section('title', $product->name . ' - RetroRack')

@section('content')
<div class="product-detail-page">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">HOME</a>
            <span class="sep">&gt;</span>
            <a href="{{ route('katalog') }}">KATALOG</a>
            <span class="sep">&gt;</span>
            <a href="{{ route('katalog', ['category' => $product->category->slug]) }}" class="breadcrumb-category">{{ strtoupper($product->category->name) }}</a>
            <span class="sep">&gt;</span>
            <span style="color: var(--color-dark);">{{ strtoupper($product->name) }}</span>
        </div>

        <div class="product-split">
            {{-- Gallery --}}
            <div class="product-gallery">
                <div class="main-image">
                    @if($product->image)
                        <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 16px;">
                    @endif
                </div>
            </div>

            {{-- Info Panel --}}
            <div class="product-info-panel">
                <div class="product-meta-row">
                    <span class="badge-condition bg-primary" style="padding: 6px 12px; border-radius: 4px;">{{ $product->conditionLabel() }}</span>
                    <span class="meta-year">Tahun: {{ $product->year }}</span>
                </div>

                <h1 class="product-detail-title serif">{{ $product->name }}</h1>
                <div class="product-sku">SKU: RR-{{ strtoupper(substr($product->category->name, 0, 3)) }}-{{ $product->year }}-{{ str_pad($product->id, 3, '0', STR_PAD_LEFT) }}</div>

                <div class="product-detail-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>

                {{-- Stock indicator --}}
                <div class="stock-indicator" style="margin-bottom: 24px;">
                    @if($product->stock > 5)
                        <span class="stock-badge stock-in">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            Tersedia ({{ $product->stock }} unit)
                        </span>
                    @elseif($product->stock > 0)
                        <span class="stock-badge stock-low">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                            Stok Terbatas ({{ $product->stock }} unit)
                        </span>
                    @else
                        <span class="stock-badge stock-out">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                            Stok Habis
                        </span>
                    @endif
                </div>

                <p class="product-short-desc">{{ $product->description }}</p>

                <div class="product-actions-large">
                    @if($product->stock > 0)
                        @auth
                        <form method="POST" action="{{ route('cart.add') }}" style="display: contents;"
                              x-data="{ loading: false, showQty: false, qty: 1, stock: {{ $product->stock }} }"
                              @submit.prevent="loading = true; fetch('{{ route('cart.add') }}', { method: 'POST', body: new FormData($el), headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } }).then(r => r.json()).then(data => { loading = false; if(data.success) { window.dispatchEvent(new CustomEvent('cart-updated', { detail: data.cart_count })); showToast(data.message); showQty = false; qty = 1; } else { showToast(data.message); } })">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" :value="qty">

                            <div class="qty-add-wrapper" style="flex: 1;">
                                {{-- Collapsed: single Add button --}}
                                <div x-show="!showQty" style="display: flex; gap: 12px;">
                                    <button type="button" @click="showQty = true" class="btn btn-dark" style="flex: 1; padding: 16px 24px;">
                                        Tambah ke Keranjang &rarr;
                                    </button>
                                </div>
                                {{-- Expanded: qty stepper + confirm --}}
                                <div x-show="showQty" style="display: none; align-items: center; gap: 12px;">
                                    <div class="qty-control">
                                        <button type="button" @click="if(qty > 1) qty--" class="qty-btn">&minus;</button>
                                        <input type="text" class="qty-input" x-model="qty" readonly>
                                        <button type="button" @click="if(qty < stock) qty++" class="qty-btn">&plus;</button>
                                    </div>
                                    <button type="submit" class="btn btn-dark" style="flex: 1;" :class="{ 'is-loading': loading }">
                                        <span x-show="!loading">Tambah (×<span x-text="qty"></span>) &rarr;</span>
                                        <span x-show="loading" style="display:none;">...</span>
                                    </button>
                                    <button type="button" @click="showQty = false; qty = 1" class="btn btn-outline" style="padding: 16px;">&times;</button>
                                </div>
                            </div>
                        </form>
                        @else
                        <a href="{{ route('login') }}" class="btn btn-dark" style="padding: 16px 32px; flex: 1;">Login untuk Beli &rarr;</a>
                        @endauth
                    @else
                        <button class="btn btn-outline" disabled style="flex: 1; opacity: 0.5; cursor: not-allowed;">Stok Habis</button>
                    @endif
                </div>

                <div class="product-benefits">
                    <div class="benefit-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--color-primary);"><circle cx="12" cy="12" r="10"></circle><path d="M9 12l2 2 4-4"></path></svg>
                        Garansi 3 Bulan
                    </div>
                    <div class="benefit-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--color-primary);"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        Gratis Ongkir
                    </div>
                    <div class="benefit-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--color-primary);"><polyline points="1 4 1 10 7 10"></polyline><polyline points="23 20 23 14 17 14"></polyline><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path></svg>
                        Retur 7 Hari
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabbed section: Deskripsi / Spesifikasi --}}
        <div class="product-tabs" x-data="{ tab: 'deskripsi' }">
            <div class="tabs-nav">
                <button class="tab-btn" :class="{ 'active': tab === 'deskripsi' }" @click="tab = 'deskripsi'">Deskripsi</button>
                <button class="tab-btn" :class="{ 'active': tab === 'spesifikasi' }" @click="tab = 'spesifikasi'">Spesifikasi</button>
                <button class="tab-btn" :class="{ 'active': tab === 'ulasan' }" @click="tab = 'ulasan'">Ulasan ({{ $product->reviews->count() }})</button>
            </div>

            <div class="tab-panel" x-show="tab === 'deskripsi'">
                <p>{{ $product->description }}</p>
            </div>

            <div class="tab-panel" x-show="tab === 'spesifikasi'" style="display: none;">
                <div class="specs-list">
                    <div class="spec-row">
                        <span class="spec-label">Kategori</span>
                        <span class="spec-value">{{ $product->category->name }}</span>
                    </div>
                    <div class="spec-row">
                        <span class="spec-label">Tahun Produksi</span>
                        <span class="spec-value">{{ $product->year }}</span>
                    </div>
                    <div class="spec-row">
                        <span class="spec-label">Kondisi</span>
                        <span class="spec-value">{{ $product->conditionLabel() }}</span>
                    </div>
                    <div class="spec-row">
                        <span class="spec-label">Stok Tersedia</span>
                        <span class="spec-value">{{ $product->stock }} unit</span>
                    </div>
                    <div class="spec-row">
                        <span class="spec-label">SKU</span>
                        <span class="spec-value" style="font-family: monospace;">RR-{{ strtoupper(substr($product->category->name, 0, 3)) }}-{{ $product->year }}-{{ str_pad($product->id, 3, '0', STR_PAD_LEFT) }}</span>
                    </div>
                </div>
            </div>

            <div class="tab-panel" x-show="tab === 'ulasan'" style="display: none;">
                <div class="reviews-section">
                    @auth
                        @php
                            $userHasReviewed = $product->reviews->where('user_id', auth()->id())->isNotEmpty();
                        @endphp
                        @if(!$userHasReviewed)
                        <div class="review-form-box" style="background-color: #fafafa; padding: 24px; border-radius: 8px; margin-bottom: 32px; border: 1px solid var(--color-border);">
                            <h3 style="font-family: var(--font-serif); font-size: 18px; margin-bottom: 16px;">Tulis Ulasan Anda</h3>
                            <form action="{{ route('reviews.store', $product) }}" method="POST">
                                @csrf
                                <div style="margin-bottom: 16px;">
                                    <label style="display:block; font-size: 12px; font-weight: 700; margin-bottom: 8px;">PENILAIAN</label>
                                    <select name="rating" class="form-input" required style="width: 100%; max-width: 200px;">
                                        <option value="5">★★★★★ Sangat Baik</option>
                                        <option value="4">★★★★☆ Baik</option>
                                        <option value="3">★★★☆☆ Cukup</option>
                                        <option value="2">★★☆☆☆ Kurang</option>
                                        <option value="1">★☆☆☆☆ Sangat Kurang</option>
                                    </select>
                                </div>
                                <div style="margin-bottom: 16px;">
                                    <label style="display:block; font-size: 12px; font-weight: 700; margin-bottom: 8px;">ULASAN (OPSIONAL)</label>
                                    <textarea name="comment" class="form-input" style="width: 100%; min-height: 80px;" placeholder="Bagaimana kondisi perangkat saat tiba?"></textarea>
                                </div>
                                <button type="submit" class="btn btn-dark">Kirim Ulasan</button>
                            </form>
                        </div>
                        @else
                        <div style="margin-bottom: 32px; padding: 16px; background-color: #f0fdf4; color: #166534; border-radius: 8px; font-size: 13px;">
                            Anda sudah memberikan ulasan untuk produk ini. Terima kasih!
                        </div>
                        @endif
                    @else
                        <div style="margin-bottom: 32px; padding: 16px; background-color: #fafafa; border: 1px solid var(--color-border); border-radius: 8px; text-align: center;">
                            <p style="margin-bottom: 12px; color: var(--color-text-light);">Silakan login untuk memberikan ulasan produk ini.</p>
                            <a href="{{ route('login') }}" class="btn btn-outline" style="display: inline-block;">Login ke Akun Anda</a>
                        </div>
                    @endauth

                    <div class="reviews-list">
                        @forelse($product->reviews as $review)
                        <div class="review-item" style="padding-bottom: 24px; margin-bottom: 24px; border-bottom: 1px solid var(--color-border);">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                <div style="font-weight: 700; color: var(--color-dark);">{{ $review->user->name }}</div>
                                <div style="color: var(--color-text-light); font-size: 12px;">{{ $review->created_at->diffForHumans() }}</div>
                            </div>
                            <div style="color: #fbbf24; margin-bottom: 12px; letter-spacing: 2px;">
                                {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                            </div>
                            @if($review->comment)
                            <p style="font-size: 14px; line-height: 1.6; color: var(--color-text);">{{ $review->comment }}</p>
                            @endif
                        </div>
                        @empty
                        <p style="color: var(--color-text-light); text-align: center; padding: 32px 0;">Belum ada ulasan. Jadilah yang pertama memberikan ulasan!</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Related Products --}}
@if($related->isNotEmpty())
<div class="related-section" style="background-color: var(--color-white); padding: 80px 0;">
    <div class="container">
        <div class="section-header" style="align-items: flex-end; margin-bottom: 48px;">
            <div>
                <span class="dash" style="margin-bottom: 12px;"></span>
                <h2 class="section-title serif">Produk Terkait</h2>
                <p class="section-subtitle">Mungkin Anda juga tertarik dengan koleksi ini</p>
            </div>
            <a href="{{ route('katalog', ['category' => $product->category->slug]) }}" class="link-all">Lihat Semua &rarr;</a>
        </div>

        <div class="products-grid-bottom">
            @foreach($related as $rel)
            <x-product-card :product="$rel" type="small" />
            @endforeach
        </div>
    </div>
</div>
@endif
@endsection
