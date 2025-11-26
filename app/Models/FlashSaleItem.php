<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashSaleItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'flash_sale_id',
        'book_id',
        'flash_price',
        'stock_quantity',
        'sold_quantity'
    ];

    protected $casts = [
        'flash_price' => 'decimal:2'
    ];

    // Relationships
    public function flashSale()
    {
        return $this->belongsTo(FlashSale::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Helper methods
    public function getDiscountPercentAttribute()
    {
        if ($this->book && $this->book->price > 0) {
            return round((($this->book->price - $this->flash_price) / $this->book->price) * 100);
        }
        return 0;
    }

    public function hasStock()
    {
        return $this->stock_quantity > $this->sold_quantity;
    }

    public function getRemainingStockAttribute()
    {
        return max(0, $this->stock_quantity - $this->sold_quantity);
    }
}
