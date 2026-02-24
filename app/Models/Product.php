<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'image2',
        'image3',
        'category',
        'brand', // Add brand to fillable
        'size',
        'stock',
    ];

    /**
     * Get the product image URL.
     */
    public function getImageAttribute($value): string
    {
        $value = trim($value);
        if (!$value) {
            return 'https://placehold.co/600x800/f3f4f6/000000?text=GEORYTHM';
        }

        if (str_starts_with($value, 'http')) {
            return $value;
        }

        $path = public_path('products/' . $value);
        if (file_exists($path) && !is_dir($path)) {
            return asset('products/' . $value);
        }

        return 'https://placehold.co/600x800/f3f4f6/000000?text=IMAGE+NOT+FOUND';
    }

    /**
     * Get the product image 2 URL.
     */
    public function getImage2Attribute($value): ?string
    {
        $value = trim($value);
        if (!$value)
            return null;

        if (str_starts_with($value, 'http')) {
            return $value;
        }

        $path = public_path('products/' . $value);
        if (file_exists($path) && !is_dir($path)) {
            return asset('products/' . $value);
        }

        return 'https://placehold.co/600x800/f3f4f6/000000?text=IMAGE+2+NOT+FOUND';
    }

    /**
     * Get the product image 3 URL.
     */
    public function getImage3Attribute($value): ?string
    {
        $value = trim($value);
        if (!$value)
            return null;

        if (str_starts_with($value, 'http')) {
            return $value;
        }

        $path = public_path('products/' . $value);
        if (file_exists($path) && !is_dir($path)) {
            return asset('products/' . $value);
        }

        return 'https://placehold.co/600x800/f3f4f6/000000?text=IMAGE+3+NOT+FOUND';
    }

    /**
     * Map 'brand' attribute to 'category' column.
     */
    public function getBrandAttribute(): ?string
    {
        return $this->category;
    }

    public function setBrandAttribute($value): void
    {
        $this->category = $value;
    }

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the stock logs for the product.
     */
    public function stockLogs(): HasMany
    {
        return $this->hasMany(ProductStockLog::class);
    }

    /**
     * Get formatted price in Rupiah.
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'RP' . number_format($this->price, 0, ',', '.');
    }
}
