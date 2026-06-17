@props(['article'])

<div class="article-card">
    @if($article->image)
        <img src="{{ $article->imageUrl() }}" alt="{{ $article->title }}" class="article-img">
    @else
        <div class="article-img"></div>
    @endif
    <span class="article-tag">REVIEW</span>
    <h3 class="article-title">{{ $article->title }}</h3>
    <p class="article-desc">{{ Str::limit(strip_tags($article->body), 100) }}</p>
    <div class="article-footer">
        <span class="article-date">{{ $article->published_at ? $article->published_at->diffForHumans() : $article->created_at->format('M d, Y') }}</span>
        <a href="{{ route('detail.artikel', $article) }}" class="article-link">Baca Selengkapnya &rarr;</a>
    </div>
</div>
