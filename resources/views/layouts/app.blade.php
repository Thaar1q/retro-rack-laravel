<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'RetroRack'))</title>

    <!-- Scripts and CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('layouts.navigation')

    {{-- Flash messages injected into toast system on page load --}}
    @if(session('success'))
    <script>document.addEventListener('DOMContentLoaded', () => window.showToast('{{ addslashes(session('success')) }}'));</script>
    @endif
    @if(session('error'))
    <script>document.addEventListener('DOMContentLoaded', () => window.showToast('{{ addslashes(session('error')) }}'));</script>
    @endif

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-top">
                <div class="footer-col">
                    <div class="footer-logo-row">
                        <div class="logo-box">RR</div>
                        <span class="logo-text">RetroRack</span>
                    </div>
                    <p class="footer-desc">Tempat di mana teknologi klasik menemukan rumah baru. Setiap perangkat punya cerita.</p>
                </div>
                <div class="footer-col">
                    <h4 class="footer-title">Navigasi</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="{{ route('katalog') }}">Katalog</a></li>
                        <li><a href="{{ route('artikel') }}">Artikel</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4 class="footer-title">Akun</h4>
                    <ul class="footer-links">
                        @auth
                            <li><a href="{{ route('keranjang') }}">Keranjang</a></li>
                            <li><a href="{{ route('riwayat') }}">Riwayat Pesanan</a></li>
                        @else
                            <li><a href="{{ route('login') }}">Masuk</a></li>
                            <li><a href="{{ route('register') }}">Daftar</a></li>
                        @endauth
                    </ul>
                </div>
                <div class="footer-col">
                    <h4 class="footer-title">Bantuan</h4>
                    <ul class="footer-links">
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Cara Pembelian</a></li>
                        <li><a href="#">Pengembalian</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="copyright">&copy; {{ date('Y') }} RetroRack. All rights reserved.</div>
                <div class="footer-legal">
                    <a href="#">Syarat & Ketentuan</a>
                    <a href="#">Kebijakan Privasi</a>
                </div>
            </div>
        </div>
    </footer>
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
</body>
</html>
