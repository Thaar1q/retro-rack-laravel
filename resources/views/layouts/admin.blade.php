<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'RetroRack Admin')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&display=swap" rel="stylesheet">
    
    <!-- CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-layout">
    {{-- Flash messages injected into toast system on page load --}}
    @if(session('success'))
    <script>document.addEventListener('DOMContentLoaded', () => window.showToast('{{ addslashes(session('success')) }}'));</script>
    @endif
    @if(session('error'))
    <script>document.addEventListener('DOMContentLoaded', () => window.showToast('{{ addslashes(session('error')) }}'));</script>
    @endif
    <aside class="admin-sidebar">
        <div class="admin-sidebar-header">
            <div class="admin-logo-box">RR</div>
            <div class="admin-brand-text">
                <span class="admin-brand-name">RetroRack</span>
                <span class="admin-brand-sub">ADMIN PANEL</span>
            </div>
        </div>
        
        <nav class="admin-nav">
            <a href="{{ route('admin.dashboard') }}" class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                Dashboard
            </a>
            <a href="{{ route('admin.artikel') }}" class="admin-nav-item {{ request()->routeIs('admin.artikel') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                Artikel
            </a>
            <a href="{{ route('admin.produk') }}" class="admin-nav-item {{ request()->routeIs('admin.produk') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                Produk
            </a>
            <a href="{{ route('admin.pengguna') }}" class="admin-nav-item {{ request()->routeIs('admin.pengguna') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                Pengguna
            </a>
            <a href="{{ route('admin.transaksi') }}" class="admin-nav-item {{ request()->routeIs('admin.transaksi') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                Transaksi
            </a>
        </nav>
        
        <div class="admin-sidebar-footer" x-data="{ open: false }" style="position: relative;">
            <button @click="open = !open" style="display: flex; align-items: center; width: 100%; text-align: left; background: none; border: none; cursor: pointer; color: var(--color-text); padding: 8px; border-radius: 8px; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='rgba(255,255,255,0.05)'" onmouseout="this.style.backgroundColor='transparent'">
                <div class="customer-avatar" style="margin-right: 12px; width: 32px; height: 32px; background-color: var(--color-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 14px;">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div style="flex: 1; overflow: hidden;">
                    <div style="font-weight: 600; font-size: 13px; color: var(--color-white); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ auth()->user()->name }}</div>
                    <div style="font-size: 11px; color: #999;">Administrator</div>
                </div>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: #999;"><path d="M6 9l6 6 6-6"/></svg>
            </button>
            
            <div x-show="open" @click.away="open = false" x-transition style="display: none; position: absolute; bottom: 100%; left: 0; right: 0; background-color: var(--color-white); border-radius: 8px; margin-bottom: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border: 1px solid var(--color-border); padding: 8px;">
                <a href="/" style="display: flex; align-items: center; gap: 8px; color: var(--color-dark); padding: 8px 12px; font-size: 13px; font-weight: 500; border-radius: 4px; text-decoration: none;" onmouseover="this.style.backgroundColor='var(--color-bg)'" onmouseout="this.style.backgroundColor='transparent'">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    Kembali ke Situs
                </a>
                <form method="POST" action="{{ route('logout') }}" style="display: block; margin-top: 4px;">
                    @csrf
                    <button type="submit" style="width: 100%; display: flex; align-items: center; gap: 8px; color: #dc2626; padding: 8px 12px; font-size: 13px; font-weight: 500; border-radius: 4px; border: none; background: none; text-align: left; cursor: pointer;" onmouseover="this.style.backgroundColor='#fee2e2'" onmouseout="this.style.backgroundColor='transparent'">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </aside>
    
    <main class="admin-main">
        @yield('content')
        
        <div style="text-align: center; font-size: 11px; color: var(--color-text-light); text-transform: uppercase; letter-spacing: 1px; margin-top: 80px;">
            &copy; {{ date('Y') }} RetroRack Design Operations &mdash; Revamp Template V1.0
        </div>
    </main>

    <div x-data="{ toasts: [] }" 
         @toast.window="toasts.push({ id: Date.now(), msg: $event.detail }); setTimeout(() => { toasts.shift() }, 3000)"
         style="position: fixed; bottom: 24px; right: 24px; z-index: 1000; display: flex; flex-direction: column; gap: 12px;">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-transition.opacity.duration.300ms style="background-color: var(--color-dark); color: white; padding: 12px 24px; border-radius: 8px; font-size: 14px; font-weight: 500; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);">
                <span x-text="toast.msg"></span>
            </div>
        </template>
    </div>

    <script>
        window.showToast = function(msg) {
            window.dispatchEvent(new CustomEvent('toast', { detail: msg }));
        }
    </script>
    
    @stack('scripts')
</body>
</html>
