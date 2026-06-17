@props(['product', 'type' => 'large'])

<div class="product-card {{ $type == 'small' ? 'small-card' : 'large-card' }}">
    @if($product->image)
        <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="product-img" style="object-fit: cover;">
    @else
        <div class="product-img"></div>
    @endif
    
    <div class="product-info">
        @if($type == 'large')
            <div class="product-top-row">
                <h3 class="product-name">{{ $product->name }}</h3>
                <span class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
            </div>
            <div class="product-meta">
                <span class="meta-year">{{ $product->year }}</span>
                <span class="badge-condition bg-dark">{{ $product->conditionLabel() }}</span>
                @if($product->stock > 5)
                    <span class="badge-condition" style="background-color: #d1fae5; color: #065f46;">Stok: {{ $product->stock }}</span>
                @elseif($product->stock > 0)
                    <span class="badge-condition" style="background-color: #fef3c7; color: #92400e;">Sisa: {{ $product->stock }}</span>
                @else
                    <span class="badge-condition" style="background-color: #fee2e2; color: #991b1b;">Habis</span>
                @endif
            </div>
            <div class="product-actions">
                <form action="{{ route('cart.add') }}" method="POST" style="flex:1; display:flex;"
                      x-data="{ loading: false, showQty: false, qty: 1, stock: {{ $product->stock }} }"
                      @submit.prevent="loading = true; fetch('{{ route('cart.add') }}', { method: 'POST', body: new FormData($el), headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } }).then(res => { if(res.status === 401) { window.location.href = '/login'; return null; } return res.json(); }).then(data => { if(!data) return; loading = false; if(data.success) { window.dispatchEvent(new CustomEvent('cart-updated', { detail: data.cart_count })); showToast(data.message); showQty = false; qty = 1; } else { showToast(data.message); } })">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" :value="qty">
                    <div class="qty-add-wrapper">
                        {{-- Collapsed: add button --}}
                        <button type="button" x-show="!showQty" @click="showQty = true" class="btn btn-dark" style="width:100%;">
                            Tambah ke Keranjang
                        </button>
                        {{-- Expanded: stepper + confirm --}}
                        <div x-show="showQty" :style="showQty ? 'display: flex;' : 'display: none;'" style="display: none; align-items: center; gap: 8px; width: 100%;">
                            <div class="qty-control">
                                <button type="button" @click="if(qty > 1) qty--" class="qty-btn">&minus;</button>
                                <input type="text" class="qty-input" x-model="qty" readonly style="width: 32px;">
                                <button type="button" @click="if(qty < stock) qty++" class="qty-btn">&plus;</button>
                            </div>
                            <button type="submit" class="btn btn-dark" style="flex:1;" :class="{'is-loading': loading}">
                                <span x-show="!loading">+ <span x-text="qty"></span></span>
                                <span x-show="loading" style="display:none;">...</span>
                            </button>
                            <button type="button" @click="showQty = false; qty = 1" class="btn btn-outline" style="padding: 12px;">&times;</button>
                        </div>
                    </div>
                </form>
                <a href="{{ route('detail.produk', $product->slug) }}" class="btn btn-outline" style="flex:1;">Lihat Detail</a>
            </div>
        @else
            {{-- Small Card Layout --}}
            <h3 class="product-name">{{ $product->name }}</h3>
            <div class="product-price-row">
                <span class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                <span class="badge-year">{{ $product->year }}</span>
            </div>
            <form action="{{ route('cart.add') }}" method="POST" style="margin-top:auto;"
                  x-data="{ loading: false, showQty: false, qty: 1, stock: {{ $product->stock }} }"
                  @submit.prevent="loading = true; fetch('{{ route('cart.add') }}', { method: 'POST', body: new FormData($el), headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } }).then(res => { if(res.status === 401) { window.location.href = '/login'; return null; } return res.json(); }).then(data => { if(!data) return; loading = false; if(data.success) { window.dispatchEvent(new CustomEvent('cart-updated', { detail: data.cart_count })); showToast(data.message); showQty = false; qty = 1; } else { showToast(data.message); } })">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" :value="qty">
                <div class="qty-add-wrapper">
                    <button type="button" x-show="!showQty" @click="showQty = true" class="btn btn-dark" style="width: 100%;">
                        Tambah
                    </button>
                    <div x-show="showQty" :style="showQty ? 'display: flex;' : 'display: none;'" style="display: none; align-items: center; gap: 4px; width: 100%;">
                        <div class="qty-control" style="width: 60px;">
                            <button type="button" @click="if(qty > 1) qty--" class="qty-btn" style="padding: 0 4px;">&minus;</button>
                            <input type="text" class="qty-input" x-model="qty" readonly style="width: 20px; padding: 0;">
                            <button type="button" @click="if(qty < stock) qty++" class="qty-btn" style="padding: 0 4px;">&plus;</button>
                        </div>
                        <button type="submit" class="btn btn-dark" style="flex:1; padding: 12px 4px;" :class="{'is-loading': loading}">
                            <span x-show="!loading">+ <span x-text="qty"></span></span>
                            <span x-show="loading" style="display:none;">...</span>
                        </button>
                        <button type="button" @click="showQty = false; qty = 1" class="btn btn-outline" style="padding: 12px 8px;">&times;</button>
                    </div>
                </div>
            </form>
        @endif
    </div>
</div>
