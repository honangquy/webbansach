<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'total_amount',
        'coupon_code',
        'discount_amount',
        'final_amount',
        'status',
        'payment_method',
        'payment_status',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'notes',
        'order_date',
        'cancel_reason',
        'cancelled_at',
        'admin_note'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'final_amount' => 'decimal:2',
        'order_date' => 'datetime',
        'cancelled_at' => 'datetime'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    // Generate unique order number
    public static function generateOrderNumber()
    {
        return 'ORD-' . date('Ymd') . '-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
    }

    // Status scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    public function scopeShipped($query)
    {
        return $query->where('status', 'shipped');
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', '%' . $search . '%')
                               ->orWhere('email', 'like', '%' . $search . '%');
                  });
            });
        }
        
        return $query;
    }

    public function scopeByStatus($query, $status)
    {
        if ($status) {
            return $query->where('status', $status);
        }
        
        return $query;
    }

    public function scopeByDateRange($query, $dateFrom, $dateTo)
    {
        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }
        
        return $query;
    }

    // Get status text for display
    public function getStatusTextAttribute()
    {
        $statusTexts = [
            'pending' => 'Chờ xử lý',
            'processing' => 'Đang xử lý', 
            'shipped' => 'Đang giao',
            'delivered' => 'Đã giao',
            'cancelled' => 'Đã hủy'
        ];

        return $statusTexts[$this->status] ?? 'Không xác định';
    }

    // Get shipping information attributes
    public function getShippingNameAttribute()
    {
        return $this->customer_name;
    }

    public function getShippingPhoneAttribute() 
    {
        return $this->customer_phone;
    }

    public function getShippingAddressAttribute()
    {
        return $this->attributes['shipping_address'];
    }

    // Check if order can be cancelled
    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'processing']);
    }

    // Check if order can be edited
    public function canBeEdited()
    {
        return $this->status === 'pending';
    }

    // Calculate subtotal from order details
    public function getSubtotalAttribute()
    {
        return $this->orderDetails->sum('total');
    }

    // Get shipping fee (currently 0, can be customized)
    public function getShippingFeeAttribute()
    {
        return 0; // Free shipping for now
    }

    // Get actual total amount (for compatibility)
    public function getTotalAmountDisplayAttribute()
    {
        return $this->final_amount ?? $this->total_amount;
    }
}
