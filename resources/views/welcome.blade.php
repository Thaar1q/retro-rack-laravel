@extends('layouts.app')

@section('title', 'RetroRack - Temukan Perangkat Retro Impianmu')

@section('content')
    {{-- Hero Section --}}
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <span class="dash"></span>
                <h1 class="hero-title serif">Temukan<br>Perangkat Retro<br><span class="highlight">Impianmu</span></h1>
                <p class="hero-desc">Jelajahi koleksi perangkat elektronik vintage berkualitas. Dari kamera klasik hingga audio legendaris, semua ada di sini untuk menghidupkan kembali nostalgia.</p>
                <div style="display: flex; gap: 16px;">
                    <a href="{{ route('katalog') }}" class="btn btn-dark">Jelajahi Koleksi &rarr;</a>
                    <a href="{{ route('artikel') }}" class="btn btn-outline">Baca Artikel</a>
                </div>
            </div>
            <div class="hero-images">
                <div class="img-main" style="background-image: url('{{ asset('images/General_LandingPageBig.jpg') }}'); background-size: cover; background-position: center;"></div>
                <div class="img-overlay" style="background-image: url('{{ asset('images/General_LandingPageSmall.jpg') }}'); background-size: cover; background-position: center;"></div>
            </div>
        </div>
    </section>

    {{-- Categories --}}
    <section class="categories">
        <div class="container">
            <div class="cat-grid">
                @foreach($categories as $index => $cat)
                <a href="{{ route('katalog', ['category' => $cat->slug]) }}" class="cat-card">
                    <span class="cat-id">CAT-{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    @if($cat->slug === 'kamera')
                        <svg class="cat-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                            <circle cx="12" cy="13" r="4"></circle>
                        </svg>
                    @elseif($cat->slug === 'audio')
                        <svg class="cat-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 18v-6a9 9 0 0 1 18 0v6"></path>
                            <path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"></path>
                        </svg>
                    @elseif($cat->slug === 'video')
                        <svg class="cat-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="23 7 16 12 23 17 23 7"></polygon>
                            <rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>
                        </svg>
                    @elseif($cat->slug === 'komputer')
                        <svg class="cat-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                            <line x1="8" y1="21" x2="16" y2="21"></line>
                            <line x1="12" y1="17" x2="12" y2="21"></line>
                        </svg>
                    @else
                        <svg class="cat-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="2" width="20" height="20" rx="2" ry="2"></rect>
                            <circle cx="12" cy="12" r="4"></circle>
                        </svg>
                    @endif
                    <h3 class="cat-title">{{ $cat->name }}</h3>
                    <span class="cat-count">{{ $cat->products_count }}+ ITEMS</span>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Rak Produk --}}
    <section class="rak-produk">
        <div class="container">
            <div class="section-header">
                <div>
                    <span class="dash"></span>
                    <h2 class="section-title serif">Rak Produk</h2>
                    <p class="section-subtitle">Koleksi terbaru perangkat retro pilihan</p>
                </div>
                <a href="{{ route('katalog') }}" class="link-all">Lihat Semua &rarr;</a>
            </div>

            {{-- Top 4 products as large cards --}}
            <div class="products-grid-top">
                @foreach($featuredProducts->take(4) as $product)
                <x-product-card :product="$product" type="large" />
                @endforeach
            </div>

            {{-- Remaining products as small cards --}}
            <div class="products-grid-bottom">
                @foreach($featuredProducts->skip(4) as $product)
                <x-product-card :product="$product" type="small" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- Artikel Terbaru --}}
    <section class="artikel">
        <div class="container">
            <div class="section-header">
                <div>
                    <span class="dash"></span>
                    <h2 class="section-title serif">Artikel Terbaru</h2>
                    <p class="section-subtitle">Panduan dan cerita seputar perangkat retro</p>
                </div>
                <a href="{{ route('artikel') }}" class="link-all">Lihat Semua &rarr;</a>
            </div>

            <div class="artikel-grid">
                @foreach($latestArticles as $article)
                <x-article-card :article="$article" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="cta">
        <div class="container">
            <div class="cta-box">
                <span class="dash-center"></span>
                <h2 class="cta-title serif">Punya Koleksi Retro?</h2>
                <p class="cta-desc">Bergabung sebagai penjual dan bagikan koleksi vintage Anda dengan komunitas pecinta retro di seluruh dunia. Dapatkan harga terbaik untuk perangkat legendarismu.</p>
                <button class="btn btn-primary">Daftar Sebagai Penjual &rarr;</button>
            </div>
        </div>
    </section>
@endsection
