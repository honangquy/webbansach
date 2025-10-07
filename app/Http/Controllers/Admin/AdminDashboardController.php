<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Get statistics for dashboard
        $totalBooks = Book::count();
        $totalCategories = \App\Models\Category::count();
        $totalOrders = \App\Models\Order::count();
    // Count customers and staff so promoted users are included
    $totalCustomers = \App\Models\User::whereIn('role', ['customer', 'staff'])->count();
        
        $recentOrders = \App\Models\Order::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        $lowStockBooks = Book::where('stock_quantity', '<=', 5)
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
