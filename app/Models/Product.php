<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

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
        if (! $value) {
            return 'https://placehold.co/600x800/f3f4f6/000000?text=GEORYTHM';
        }

        if (str_starts_with($value, 'http')) {
            return $value;
        }

        $path = public_path('products/'.$value);
        if (file_exists($path) && ! is_dir($path)) {
            return asset('products/'.$value);
        }

        return 'https://placehold.co/600x800/f3f4f6/000000?text=IMAGE+NOT+FOUND';
    }

    /**
     * Get the product image 2 URL.
     */
    public function getImage2Attribute($value): ?string
    {
        $value = trim($value);
        if (! $value) {
            return null;
        }

        if (str_starts_with($value, 'http')) {
            return $value;
        }

        $path = public_path('products/'.$value);
        if (file_exists($path) && ! is_dir($path)) {
            return asset('products/'.$value);
        }

        return 'https://placehold.co/600x800/f3f4f6/000000?text=IMAGE+2+NOT+FOUND';
    }

    /**
     * Get the product image 3 URL.
     */
    public function getImage3Attribute($value): ?string
    {
        $value = trim($value);
        if (! $value) {
            return null;
        }

        if (str_starts_with($value, 'http')) {
            return $value;
        }

        $path = public_path('products/'.$value);
        if (file_exists($path) && ! is_dir($path)) {
            return asset('products/'.$value);
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

    /**
     * Get the formatted price.
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Get the reviews for the product.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the average rating of the product.
     */
    public function averageRating(): float
    {
        return (float) ($this->reviews()->avg('rating') ?? 0);
    }

    /**
     * Get the total review count of the product.
     */
    public function reviewsCount(): int
    {
        return $this->reviews()->count();
    }
    /**
     * Get the sizes and their stock.
     */
    public function sizes(): HasMany
    {
        return $this->hasMany(ProductSize::class);
    }

    /**
     * Calculate total stock from sizes if available, otherwise just return the base stock.
     */
    public function getStockAttribute($value): int
    {
        // If the product has specialized size stock, sum it up.
        // If not, fall back to the original stock logic (e.g. legacy products)
        if ($this->sizes()->count() > 0) {
            return $this->sizes()->sum('stock');
        }
        
        return (int) $value;
    }
}
