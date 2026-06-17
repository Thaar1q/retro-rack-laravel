@extends('layouts.admin')

@section('title', 'Kelola Pengguna - Admin RetroRack')

@section('content')
<div class="admin-header-row">
    <div>
        <span class="dash"></span>
        <h1 class="admin-page-title serif">Kelola Pengguna</h1>
        <p class="admin-page-subtitle">Manage semua pengguna RetroRack dari dashboard pusat.</p>
    </div>
    <a href="{{ route('admin.pengguna.create') }}" class="btn btn-primary" style="padding: 12px 24px; text-decoration: none;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px; vertical-align: text-bottom;"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        Tambah Pengguna
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <form method="GET" action="{{ route('admin.pengguna') }}" class="admin-table-controls" style="width: 100%; margin-bottom: 0;">
            <div class="admin-search-wrapper">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <input type="text" name="search" placeholder="Cari pengguna..." value="{{ request('search') }}">
                @if(request()->hasAny(['search', 'role']))
                    <a href="{{ route('admin.pengguna') }}" style="color: var(--color-text-light); margin-left: 8px;" title="Reset Filter">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </a>
                @endif
            </div>
            <div>
                <select name="role" class="form-input" style="width: 180px; height: 44px;" onchange="this.form.submit()">
                    <option value="">Semua Role</option>
                    <option value="1" {{ request('role') == '1' ? 'selected' : '' }}>Admin</option>
                    <option value="0" {{ request('role') == '0' ? 'selected' : '' }}>User</option>
                </select>
            </div>
        </form>
    </div>
    
    <table class="admin-table">
        <thead>
            <tr>
                <th style="width: 60px;">ID</th>
                <th>NAMA</th>
                <th>EMAIL</th>
                <th>ROLE</th>
                <th>BERGABUNG</th>
                <th style="text-align: right;">AKSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td style="font-weight: 700; color: var(--color-text-light);">{{ $user->id }}</td>
                <td style="font-weight: 600;">{{ $user->name }}</td>
                <td style="color: var(--color-text-light);">{{ $user->email }}</td>
                <td><span class="badge-status {{ $user->is_admin ? 'active' : '' }}">{{ $user->is_admin ? 'ADMIN' : 'USER' }}</span></td>
                <td style="color: var(--color-text-light);">{{ $user->created_at->format('d M Y') }}</td>
                <td>
                    <div class="table-actions" style="justify-content: flex-end;">
                        <a href="{{ route('admin.pengguna.edit', $user) }}" class="btn-table-action" title="Edit"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>
                        @if($user->id !== auth()->id())
                        <form action="{{ route('admin.pengguna.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus pengguna ini?');" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-table-action" title="Hapus"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align: center; color: var(--color-text-light);">Belum ada pengguna.</td></tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="admin-pagination-wrapper">
        <div class="admin-pagination-info">Showing <strong>{{ $users->firstItem() ?? 0 }}-{{ $users->lastItem() ?? 0 }}</strong> of <strong>{{ $users->total() }}</strong> users</div>
        <div class="pagination">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
