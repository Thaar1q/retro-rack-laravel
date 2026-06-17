@extends('layouts.guest')

@section('title', 'Login - RetroRack')

@section('content')
    <div class="auth-layout">
        <div class="auth-image-side">
            <img src="{{ asset('images/General_LoginRegister.jpg') }}" alt="Retro Tech">
        </div>
        <div class="auth-form-side">
            <div class="auth-form-wrapper">
                <span class="dash"></span>
                <h1 class="auth-title serif">Selamat Datang Kembali</h1>
                <p class="auth-subtitle">Silakan masukkan detail akun Anda untuk melanjutkan akses ke koleksi RetroRack.</p>

                <!-- Session Status -->
                @if(session('status'))
                    <div
                        style="background-color: #d1fae5; color: #065f46; padding: 12px; border-radius: 8px; margin-bottom: 24px; font-size: 14px; font-weight: 500;">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="auth-form-group">
                        <label for="email" class="auth-form-label">Alamat Email</label>
                        <input id="email" class="auth-form-input" type="email" name="email" value="{{ old('email') }}"
                            required autofocus autocomplete="username" placeholder="nama@email.com">
                        @error('email')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="auth-form-group">
                        <label for="password" class="auth-form-label">
                            <span>Password</span>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    style="color:var(--color-primary); text-transform:none; letter-spacing:0; font-weight:600;">Lupa
                                    Password?</a>
                            @endif
                        </label>
                        <div class="auth-input-wrapper" x-data="{ show: false }" style="position: relative;">
                            <input id="password" class="auth-form-input" :type="show ? 'text' : 'password'" name="password" required
                                autocomplete="current-password" placeholder="••••••••" style="padding-right: 40px;">
                            <button type="button" @click="show = !show" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: var(--color-text-light); cursor: pointer;">
                                <svg x-show="!show" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                <svg x-show="show" style="display: none;" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                            </button>
                        </div>
                        @error('password')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="auth-form-group" style="display:flex; align-items:center;">
                        <input id="remember_me" type="checkbox" name="remember"
                            style="margin-right:8px; accent-color:var(--color-primary);">
                        <label for="remember_me" style="font-size:14px; color:var(--color-text);">Ingat Saya</label>
                    </div>

                    <button type="submit" class="btn btn-dark" style="width: 100%; height: 52px; font-size: 15px;">Masuk ke
                        Akun</button>
                </form>

                <div class="auth-separator"><span>ATAU</span></div>

                <div class="auth-switch">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
                </div>

                <div class="auth-back">
                    <a href="{{ route('home') }}">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <line x1="19" y1="12" x2="5" y2="12"></line>
                            <polyline points="12 19 5 12 12 5"></polyline>
                        </svg>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection