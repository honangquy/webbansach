<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'description',
        'price',
        'sale_price',
        'stock_quantity',
        'image',
        'isbn',
        'pages',
        'publisher',
        'publish_date',
        'category_id',
        'sold_quantity',
        'featured',
        'status'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'publish_date' => 'date',
        'featured' => 'boolean',
        'status' => 'boolean'
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeBestSelling($query)
    {
        return $query->orderBy('sold_quantity', 'desc');
    }

    /**
     * Return full URL for the book image. If the stored value is a full URL, return it.
     * Otherwise return the asset URL for the storage path.
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image) return null;

        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        return asset('storage/' . $this->image);
    }
}
