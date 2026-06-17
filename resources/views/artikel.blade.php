@extends('layouts.app')

@section('title', 'Arsip Artikel - RetroRack')

@section('content')
    <div class="page-header page-header-compact">
        <div class="container">
            <h1 class="page-title serif">Arsip Artikel</h1>
            <p class="page-desc">Panduan, tips, dan cerita seputar perangkat elektronik retro.</p>
        </div>
    </div>

    <div class="container page-layout">
        <aside class="sidebar">
            <div class="filter-group">
                <h3 class="filter-title">Library Index</h3>
                <ul class="filter-list">
                    <li><a href="{{ route('artikel') }}" class="{{ !request('tag') ? 'active' : '' }}">Semua</a></li>
                    @foreach(['TUTORIAL', 'SEJARAH', 'AUDIO', 'OPINI'] as $tag)
                    <li><a href="{{ route('artikel', ['tag' => $tag]) }}" class="{{ request('tag') === $tag ? 'active' : '' }}">{{ ucfirst(strtolower($tag)) }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="curator-note">
                <h4>Curator's Note</h4>
                <p>Setiap artikel dikurasi untuk menjaga integritas sejarah teknologi analog.</p>
            </div>
        </aside>

        <main class="main-content">
            <div class="grid-2">
                @forelse($articles as $article)
                <x-article-card :article="$article" />
                @empty
                <p style="color: var(--color-text-light); grid-column: 1/-1;">Belum ada artikel.</p>
                @endforelse
            </div>

            <div class="pagination">
                {{ $articles->links() }}
            </div>
        </main>
    </div>
@endsection
