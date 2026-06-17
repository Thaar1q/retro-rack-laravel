@extends('layouts.admin')

@section('title', 'Edit Produk - Admin RetroRack')

@section('content')
<div class="admin-header-row" style="margin-bottom: 24px;">
    <div>
        <a href="{{ route('admin.produk') }}" style="display: inline-flex; align-items: center; gap: 8px; font-size: 13px; color: var(--color-text-light); margin-bottom: 16px; transition: color 0.2s;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Kembali ke Daftar Produk
        </a>
        <h1 class="admin-page-title serif">Edit Produk: {{ $product->name }}</h1>
        <p class="admin-page-subtitle">Perbarui informasi produk retro di katalog Anda.</p>
    </div>
</div>

<form action="{{ route('admin.produk.update', $product) }}" method="POST" enctype="multipart/form-data" class="admin-form-container">
    @method('PUT')
    @csrf
    <div class="admin-form-main">
        <div class="admin-form-section">
            <h2 class="admin-form-title" style="font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: var(--color-primary); margin-bottom: 24px;">Informasi Dasar</h2>
            
            <div class="admin-form-group">
                <label class="admin-form-label" style="color: var(--color-dark); font-weight: 500; text-transform: none; letter-spacing: normal;">Nama Produk</label>
                <input type="text" name="name" class="admin-form-input" placeholder="Contoh: Canon AE-1 Program" value="{{ old('name', $product->name) }}" required>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                <div class="admin-form-group">
                    <label class="admin-form-label" style="color: var(--color-dark); font-weight: 500; text-transform: none; letter-spacing: normal;">Kategori</label>
                    <select name="category_id" class="admin-form-input" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label" style="color: var(--color-dark); font-weight: 500; text-transform: none; letter-spacing: normal;">Tahun Produksi</label>
                    <input type="number" name="year" class="admin-form-input" placeholder="1981" value="{{ old('year', $product->year) }}" required>
                </div>
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label" style="color: var(--color-dark); font-weight: 500; text-transform: none; letter-spacing: normal;">Kondisi</label>
                <select name="condition" class="admin-form-input" required>
                    <option value="">Pilih Kondisi</option>
                    <option value="mint" {{ old('condition', $product->condition) == 'mint' ? 'selected' : '' }}>Mint / Like New</option>
                    <option value="sangat_baik" {{ old('condition', $product->condition) == 'sangat_baik' ? 'selected' : '' }}>Sangat Baik</option>
                    <option value="baik" {{ old('condition', $product->condition) == 'baik' ? 'selected' : '' }}>Baik</option>
                    <option value="cukup" {{ old('condition', $product->condition) == 'cukup' ? 'selected' : '' }}>Cukup</option>
                </select>
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label" style="color: var(--color-dark); font-weight: 500; text-transform: none; letter-spacing: normal;">Deskripsi</label>
                <textarea name="description" class="admin-form-textarea" placeholder="Jelaskan kondisi dan detail produk secara lengkap..." required>{{ old('description', $product->description) }}</textarea>
            </div>
        </div>

        <div class="admin-form-section">
            <h2 class="admin-form-title" style="font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: var(--color-primary); margin-bottom: 24px;">Harga & Stok</h2>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                <div class="admin-form-group">
                    <label class="admin-form-label" style="color: var(--color-dark); font-weight: 500; text-transform: none; letter-spacing: normal;">Harga Jual (Rp)</label>
                    <input type="number" name="price" class="admin-form-input" placeholder="2500000" value="{{ old('price', $product->price) }}" required>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label" style="color: var(--color-dark); font-weight: 500; text-transform: none; letter-spacing: normal;">Stok</label>
                    <input type="number" name="stock" class="admin-form-input" placeholder="1" value="{{ old('stock', $product->stock) }}" required>
                </div>
            </div>
        </div>
        
        <div class="admin-form-section" x-data="{ previewUrl: null }">
            <h2 class="admin-form-title" style="font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: var(--color-primary); margin-bottom: 24px;">Foto Produk</h2>
            
            <input type="file" id="image" name="image" class="hidden" style="display:none;" 
                @change="const file = $event.target.files[0]; if(file) { const reader = new FileReader(); reader.onload = (e) => previewUrl = e.target.result; reader.readAsDataURL(file); } else { previewUrl = null; }">
            
            <label for="image" class="admin-upload-box" style="display:block; padding: 24px;">
                <div x-show="!previewUrl && !'{{ $product->image }}'">
                    <div class="admin-upload-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                    </div>
                    <div style="font-size: 15px; font-weight: 700; color: var(--color-dark); margin-bottom: 8px;"><span style="color: var(--color-primary);">Klik untuk upload</span> foto</div>
                    <div style="font-size: 12px; color: var(--color-text-light);">PNG, JPG (max 2MB)</div>
                </div>
                
                <div x-show="previewUrl || '{{ $product->image }}'" style="display:block;">
                    <img :src="previewUrl || '{{ $product->imageUrl() }}'" alt="Preview" style="max-height: 200px; max-width: 100%; border-radius: 8px; margin: 0 auto;">
                    <div style="margin-top: 16px; font-size: 13px; color: var(--color-primary); font-weight: 600;">Ganti Foto</div>
                </div>
            </label>
        </div>
    </div>

    <div class="admin-form-sidebar">
        <div class="admin-sidebar-card">
            <h3 class="admin-sidebar-title">Status Publikasi</h3>
            
            <div class="admin-form-group">
                <label class="admin-form-label" style="color: var(--color-text-light);">STATUS</label>
                <select name="is_active" class="admin-form-input">
                    <option value="0" {{ old('is_active', $product->is_active) == '0' ? 'selected' : '' }}>Draft</option>
                    <option value="1" {{ old('is_active', $product->is_active) == '1' ? 'selected' : '' }}>Aktif</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-dark" style="width: 100%; margin-bottom: 12px; padding: 12px;">Perbarui Produk</button>
            <a href="{{ route('admin.produk') }}" class="btn btn-outline" style="width: 100%; padding: 12px; display: inline-block; text-align: center;">Batal</a>
        </div>

        <div class="tips-card">
            <h3 class="tips-title">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--color-primary);"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                Tips Produk
            </h3>
            <ul class="tips-list">
                <li>Gunakan foto dengan pencahayaan baik agar terlihat profesional.</li>
                <li>Jelaskan kondisi fisik dengan detail untuk membangun kepercayaan.</li>
                <li>Cantumkan kelengkapan aksesoris (strap, case, baterai, dll).</li>
                <li>Berikan harga kompetitif sesuai dengan kondisi barang retro.</li>
            </ul>
        </div>
    </div>
</form>
@endsection
