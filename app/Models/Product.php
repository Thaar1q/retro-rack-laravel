<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'slug', 'description',
        'year', 'price', 'condition', 'stock', 'image', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'integer',
    ];

    // Human-readable condition labels for display in views
    public const CONDITION_LABELS = [
        'mint'       => 'MINT',
        'sangat_baik' => 'SANGAT BAIK',
        'baik'       => 'BAIK',
        'cukup'      => 'CUKUP',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /** Returns the formatted condition label for display. */
    public function conditionLabel(): string
    {
        return self::CONDITION_LABELS[$this->condition] ?? $this->condition;
    }

    /** Returns the public URL for the product image (with fallback). */
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
