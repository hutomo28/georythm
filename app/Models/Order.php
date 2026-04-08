<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'shipping_name',
        'shipping_phone',
        'order_number',
        'status',
        'cancellation_reason',
        'total',
        'shipping_address',
        'shipping_apartment',
        'shipping_city',
        'shipping_province',
        'shipping_zip',
        'receipt_number',
        'delivery_service',
        'shipping_cost',
        'arrived_at',
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'arrived_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Get formatted total in Rupiah.
     */
    public function getFormattedTotalAttribute(): string
    {
        return 'Rp'.number_format((float)$this->total, 0, ',', '.');
    }

    /**
     * Get human-readable status label.
     */
    /**
     * Get human-readable status label.
     */
    public function getStatusLabelAttribute(): string
    {
        $lang = app()->getLocale(); // Use app locale instead of direct session

        $labels = [
            'en' => [
                'waiting-payment' => 'Waiting Payment',
                'processing' => 'Processing',
                'shipped' => 'Shipped',
                'arrived' => 'Arrived',
                'completed' => 'Completed',
                'cancelled' => 'Cancelled',
            ],
            'id' => [
                'waiting-payment' => 'Menunggu Pembayaran',
                'processing' => 'Sedang Dikemas',
                'shipped' => 'Sedang Dikirim',
                'arrived' => 'Pesanan Tiba',
                'completed' => 'Selesai',
                'cancelled' => 'Dibatalkan',
            ],
        ];

        return $labels[$lang][$this->status] ?? $this->status;
    }

    /**
     * Get the tracking link for the shipping service.
     */
    public function getTrackingLinkAttribute(): string
    {
        if (! $this->receipt_number) {
            return '#';
        }

        // Use CekResi.com as the unified tracking aggregator for all couriers
        // It automatically detects JNE, J&T, SiCepat, Anteraja, etc.
        return 'https://cekresi.com/?noresi='.$this->receipt_number;
    }

    public function getRemainingCompleteTimeSecondsAttribute(): int
    {
        if (!$this->arrived_at) return 0;
        
        $expiry = $this->arrived_at->copy()->addHours(48);
        $remaining = now()->diffInSeconds($expiry, false);
        
        return $remaining > 0 ? (int)$remaining : 0;
    }
}
