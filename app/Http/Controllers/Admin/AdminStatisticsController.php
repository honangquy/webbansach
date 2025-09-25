<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Book;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminStatisticsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request)
    {
        $period = $request->get('period', '30'); // 7, 30, 90, 365 days
        $startDate = Carbon::now()->subDays($period);
        
        // General Statistics
        $stats = [
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', 'delivered')->sum('final_amount') ?? 0,
            'total_customers' => User::where('role', 'customer')->count(),
            'total_books' => Book::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'low_stock_books' => Book::where('stock_quantity', '<=', 5)->where('status', true)->count(),
        ];
        
        // Revenue by period
        $revenueData = Order::where('status', 'delivered')
            ->where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, SUM(final_amount) as revenue')
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();
            
        // If no revenue data, create dummy data for chart
        if ($revenueData->isEmpty()) {
            $revenueData = collect([
                (object)['date' => Carbon::now()->subDays(6)->format('Y-m-d'), 'revenue' => 0],
                (object)['date' => Carbon::now()->subDays(5)->format('Y-m-d'), 'revenue' => 0],
                (object)['date' => Carbon::now()->subDays(4)->format('Y-m-d'), 'revenue' => 0],
                (object)['date' => Carbon::now()->subDays(3)->format('Y-m-d'), 'revenue' => 0],
                (object)['date' => Carbon::now()->subDays(2)->format('Y-m-d'), 'revenue' => 0],
                (object)['date' => Carbon::now()->subDays(1)->format('Y-m-d'), 'revenue' => 0],
                (object)['date' => Carbon::now()->format('Y-m-d'), 'revenue' => 0],
            ]);
        }
            
        // Orders by status
        $ordersByStatus = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');
            
        // If no orders, create default status data
        if ($ordersByStatus->isEmpty()) {
            $ordersByStatus = collect([
                'pending' => 0,
                'processing' => 0,
                'shipped' => 0,
                'delivered' => 0,
                'cancelled' => 0
            ]);
        }
            
        // Top selling books
        $topBooks = OrderDetail::select('book_id', DB::raw('SUM(quantity) as total_sold'))
            ->with('book')
            ->groupBy('book_id')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();
            
        // If no top books, get recent books
        if ($topBooks->isEmpty()) {
            $topBooks = Book::select('id as book_id')
                ->with('book')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get()
                ->map(function($book) {
                    $book->total_sold = 0;
                    $book->book = $book; // For compatibility
                    return $book;
                });
        }
            
        // Recent customers
        $recentCustomers = User::where('role', 'customer')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            
        // Categories performance
        $categoriesStats = Category::withCount(['books' => function($query) {
                $query->where('status', true);
            }])
            ->with(['books' => function($query) {
                $query->select('category_id', DB::raw('SUM(stock_quantity) as total_stock'))
                    ->groupBy('category_id');
            }])
            ->get();

        return view('admin.statistics.index', compact(
            'stats', 
            'revenueData', 
            'ordersByStatus', 
            'topBooks', 
            'recentCustomers', 
            'categoriesStats',
            'period'
        ));
    }
    
    public function sales(Request $request)
    {
        $period = $request->get('period', '30');
        $startDate = Carbon::now()->subDays($period);
        
        // Sales by month
        $salesByMonth = Order::where('status', 'delivered')
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(final_amount) as revenue, COUNT(*) as orders')
            ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
            ->orderBy('year')
            ->orderBy('month')
            ->get();
            
        // Payment methods stats
        $paymentMethods = Order::where('status', 'delivered')
            ->selectRaw('payment_method, COUNT(*) as count, SUM(final_amount) as revenue')
            ->groupBy('payment_method')
            ->get();
            
        // Daily sales in period
        $dailySales = Order::where('status', 'delivered')
            ->where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as orders, SUM(final_amount) as revenue')
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();
            
        return view('admin.statistics.sales', compact(
            'salesByMonth',
            'paymentMethods', 
            'dailySales',
            'period'
        ));
    }
    
    public function customers(Request $request)
    {
        // Customer registration trends
        $customerRegistrations = User::where('role', 'customer')
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
            ->orderBy('year')
            ->orderBy('month')
            ->get();
            
        // Top customers by orders
        $topCustomers = User::where('role', 'customer')
            ->withCount('orders')
            ->with(['orders' => function($query) {
                $query->where('status', 'delivered')
                    ->selectRaw('user_id, SUM(final_amount) as total_spent')
                    ->groupBy('user_id');
            }])
            ->orderBy('orders_count', 'desc')
            ->limit(20)
            ->get();
            
        // Customer activity stats
        $customerStats = [
            'active_customers' => User::where('role', 'customer')
                ->whereHas('orders', function($query) {
                    $query->where('created_at', '>=', Carbon::now()->subMonths(3));
                })->count(),
            'new_customers_this_month' => User::where('role', 'customer')
                ->where('created_at', '>=', Carbon::now()->startOfMonth())
                ->count(),
            'customers_with_orders' => User::where('role', 'customer')
                ->whereHas('orders')->count(),
        ];
        
        return view('admin.statistics.customers', compact(
            'customerRegistrations',
            'topCustomers',
            'customerStats'
        ));
    }
    
    public function products(Request $request)
    {
        $sort = $request->get('sort', 'sold');
        
        // Product performance - Simple approach
        if ($sort == 'sold') {
            $products = Book::leftJoin('order_details', 'books.id', '=', 'order_details.book_id')
                ->select('books.*', DB::raw('COALESCE(SUM(order_details.quantity), 0) as total_sold'), 
                         DB::raw('COALESCE(SUM(order_details.total), 0) as total_revenue'))
                ->with('category')
                ->groupBy('books.id', 'books.title', 'books.author', 'books.price', 'books.stock_quantity', 
                         'books.created_at', 'books.updated_at', 'books.description', 'books.image', 
                         'books.category_id', 'books.status', 'books.sale_price')
                ->orderByDesc('total_sold');
        } elseif ($sort == 'revenue') {
            $products = Book::leftJoin('order_details', 'books.id', '=', 'order_details.book_id')
                ->select('books.*', DB::raw('COALESCE(SUM(order_details.quantity), 0) as total_sold'), 
                         DB::raw('COALESCE(SUM(order_details.total), 0) as total_revenue'))
                ->with('category')
                ->groupBy('books.id', 'books.title', 'books.author', 'books.price', 'books.stock_quantity', 
                         'books.created_at', 'books.updated_at', 'books.description', 'books.image', 
                         'books.category_id', 'books.status', 'books.sale_price')
                ->orderByDesc('total_revenue');
        } elseif ($sort == 'stock') {
            $products = Book::select('books.*', DB::raw('0 as total_sold'), DB::raw('0 as total_revenue'))
                ->with('category')
                ->orderBy('stock_quantity');
        } else {
            $products = Book::select('books.*', DB::raw('0 as total_sold'), DB::raw('0 as total_revenue'))
                ->with('category')
                ->orderBy('created_at', 'desc');
        }
        
        $products = $products->paginate(20);
        
        // Category performance - Simplified
        $categoryPerformance = Category::withCount(['books as books_count' => function($query) {
                $query->where('status', true);
            }])
            ->get()
            ->map(function($category) {
                $category->total_sold = OrderDetail::join('books', 'books.id', '=', 'order_details.book_id')
                    ->where('books.category_id', $category->id)
                    ->sum('order_details.quantity');
                $category->total_revenue = OrderDetail::join('books', 'books.id', '=', 'order_details.book_id')
                    ->where('books.category_id', $category->id)
                    ->sum('order_details.total');
                return $category;
            })
            ->sortByDesc('total_revenue');
            
        // Stock alerts
        $stockAlerts = [
            'out_of_stock' => Book::where('stock_quantity', 0)->where('status', true)->count(),
            'low_stock' => Book::where('stock_quantity', '>', 0)->where('stock_quantity', '<=', 5)->where('status', true)->count(),
            'total_stock_value' => Book::where('status', true)->sum(DB::raw('price * stock_quantity'))
        ];
        
        return view('admin.statistics.products', compact(
            'products',
            'categoryPerformance', 
            'stockAlerts',
            'sort'
        ));
    }
    
    public function getChartData(Request $request)
    {
        $type = $request->get('type');
        $period = $request->get('period', '30');
        
        switch($type) {
            case 'revenue':
                return $this->getRevenueChartData($period);
            case 'orders':
                return $this->getOrdersChartData($period);
            case 'customers':
                return $this->getCustomersChartData($period);
            default:
                return response()->json(['error' => 'Invalid chart type'], 400);
        }
    }
    
    private function getRevenueChartData($period)
    {
        $startDate = Carbon::now()->subDays($period);
        
        $data = Order::where('status', 'delivered')
            ->where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, SUM(final_amount) as revenue')
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();
            
        return response()->json([
            'labels' => $data->pluck('date'),
            'data' => $data->pluck('revenue')
        ]);
    }
    
    private function getOrdersChartData($period)
    {
        $startDate = Carbon::now()->subDays($period);
        
        $data = Order::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as orders')
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();
            
        return response()->json([
            'labels' => $data->pluck('date'),
            'data' => $data->pluck('orders')
        ]);
    }
    
    private function getCustomersChartData($period)
    {
        $startDate = Carbon::now()->subDays($period);
        
        $data = User::where('role', 'customer')
            ->where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as customers')
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();
            
        return response()->json([
            'labels' => $data->pluck('date'),
            'data' => $data->pluck('customers')
        ]);
    }
}