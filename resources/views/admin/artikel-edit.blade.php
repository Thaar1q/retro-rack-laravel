@extends('layouts.admin')

@section('title', 'Edit Artikel - Admin RetroRack')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
<style>
    .editor-toolbar { border: none; border-bottom: 1px solid var(--color-border); background-color: #fafafa; border-radius: 8px 8px 0 0; }
    .CodeMirror { border: none; min-height: 400px; font-family: var(--font-sans); font-size: 15px; border-radius: 0 0 8px 8px; }
    .editor-toolbar button { color: var(--color-text); }
    .editor-toolbar button.active, .editor-toolbar button:hover { background-color: var(--color-border); border-color: transparent; color: var(--color-dark); }
</style>

<div class="admin-header-row" style="margin-bottom: 24px;">
    <div>
        <a href="{{ route('admin.artikel') }}" style="display: inline-flex; align-items: center; gap: 8px; font-size: 13px; color: var(--color-text-light); margin-bottom: 16px; transition: color 0.2s;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Kembali ke Daftar Artikel
        </a>
        <h1 class="admin-page-title serif">Edit Artikel</h1>
        <p class="admin-page-subtitle">Perbarui artikel: {{ $article->title }}</p>
    </div>
</div>

<form action="{{ route('admin.artikel.update', $article) }}" method="POST" enctype="multipart/form-data" class="admin-form-container">
    @csrf
    @method('PUT')
    <div class="admin-form-main">
        <div class="admin-form-section">
            <h2 class="admin-form-title">Informasi Artikel</h2>
            
            <div class="admin-form-group">
                <label class="admin-form-label">JUDUL ARTIKEL</label>
                <input type="text" name="title" class="admin-form-input" placeholder="Contoh: Panduan Merawat Kamera Film Vintage" value="{{ old('title', $article->title) }}" required>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                <div class="admin-form-group">
                    <label class="admin-form-label">KATEGORI</label>
                    <select class="admin-form-input">
                        <option>Pilih Kategori</option>
                        <option>Panduan</option>
                        <option>Review</option>
                        <option>Berita</option>
                    </select>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">TAG</label>
                    <input type="text" name="tag" class="admin-form-input" placeholder="Gunakan koma untuk memisahkan" value="{{ old('tag', $article->tag) }}">
                </div>
            </div>
            
            <div class="admin-form-group">
                <div style="display: flex; justify-content: space-between;">
                    <label class="admin-form-label">EXCERPT</label>
                    <span style="font-size: 10px; color: var(--color-text-light);">0 / 160</span>
                </div>
                <textarea name="excerpt" class="admin-form-textarea" placeholder="Ringkasan singkat artikel (2-3 kalimat)..." style="min-height: 80px;">{{ old('excerpt', $article->excerpt) }}</textarea>
            </div>
        </div>

        <div class="admin-form-section" x-data="{ previewUrl: '{{ $article->image ? $article->imageUrl() : null }}' }">
            <h2 class="admin-form-title">Cover Image</h2>
            
            <input type="file" id="image" name="image" class="hidden" style="display:none;" 
                @change="const file = $event.target.files[0]; if(file) { const reader = new FileReader(); reader.onload = (e) => previewUrl = e.target.result; reader.readAsDataURL(file); } else { previewUrl = null; }">
                
            <label for="image" class="admin-upload-box" style="display:block;">
                <div x-show="!previewUrl">
                    <div class="admin-upload-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                    </div>
                    <div style="font-size: 15px; font-weight: 700; color: var(--color-dark); margin-bottom: 8px;">Klik untuk upload cover image</div>
                    <div style="font-size: 12px; color: var(--color-text-light);">PNG, JPG hingga 5MB (rekomendasi ratio 16:9)</div>
                </div>
                <div x-show="previewUrl" style="display:none;">
                    <img :src="previewUrl" alt="Preview" style="max-height: 200px; max-width: 100%; border-radius: 8px; margin: 0 auto;">
                    <div style="margin-top: 16px; font-size: 13px; color: var(--color-primary); font-weight: 600;">Ganti Foto</div>
                </div>
            </label>
        </div>

        <div class="admin-form-section">
            <h2 class="admin-form-title">Konten Artikel</h2>
            <div style="border: 1px solid var(--color-border); border-radius: 8px; overflow: hidden;">
                <textarea id="article-body" name="body" required>{{ old('body', $article->body) }}</textarea>
            </div>
            <div style="font-size: 11px; color: var(--color-text-light); margin-top: 8px; font-style: italic;">
                Gunakan Markdown untuk formatting cepat. Contoh: **bold**, *italic*, # Heading
            </div>
        </div>
    </div>

    <div class="admin-form-sidebar">
        <div class="admin-sidebar-card">
            <h3 class="admin-sidebar-title">Publikasi</h3>
            
            <div class="admin-form-group">
                <label class="admin-form-label">STATUS</label>
                <select name="is_published" class="admin-form-input">
                    <option value="0" {{ old('is_published', $article->is_published) == '0' ? 'selected' : '' }}>Draft</option>
                    <option value="1" {{ old('is_published', $article->is_published) == '1' ? 'selected' : '' }}>Terbit</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-dark" style="width: 100%; margin-bottom: 12px; padding: 12px;">Simpan Artikel</button>
            <a href="{{ route('admin.artikel') }}" class="btn btn-outline" style="width: 100%; padding: 12px; display: inline-block; text-align: center; margin-bottom: 12px;">Batal</a>
            <a href="{{ route('detail.artikel', $article->slug) }}" target="_blank" class="btn btn-primary" style="width: 100%; padding: 12px; display: inline-block; text-align: center;">Lihat Artikel &rarr;</a>
        </div>

        <div class="tips-card">
            <h3 class="tips-title">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--color-primary);"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                Tips Menulis
            </h3>
            <ul class="tips-list">
                <li>Gunakan heading untuk struktur artikel yang rapi.</li>
                <li>Paragraf pendek lebih mudah dibaca di layar digital.</li>
                <li>Sertakan gambar berkualitas tinggi untuk visualisasi.</li>
                <li>Pastikan informasi akurat dan bermanfaat bagi komunitas.</li>
            </ul>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const easyMDE = new EasyMDE({
        element: document.getElementById('article-body'),
        placeholder: "Tulis konten artikel Anda di sini...",
        spellChecker: false,
        status: false,
        toolbar: ["bold", "italic", "strikethrough", "|", "heading-1", "heading-2", "heading-3", "|", "unordered-list", "ordered-list", "|", "quote", "preview", "guide"]
    });
});
</script>
@endpush
