<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'slug', 'tag', 'excerpt',
        'body', 'image', 'is_published', 'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function imageUrl(): string
    {
        if (!$this->image) {
            return asset('images/placeholder.jpg');
        }
        
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        
        // If image exists in public/images, use it (for seeded images tracked in Git)
        if (file_exists(public_path('images/' . $this->image))) {
            return asset('images/' . $this->image);
        }
        
        // Fallback to storage for newly uploaded images
        return asset('storage/' . $this->image);
    }
}
