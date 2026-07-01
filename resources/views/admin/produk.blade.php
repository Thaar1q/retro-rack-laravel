@extends('layouts.admin')

@section('title', 'Kelola Produk - Admin RetroRack')

@section('content')
<div class="admin-header-row">
    <div>
        <span class="dash"></span>
        <h1 class="admin-page-title serif">Kelola Produk</h1>
        <p class="admin-page-subtitle">Manage semua koleksi produk vintage RetroRack.</p>
    </div>
    <a href="{{ route('admin.produk.create') }}" class="btn btn-primary" style="padding: 12px 24px;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px; vertical-align: text-bottom;"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        Tambah Produk
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <form method="GET" action="{{ route('admin.produk') }}" class="admin-table-controls" style="width: 100%; margin-bottom: 0;">
            <div class="admin-search-wrapper">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}">
                @if(request()->hasAny(['search', 'category']))
                    <a href="{{ route('admin.produk') }}" style="color: var(--color-text-light); margin-left: 8px;" title="Reset Filter">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </a>
                @endif
            </div>
            <div>
                <select name="category" class="form-input" style="width: 180px; height: 44px;" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
    
    <table class="admin-table">
        <thead>
            <tr>
                <th style="width: 60px;">
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'direction' => request('sort') === 'id' && request('direction') === 'asc' ? 'desc' : 'asc']) }}" style="color: inherit; text-decoration: none;">
                        ID @if(request('sort') === 'id') {!! request('direction') === 'asc' ? '↑' : '↓' !!} @endif
                    </a>
                </th>
                <th style="width: 100px;">THUMBNAIL</th>
                <th>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'direction' => request('sort') === 'name' && request('direction') === 'asc' ? 'desc' : 'asc']) }}" style="color: inherit; text-decoration: none;">
                        NAMA PRODUK @if(request('sort') === 'name') {!! request('direction') === 'asc' ? '↑' : '↓' !!} @endif
                    </a>
                </th>
                <th>KATEGORI</th>
                <th>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'price', 'direction' => request('sort') === 'price' && request('direction') === 'asc' ? 'desc' : 'asc']) }}" style="color: inherit; text-decoration: none;">
                        HARGA @if(request('sort') === 'price') {!! request('direction') === 'asc' ? '↑' : '↓' !!} @endif
                    </a>
                </th>
                <th>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'stock', 'direction' => request('sort') === 'stock' && request('direction') === 'asc' ? 'desc' : 'asc']) }}" style="color: inherit; text-decoration: none;">
                        STOK @if(request('sort') === 'stock') {!! request('direction') === 'asc' ? '↑' : '↓' !!} @endif
                    </a>
                </th>
                <th>STATUS</th>
                <th style="text-align: right;">AKSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td style="font-weight: 700; color: var(--color-text-light);">{{ $product->id }}</td>
                <td>
                    @if($product->image)
                        <img src="{{ $product->imageUrl() }}" alt="" class="table-img" style="object-fit: cover;" loading="lazy">
                    @else
                        <div class="table-img" style="background-color: var(--color-dark);"></div>
                    @endif
                </td>
                <td style="font-weight: 600;">{{ $product->name }}</td>
                <td style="color: var(--color-text-light);">{{ $product->category->name }}</td>
                <td style="font-weight: 600;">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td>{{ $product->stock }}</td>
                <td><span class="badge-status {{ $product->is_active ? 'active' : 'draft' }}">{{ $product->is_active ? 'AKTIF' : 'NONAKTIF' }}</span></td>
                <td>
                    <div class="table-actions" style="justify-content: flex-end;">
                        <a href="{{ route('admin.produk.edit', $product) }}" class="btn-table-action"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>
                        <form method="POST" action="{{ route('admin.produk.destroy', $product) }}" onsubmit="return confirm('Hapus produk ini?')" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-table-action"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align: center; color: var(--color-text-light);">Tidak ada produk.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="admin-pagination-wrapper">
        <div class="admin-pagination-info">Showing <strong>{{ $products->firstItem() }}-{{ $products->lastItem() }}</strong> of <strong>{{ $products->total() }}</strong> products</div>
        <div class="pagination">{{ $products->links() }}</div>
    </div>
</div>
@endsection
