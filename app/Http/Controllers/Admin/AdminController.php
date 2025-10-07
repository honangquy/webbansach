<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function dashboard()
    {
        // Get statistics for dashboard
        $totalBooks = \App\Models\Book::count();
        $totalCategories = \App\Models\Category::count();
        $totalOrders = \App\Models\Order::count();
    $totalCustomers = \App\Models\User::whereIn('role', ['customer', 'staff'])->count();
        
        $recentOrders = \App\Models\Order::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        $lowStockBooks = \App\Models\Book::where('stock_quantity', '<=', 5)
            ->where('status', true)
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalBooks', 
            'totalCategories', 
            'totalOrders', 
            'totalCustomers',
            'recentOrders',
            'lowStockBooks'
        ));
    }
}
