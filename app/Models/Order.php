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
        'total',
        'shipping_address',
        'shipping_apartment',
        'shipping_city',
        'shipping_province',
        'shipping_zip',
        'receipt_number',
        'delivery_service',
        'shipping_cost',
    ];

    protected $casts = [
        'total' => 'decimal:2',
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
        return 'Rp' . number_format($this->total, 0, ',', '.');
    }

    /**
     * Get human-readable status label.
     */
    /**
     * Get human-readable status label.
     */
    public function getStatusLabelAttribute(): string
    {
        $lang = session('locale', 'en'); // Default to English if no choice

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
            ]
        ];

        return $labels[$lang][$this->status] ?? $this->status;
    }

    /**
     * Get the tracking link for the shipping service.
     */
    public function getTrackingLinkAttribute(): string
    {
        if (!$this->receipt_number || !$this->delivery_service) {
            return '#';
        }

        return match (strtoupper($this->delivery_service)) {
                'JNE' => 'https://jne.co.id/tracking-package',
                'JNT' => 'https://jet.co.id/track',
                'ANTERAJA' => 'https://anteraja.id/id/tracking/' . $this->receipt_number,
                default => '#',
            };
    }
}
