@extends('layouts.guest')

@section('title', 'Daftar - RetroRack')

@section('content')
<div class="auth-layout">
    <div class="auth-image-side">
        <img src="{{ asset('images/General_LoginRegister.jpg') }}" alt="Retro Tech">
    </div>
    <div class="auth-form-side">
        <div class="auth-form-wrapper">
            <span class="dash"></span>
            <h1 class="auth-title serif">Buat Akun Baru</h1>
            <p class="auth-subtitle">Bergabunglah dan mulai perjalanan nostalgia Anda bersama ribuan kolektor lainnya.</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="auth-form-group">
                    <label for="name" class="auth-form-label">Nama Lengkap</label>
                    <input id="name" class="auth-form-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="John Doe">
                    @error('name')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="auth-form-group">
                    <label for="email" class="auth-form-label">Alamat Email</label>
                    <input id="email" class="auth-form-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="nama@email.com">
                    @error('email')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="auth-form-group" x-data="{ 
                        show: false, 
                        password: '',
                        get strength() {
                            let s = 0;
                            if (this.password.length >= 8) s++;
                            if (this.password.match(/[a-z]/) && this.password.match(/[A-Z]/)) s++;
                            if (this.password.match(/\d/)) s++;
                            if (this.password.match(/[^a-zA-Z\d]/)) s++;
                            return s;
                        }
                    }">
                    <label for="password" class="auth-form-label">Password</label>
                    <div class="auth-input-wrapper" style="position: relative;">
                        <input id="password" class="auth-form-input" :type="show ? 'text' : 'password'" name="password" x-model="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" style="padding-right: 40px;">
                        <button type="button" @click="show = !show" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: var(--color-text-light); cursor: pointer;">
                            <svg x-show="!show" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            <svg x-show="show" style="display: none;" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                        </button>
                    </div>
                    
                    <!-- Strength Meter -->
                    <div class="password-strength" style="display: flex; gap: 4px; margin-top: 8px;" x-show="password.length > 0" x-cloak>
                        <div style="height: 4px; flex: 1; border-radius: 2px; transition: background-color 0.3s;" :style="{ backgroundColor: strength >= 1 ? (strength === 1 ? '#ef4444' : (strength === 2 ? '#eab308' : '#22c55e')) : '#e5e7eb' }"></div>
                        <div style="height: 4px; flex: 1; border-radius: 2px; transition: background-color 0.3s;" :style="{ backgroundColor: strength >= 2 ? (strength === 2 ? '#eab308' : '#22c55e') : '#e5e7eb' }"></div>
                        <div style="height: 4px; flex: 1; border-radius: 2px; transition: background-color 0.3s;" :style="{ backgroundColor: strength >= 3 ? '#22c55e' : '#e5e7eb' }"></div>
                        <div style="height: 4px; flex: 1; border-radius: 2px; transition: background-color 0.3s;" :style="{ backgroundColor: strength >= 4 ? '#22c55e' : '#e5e7eb' }"></div>
                    </div>
                    
                    @error('password')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="auth-form-group" x-data="{ show: false }">
                    <label for="password_confirmation" class="auth-form-label">Konfirmasi Password</label>
                    <div class="auth-input-wrapper" style="position: relative;">
                        <input id="password_confirmation" class="auth-form-input" :type="show ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password" style="padding-right: 40px;">
                        <button type="button" @click="show = !show" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: var(--color-text-light); cursor: pointer;">
                            <svg x-show="!show" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            <svg x-show="show" style="display: none;" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="auth-terms">
                    Dengan mendaftar, Anda menyetujui <a href="#">Syarat & Ketentuan</a> serta <a href="#">Kebijakan Privasi</a> kami.
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; height: 52px; font-size: 15px;">Daftar Akun</button>
            </form>

            <div class="auth-separator"><span>ATAU</span></div>

            <div class="auth-switch">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di Sini</a>
            </div>
            
            <div class="auth-back">
                <a href="{{ route('home') }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
