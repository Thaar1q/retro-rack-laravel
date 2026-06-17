<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'invoice_number', 'total_price', 'status',
        'recipient_name', 'recipient_phone', 'shipping_address',
        'shipping_city', 'postal_code', 'notes', 'payment_method', 'shipping_method'
    ];

    public const STATUS_LABELS = [
        'pending'   => 'Menunggu Pembayaran',
        'paid'      => 'Dibayar',
        'shipped'   => 'Dikirim',
        'completed' => 'Selesai',
        'cancelled' => 'Dibatalkan',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function statusLabel(): string
    {
        return self::STATUS_LABELS[$this->status] ?? $this->status;
    }
}
