@extends('layouts.admin')

@section('title', 'Edit Pengguna - Admin RetroRack')

@section('content')
<div class="admin-header-row" style="margin-bottom: 24px;">
    <div>
        <a href="{{ route('admin.pengguna') }}" style="display: inline-flex; align-items: center; gap: 8px; font-size: 13px; color: var(--color-text-light); margin-bottom: 16px; transition: color 0.2s;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Kembali ke Daftar Pengguna
        </a>
        <span class="dash"></span>
        <h1 class="admin-page-title serif">Edit Pengguna</h1>
        <p class="admin-page-subtitle">Perbarui data: {{ $user->name }}</p>
    </div>
</div>

<form action="{{ route('admin.pengguna.update', $user) }}" method="POST" class="admin-form-container">
    @csrf
    @method('PUT')
    <div class="admin-form-main">
        <div class="admin-form-section">
            <h2 class="admin-form-title">Informasi Pribadi</h2>
            
            <div class="admin-form-group">
                <label class="admin-form-label" style="color: var(--color-dark); font-weight: 600; text-transform: none; letter-spacing: normal;">Nama Lengkap</label>
                <input type="text" name="name" class="admin-form-input" placeholder="Contoh: Ahmad Riadi" value="{{ old('name', $user->name) }}" required>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                <div class="admin-form-group">
                    <label class="admin-form-label" style="color: var(--color-dark); font-weight: 600; text-transform: none; letter-spacing: normal;">Email</label>
                    <input type="email" name="email" class="admin-form-input" placeholder="email@example.com" value="{{ old('email', $user->email) }}" required>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label" style="color: var(--color-dark); font-weight: 600; text-transform: none; letter-spacing: normal;">Password</label>
                    <input type="password" name="password" class="admin-form-input" placeholder="Kosongkan jika tidak ingin diubah">
                </div>
            </div>
        </div>

        <div class="admin-form-section">
            <h2 class="admin-form-title">Akses & Peran</h2>
            
            <div class="admin-form-group">
                <label class="admin-form-label" style="color: var(--color-primary); font-weight: 700; text-transform: uppercase; letter-spacing: 1px; font-size: 10px;">PERAN PENGGUNA</label>
                <select name="is_admin" class="admin-form-input">
                    <option value="0" {{ old('is_admin', $user->is_admin) == '0' ? 'selected' : '' }}>User</option>
                    <option value="1" {{ old('is_admin', $user->is_admin) == '1' ? 'selected' : '' }}>Admin</option>
                </select>
                <div style="font-size: 12px; color: var(--color-text-light); margin-top: 8px; font-style: italic;">User memiliki akses terbatas hanya untuk belanja dan menulis ulasan.</div>
            </div>
        </div>
        
        <div style="display: flex; gap: 16px;">
            <button type="submit" class="btn btn-primary" style="padding: 14px 24px; display: inline-flex; align-items: center; gap: 8px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                Simpan Pengguna
            </button>
            <a href="{{ route('admin.pengguna') }}" class="btn btn-outline" style="padding: 14px 24px; border-color: var(--color-dark); color: var(--color-dark); text-decoration: none;">Batal</a>
        </div>
    </div>

    <div class="admin-form-sidebar">
        <div class="tips-card">
            <h3 class="tips-title">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--color-primary);"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                Panduan Admin
            </h3>
            <ul class="tips-list">
                <li>Gunakan email institusi untuk staf admin RetroRack.</li>
                <li>Role 'Admin' dapat mengelola semua konten dan pengguna.</li>
                <li>Pastikan email valid untuk memudahkan komunikasi.</li>
            </ul>
        </div>
    </div>
</form>
@endsection
