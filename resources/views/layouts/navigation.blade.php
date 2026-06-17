<header class="header" x-data="{ open: false }">
    <div class="container">
        <a href="{{ route('home') }}" class="logo">
            <div class="logo-box">RR</div>
            <span class="logo-text">RetroRack</span>
        </a>

        <nav class="nav">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
            <a href="{{ route('katalog') }}" class="{{ request()->routeIs('katalog') || request()->routeIs('detail.produk') ? 'active' : '' }}">Katalog</a>
            <a href="{{ route('artikel') }}" class="{{ request()->routeIs('artikel') || request()->routeIs('detail.artikel') ? 'active' : '' }}">Artikel</a>
        </nav>

        <div class="header-right">
            {{-- Animated Search --}}
            <div class="search-widget nav-desktop-flex" x-data="{ expanded: false }" @keydown.escape.window="expanded = false">
                <div class="search-inner" :class="{ 'search-open': expanded }">
                    <button @click="expanded = !expanded; if(expanded) $nextTick(() => $refs.searchInput.focus())" class="icon search-icon-btn" aria-label="Search">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    </button>
                    <input x-ref="searchInput" type="text" class="search-expand-input" placeholder="Cari produk..." x-show="expanded" @blur="expanded = false">
                </div>
            </div>

            <div class="header-icons">
                @auth
                    {{-- Cart icon — all users including admin --}}
                    <a href="{{ route('keranjang') }}" class="icon" x-data="{ count: {{ \App\Models\Cart::where('user_id', auth()->id())->count() }} }" @cart-updated.window="count = $event.detail" aria-label="Keranjang">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                        <span class="cart-badge" x-text="count" x-show="count > 0"></span>
                    </a>

                    {{-- Profile Dropdown --}}
                    <div class="profile-dropdown nav-desktop-block" x-data="{ profileOpen: false }" @click.away="profileOpen = false">
                        <button @click="profileOpen = !profileOpen" class="profile-btn" aria-label="Profil">
                            <div class="profile-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                        </button>
                        <div class="profile-menu"
                             x-show="profileOpen"
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-end="opacity-0"
                             style="display:none;">
                            <div class="profile-menu-header">
                                <div class="profile-menu-name">{{ auth()->user()->name }}</div>
                                <div class="profile-menu-email">{{ auth()->user()->email }}</div>
                            </div>
                            <div class="profile-menu-body">
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="profile-menu-item">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                                        Admin Panel
                                    </a>
                                @endif
                                <a href="{{ route('riwayat') }}" class="profile-menu-item">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>
                                    Riwayat Pesanan
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="profile-menu-item profile-menu-logout">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline nav-desktop-inline-flex" style="padding: 8px 16px;">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-dark nav-desktop-inline-flex" style="padding: 8px 16px;">Daftar</a>
                @endauth

                <button @click="open = !open" class="icon nav-mobile-only" style="margin-left: 8px; border:none; background:none; cursor:pointer;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                </button>
            </div>
        </div>
    </div>

    <template x-teleport="body">
        <div x-show="open" style="display: none;">
            <div class="mobile-overlay" x-show="open" x-transition.opacity @click="open = false"></div>
            <div class="mobile-sidebar" x-show="open"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="transform translate-x-full"
                 x-transition:enter-end="transform translate-x-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="transform translate-x-0"
                 x-transition:leave-end="transform translate-x-full"
                 @click.away="open = false">
                <button class="mobile-close" @click="open = false">&times;</button>
                <div class="mobile-nav-links">
                    <a href="{{ route('home') }}">Beranda</a>
                    <a href="{{ route('katalog') }}">Katalog</a>
                    <a href="{{ route('artikel') }}">Artikel</a>
                </div>
                <div class="mobile-auth">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline" style="width: 100%;">Admin Panel</a>
                        @endif
                        <a href="{{ route('riwayat') }}" class="btn btn-outline" style="width: 100%;">Riwayat</a>
                        <form method="POST" action="{{ route('logout') }}" style="width: 100%;">
                            @csrf
                            <button type="submit" class="btn btn-outline" style="width: 100%;">Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline" style="width: 100%;">Masuk</a>
                        <a href="{{ route('register') }}" class="btn btn-dark" style="width: 100%;">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </template>
</header>