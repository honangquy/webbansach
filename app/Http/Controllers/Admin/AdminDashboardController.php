<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Order;
use App\Models\User;
use App\Models\Category;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Get basic statistics
        $totalBooks = Book::count();
        $totalOrders = Order::count();
        $totalUsers = User::where('role', '!=', 'admin')->count();
        $totalCategories = Category::count();
        
        // Get recent orders
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Get sales data for chart
        $salesData = Order::selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->where('status', 'completed')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalBooks',
            'totalOrders', 
            'totalUsers',
            'totalCategories',
            'recentOrders',
            'salesData'
        ));
    }
}
