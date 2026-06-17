@extends('layouts.app')

@section('title', 'Katalog Produk - RetroRack')

@section('content')
    <div class="page-header page-header-compact">
        <div class="container">
            <h1 class="page-title serif">Katalog Produk</h1>
            <p class="page-desc">Jelajahi koleksi lengkap perangkat elektronik retro kami</p>
        </div>
    </div>

    <div class="container page-layout">
        <aside class="sidebar" id="catalog-sidebar">
            <form method="GET" action="{{ route('katalog') }}" id="filter-form">
            <div class="filter-group">
                <h3 class="filter-title">Index: Category</h3>
                <ul class="filter-list">
                    <li><a href="{{ route('katalog') }}" class="{{ !request('category') ? 'active' : '' }}"><span>Semua</span> <span class="count">{{ $products->total() }}</span></a></li>
                    @foreach($categories as $index => $cat)
                    <li><a href="{{ route('katalog', array_merge(request()->query(), ['category' => $cat->slug])) }}" class="{{ request('category') === $cat->slug ? 'active' : '' }}"><span>{{ $cat->name }}</span> <span class="count">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span></a></li>
                    @endforeach
                </ul>
            </div>

            <div class="filter-group">
                <h3 class="filter-title">Index: State</h3>
                <ul class="filter-list">
                    @foreach(['sangat_baik' => 'Sangat Baik', 'baik' => 'Baik', 'cukup' => 'Cukup'] as $val => $label)
                    <li>
                        <label>
                            <div><input type="checkbox" name="condition[]" value="{{ $val }}" class="filter-checkbox" {{ in_array($val, (array) request('condition')) ? 'checked' : '' }}> {{ $label }}</div>
                        </label>
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="filter-group">
                <h3 class="filter-title">Valuation Range</h3>
                <div class="val-inputs">
                    <input type="text" name="min_price" placeholder="MIN VAL." value="{{ request('min_price') }}">
                    <input type="text" name="max_price" placeholder="MAX VAL." value="{{ request('max_price') }}">
                    <button type="submit" class="val-btn">EXECUTE FILTER</button>
                </div>
            </div>
            </form>
        </aside>

        <main class="main-content" id="catalog-results">
            <div class="content-top-bar">
                <div class="manifest-info">Manifest: {{ $products->total() }} Objects Retrieved</div>
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="font-size: 12px; color: var(--color-text-light);">CATALOG ORDER:</span>
                    <form method="GET" action="{{ route('katalog') }}" id="sort-form">
                        @foreach(request()->except('sort') as $key => $val)
                            @if(is_array($val))
                                @foreach($val as $v)<input type="hidden" name="{{ $key }}[]" value="{{ $v }}">@endforeach
                            @else
                                <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                            @endif
                        @endforeach
                        <select class="sort-select" name="sort" onchange="document.getElementById('sort-form').submit()">
                            <option value="terbaru" {{ request('sort') === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                            <option value="harga_tertinggi" {{ request('sort') === 'harga_tertinggi' ? 'selected' : '' }}>Harga Tertinggi</option>
                            <option value="harga_terendah" {{ request('sort') === 'harga_terendah' ? 'selected' : '' }}>Harga Terendah</option>
                        </select>
                    </form>
                </div>
            </div>

            <div class="grid-2">
                @forelse($products as $product)
                <x-product-card :product="$product" type="large" />
                @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 64px 0; color: var(--color-text-light);">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin: 0 auto 16px;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <h3 style="font-size: 20px; font-weight: 600; color: var(--color-dark); margin-bottom: 8px;">Tidak Ada Produk Ditemukan</h3>
                    <p>Maaf, tidak ada produk yang cocok dengan filter pencarian Anda saat ini.</p>
                    <a href="{{ route('katalog') }}" class="btn btn-outline" style="margin-top: 16px; display: inline-block;">Reset Filter</a>
                </div>
                @endforelse
            </div>

            <div class="pagination">
                {{ $products->links() }}
            </div>
        </main>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const attachAjax = () => {
        // Intercept form submissions
        const form = document.getElementById('filter-form');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const url = new URL(form.action);
                const formData = new FormData(form);
                for (const [key, value] of formData.entries()) {
                    if (value) url.searchParams.append(key, value);
                }
                fetchCatalog(url.toString());
            });
        }

        // Intercept links (categories, pagination)
        document.querySelectorAll('#catalog-sidebar a, .pagination a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                fetchCatalog(this.href);
            });
        });

        // Intercept sort form
        const sortSelect = document.querySelector('.sort-select');
        if (sortSelect) {
            sortSelect.addEventListener('change', function(e) {
                const url = new URL(window.location.href);
                url.searchParams.set('sort', this.value);
                fetchCatalog(url.toString());
            });
        }
    };

    const fetchCatalog = (url) => {
        // Visual feedback
        document.getElementById('catalog-results').style.opacity = '0.5';
        
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            
            // Replace main content
            document.getElementById('catalog-results').innerHTML = doc.getElementById('catalog-results').innerHTML;
            document.getElementById('catalog-results').style.opacity = '1';
            
            // Replace sidebar to update active states
            document.getElementById('catalog-sidebar').innerHTML = doc.getElementById('catalog-sidebar').innerHTML;
            
            // Update URL
            window.history.pushState({}, '', url);
            
            // Re-attach listeners to new DOM elements
            attachAjax();
            
            // Ensure alpine components in new HTML are initialized
            if (window.Alpine) {
                window.Alpine.discoverUninitializedComponents(function() {
                    window.Alpine.initializeComponent(this);
                });
            }
        })
        .catch(err => {
            console.error('Error fetching catalog:', err);
            window.location.href = url; // fallback
        });
    };

    attachAjax();

    window.addEventListener('popstate', function() {
        fetchCatalog(window.location.href);
    });
});
</script>
@endpush
