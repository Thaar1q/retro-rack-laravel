@extends('layouts.app')

@section('title', $article->title . ' - RetroRack')

@section('content')
<div class="article-detail-page">
    <div class="container article-container">
        {{-- Breadcrumb --}}
        <div class="breadcrumb">
            <a href="{{ route('artikel') }}">ARTIKEL</a>
            <span class="sep">/</span>
            <span>{{ strtoupper(Str::limit($article->title, 40)) }}</span>
        </div>

        {{-- Tags --}}
        <div class="article-tags">
            <span class="tag-primary">{{ $article->tag }}</span>
        </div>

        {{-- Title --}}
        <h1 class="article-detail-title serif">{{ $article->title }}</h1>

        {{-- Meta Info --}}
        <div class="article-meta-box">
            <div class="meta-item">
                <span class="meta-label">PENULIS</span>
                <span class="meta-value">{{ $article->author?->name ?? 'RetroRack' }}</span>
            </div>
            <div class="meta-item">
                <span class="meta-label">TGL. TERBIT</span>
                <span class="meta-value">{{ ($article->published_at ?? $article->created_at)->translatedFormat('d M Y') }}</span>
            </div>
            <div class="meta-item">
                <span class="meta-label">ESTIMASI BACA</span>
                <span class="meta-value">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px; vertical-align: text-bottom;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    {{ max(1, round(str_word_count(strip_tags($article->body)) / 200)) }} MENIT
                </span>
            </div>
        </div>

        {{-- Main Image --}}
        <div class="article-main-image-wrap">
            @if($article->image)
                <img src="{{ $article->imageUrl() }}" alt="{{ $article->title }}" class="article-main-image">
            @else
                <div class="article-main-image"></div>
            @endif
        </div>

        {{-- Content --}}
        <div class="article-content markdown-body">
            {!! Str::markdown($article->body) !!}
        </div>
    </div>
</div>

{{-- Related Articles --}}
@if($related->isNotEmpty())
<div class="related-section">
    <div class="container">
        <div class="section-header" style="align-items: center; margin-bottom: 32px;">
            <div>
                <h2 class="section-title serif italic" style="font-size: 28px;">Arsip Terkait</h2>
            </div>
            <a href="{{ route('artikel') }}" class="link-all">Lihat Semua &rarr;</a>
        </div>

        <div class="artikel-grid">
            @foreach($related as $rel)
            <a href="{{ route('detail.artikel', $rel->slug) }}" class="related-card">
                @if($rel->image)
                    <img src="{{ $rel->imageUrl() }}" alt="{{ $rel->title }}" class="article-img">
                @else
                    <div class="article-img"></div>
                @endif
                <div class="related-card-content">
                    <span class="article-tag">{{ $rel->tag }}</span>
                    <h3 class="related-title">{{ $rel->title }}</h3>
                    <div class="related-footer">
                        <span>{{ ($rel->published_at ?? $rel->created_at)->translatedFormat('d M Y') }}</span>
                        <span>Baca &rarr;</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endif
@endsection
