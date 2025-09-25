<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'date_of_birth',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
    ];

    // Relationships
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Check if user is admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Check if user is customer
    public function isCustomer()
    {
        return $this->role === 'customer';
    }

    // Scopes for admin customer management
    public function scopeCustomers($query)
    {
        return $query->where('role', 'customer');
    }

    public function scopeWithOrderStats($query)
    {
        return $query->withCount('orders')
                    ->withSum('orders', 'total_amount');
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }
        
        return $query;
    }

    // Get customer statistics
    public function getOrderStatsAttribute()
    {
        return [
            'total' => $this->orders()->count(),
            'pending' => $this->orders()->where('status', 'pending')->count(),
            'processing' => $this->orders()->where('status', 'processing')->count(),
            'completed' => $this->orders()->whereIn('status', ['delivered'])->count(),
            'cancelled' => $this->orders()->where('status', 'cancelled')->count(),
        ];
    }

    // Get recent orders for customer detail view
    public function getRecentOrdersAttribute()
    {
        return $this->orders()
                   ->with('orderDetails')
                   ->latest()
                   ->limit(10)
                   ->get();
    }
}
