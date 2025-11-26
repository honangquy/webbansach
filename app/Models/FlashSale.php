<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_time',
        'end_time',
        'status'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'status' => 'boolean'
    ];

    // Relationships
    public function items()
    {
        return $this->hasMany(FlashSaleItem::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        $now = now();
        return $query->where('status', true)
            ->where('start_time', '<=', $now)
            ->where('end_time', '>=', $now);
    }

    // Helper methods
    public function isActive()
    {
        $now = now();
        return $this->status && 
               $this->start_time <= $now && 
               $this->end_time >= $now;
    }

    public function hasStarted()
    {
        return $this->start_time <= now();
    }

    public function hasEnded()
    {
        return $this->end_time < now();
    }
}
