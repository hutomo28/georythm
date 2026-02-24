<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductStockLog extends Model
{
    protected $fillable = [
        'product_id',
        'amount',
        'type',
        'description',
    ];

    /**
     * Get the product associated with the stock log.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
