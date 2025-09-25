<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name', 
        'description',
        'type',
        'value',
        'minimum_order_amount',
        'maximum_discount',
        'usage_limit',
        'usage_limit_per_user',
        'used_count',
        'starts_at',
        'expires_at',
        'is_active'
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'value' => 'decimal:2',
        'minimum_order_amount' => 'decimal:2',
        'maximum_discount' => 'decimal:2'
    ];

    // Kiểm tra coupon có hợp lệ không
    public function isValid($orderAmount = 0)
    {
        // Kiểm tra trạng thái
        if (!$this->is_active) {
            return false;
        }

        // Kiểm tra thời gian
        $now = Carbon::now();
        if ($now < $this->starts_at || $now > $this->expires_at) {
            return false;
        }

        // Kiểm tra số lần sử dụng
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        // Kiểm tra giá trị đơn hàng tối thiểu
        if ($this->minimum_order_amount && $orderAmount < $this->minimum_order_amount) {
            return false;
        }

        return true;
    }

    // Tính toán số tiền giảm
    public function calculateDiscount($orderAmount)
    {
        if (!$this->isValid($orderAmount)) {
            return 0;
        }

        if ($this->type === 'percentage') {
            $discount = ($orderAmount * $this->value) / 100;
            
            // Áp dụng giảm tối đa nếu có
            if ($this->maximum_discount && $discount > $this->maximum_discount) {
                $discount = $this->maximum_discount;
            }
            
            return $discount;
        } else {
            // Fixed amount
            return min($this->value, $orderAmount);
        }
    }

    // Đánh dấu đã sử dụng
    public function markAsUsed()
    {
        $this->increment('used_count');
    }

    // Scope cho coupon đang hoạt động
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where('starts_at', '<=', Carbon::now())
                    ->where('expires_at', '>=', Carbon::now());
    }

    // Scope cho coupon còn lượt sử dụng
    public function scopeAvailable($query)
    {
        return $query->where(function($q) {
            $q->whereNull('usage_limit')
              ->orWhereRaw('used_count < usage_limit');
        });
    }

    // Helper methods để kiểm tra trạng thái
    public function isExpired()
    {
        return Carbon::now() > $this->expires_at;
    }

    public function isUsageLimitReached()
    {
        return $this->usage_limit && $this->used_count >= $this->usage_limit;
    }

    public function isNotStarted()
    {
        return Carbon::now() < $this->starts_at;
    }
}
