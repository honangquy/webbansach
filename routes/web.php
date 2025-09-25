<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Frontend Routes
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Test route
Route::get('/test-admin-books', function() {
    return 'Test route works!';
});

// Quick admin login route for testing
Route::get('/admin-login', function() {
    $user = App\Models\User::where('email', 'admin@webbansach.com')->first();
    if ($user) {
        Auth::login($user);
        return redirect()->route('admin.books.index')->with('success', 'Logged in as admin');
    }
    return 'Admin user not found';
});

// Books Routes for customers
Route::get('/books', [App\Http\Controllers\Frontend\BookController::class, 'index'])->name('books.index');
Route::get('/books/{id}', [App\Http\Controllers\Frontend\BookController::class, 'show'])->name('books.show');

// Cart Routes
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [App\Http\Controllers\Frontend\CartController::class, 'index'])->name('index');
    Route::post('/add', [App\Http\Controllers\Frontend\CartController::class, 'add'])->name('add');
    Route::post('/update', [App\Http\Controllers\Frontend\CartController::class, 'update'])->name('update');
    Route::post('/remove', [App\Http\Controllers\Frontend\CartController::class, 'remove'])->name('remove');
    Route::post('/clear', [App\Http\Controllers\Frontend\CartController::class, 'clear'])->name('clear');
    Route::get('/count', [App\Http\Controllers\Frontend\CartController::class, 'count'])->name('count');
});

// Order Routes (require authentication)
Route::prefix('orders')->name('orders.')->middleware('auth')->group(function () {
    Route::get('/checkout', [App\Http\Controllers\Frontend\OrderController::class, 'checkout'])->name('checkout');
    Route::post('/store', [App\Http\Controllers\Frontend\OrderController::class, 'store'])->name('store');
    Route::get('/success/{order}', [App\Http\Controllers\Frontend\OrderController::class, 'success'])->name('success');
    Route::get('/', [App\Http\Controllers\Frontend\OrderController::class, 'index'])->name('index');
    Route::get('/{order}', [App\Http\Controllers\Frontend\OrderController::class, 'show'])->name('show');
    Route::post('/{order}/cancel', [App\Http\Controllers\Frontend\OrderController::class, 'cancel'])->name('cancel');
    Route::post('/{order}/reorder', [App\Http\Controllers\Frontend\OrderController::class, 'reorder'])->name('reorder');
});

// Coupon Routes
Route::prefix('coupon')->name('coupon.')->group(function () {
    Route::post('/apply', [App\Http\Controllers\Frontend\CouponController::class, 'apply'])->name('apply');
    Route::post('/remove', [App\Http\Controllers\Frontend\CouponController::class, 'remove'])->name('remove');
    Route::post('/check', [App\Http\Controllers\Frontend\CouponController::class, 'check'])->name('check');
});

// Profile Routes (require authentication)
Route::prefix('profile')->name('profile.')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\Frontend\ProfileController::class, 'index'])->name('index');
    Route::get('/edit', [App\Http\Controllers\Frontend\ProfileController::class, 'edit'])->name('edit');
    Route::put('/update', [App\Http\Controllers\Frontend\ProfileController::class, 'update'])->name('update');
    Route::get('/change-password', [App\Http\Controllers\Frontend\ProfileController::class, 'changePasswordForm'])->name('change-password');
    Route::put('/change-password', [App\Http\Controllers\Frontend\ProfileController::class, 'changePassword'])->name('change-password.update');
    Route::get('/addresses', [App\Http\Controllers\Frontend\ProfileController::class, 'addresses'])->name('addresses');
});

// Authentication Routes
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Test route without middleware
Route::any('/test-update-status/{order}', function($order) {
    \Log::info('Test route called with order: ' . $order);
    return response()->json(['success' => true, 'message' => 'Test update status works', 'order' => $order]);
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Test route WITHOUT middleware
    Route::get('/test', function() {
        return 'Admin test route works! Current time: ' . now();
    });
    
    Route::get('/dashboard-test', function() {
        return view('admin.dashboard', [
            'totalBooks' => 10,
            'totalCategories' => 5,
            'totalOrders' => 8,
            'totalCustomers' => 15,
            'recentOrders' => collect([]),
            'lowStockBooks' => collect([])
        ]);
    });
    
    // Test simple view without layout
    Route::get('/simple-test', function() {
        return '<h1>Simple HTML Test</h1><p>If you see this, PHP works!</p>';
    });
    
    // Test view with simple layout
    Route::get('/layout-test', function() {
        return view('admin.test-simple');
    });
    
    // Test categories without middleware
    Route::get('/categories-test', function() {
        try {
            $categories = \App\Models\Category::withCount('books')->take(5)->get();
            return "Categories found: " . $categories->count() . " items";
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    });
    
    // Test categories view - Simple version
    Route::get('/categories-view-test', function() {
        try {
            $categories = \App\Models\Category::withCount('books')->take(5)->get();
            
            // Test 1: Basic data return
            if (request()->has('data')) {
                return $categories->toArray();
            }
            
            // Test 2: Simple HTML without layout
            if (request()->has('simple')) {
                $html = '<h1>Categories Test</h1><ul>';
                foreach ($categories as $category) {
                    $html .= '<li>' . $category->name . ' (' . $category->books_count . ' books)</li>';
                }
                $html .= '</ul>';
                return $html;
            }
            
            // Test 3: Check if view file exists
            if (request()->has('check')) {
                $viewPath = resource_path('views/admin/categories/index.blade.php');
                $layoutPath = resource_path('views/layouts/admin.blade.php');
                return [
                    'view_exists' => file_exists($viewPath),
                    'layout_exists' => file_exists($layoutPath),
                    'view_path' => $viewPath,
                    'layout_path' => $layoutPath
                ];
            }
            
            // Test 4: Simple view without complex layout
            if (request()->has('test')) {
                return view('admin.categories.test-simple', compact('categories'));
            }
            
            // Test 5: Simple layout view
            if (request()->has('layout')) {
                return view('admin.categories.index-simple', compact('categories'));
            }
            
            // Test 6: Original view rendering
            return view('admin.categories.index', compact('categories'));
        } catch (\Exception $e) {
            return "View Error: " . $e->getMessage() . "\nStack Trace:\n" . $e->getTraceAsString();
        }
    });
    
    // Test login admin user
    Route::get('/login-admin', function() {
        $admin = \App\Models\User::where('email', 'admin@webbansach.com')->first();
        if ($admin) {
            auth()->login($admin);
            return "Logged in as admin! Now try <a href='/webbansach/laravel-app/public/admin/dashboard'>dashboard</a>";
        }
        return "Admin user not found!";
    });
    
    // Test admin pages
    Route::get('/test-books', function() {
        try {
            $books = \App\Models\Book::with('category')->take(5)->get();
            return view('admin.books.index', compact('books'));
        } catch (\Exception $e) {
            return "Books Error: " . $e->getMessage();
        }
    });
    
    Route::get('/test-orders', function() {
        try {
            $orders = \App\Models\Order::with('user')->take(5)->get();
            return view('admin.orders.index', compact('orders'));
        } catch (\Exception $e) {
            return "Orders Error: " . $e->getMessage();
        }
    });
    
    Route::get('/test-customers', function() {
        try {
            $customers = \App\Models\User::where('role', '!=', 'admin')->take(5)->get();
            return view('admin.customers.index', compact('customers'));
        } catch (\Exception $e) {
            return "Customers Error: " . $e->getMessage();
        }
    });
});

// Admin Routes with middleware
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');
    
    // Test route
    Route::any('/test-route', function() {
        return response()->json([
            'success' => true, 
            'message' => 'Test route works',
            'user' => auth()->user() ? auth()->user()->toArray() : null,
            'is_admin' => auth()->user() ? auth()->user()->isAdmin() : false
        ]);
    })->name('test.route');
    
    // Books management routes
    Route::resource('books', App\Http\Controllers\Admin\BookController::class);
    
    // Categories management routes
    Route::resource('categories', App\Http\Controllers\Admin\AdminCategoryController::class);
    
    // Customers management routes
    Route::resource('customers', App\Http\Controllers\Admin\CustomerController::class);
    Route::get('/customers/stats', [App\Http\Controllers\Admin\CustomerController::class, 'getStats'])->name('customers.stats');
    
    // Orders management routes
    Route::get('/orders', [App\Http\Controllers\Admin\AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [App\Http\Controllers\Admin\AdminOrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/print', [App\Http\Controllers\Admin\AdminOrderController::class, 'print'])->name('orders.print');
    Route::post('/orders/{order}/update-status', [App\Http\Controllers\Admin\AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::post('/orders/bulk-update', [App\Http\Controllers\Admin\AdminOrderController::class, 'bulkUpdateStatus'])->name('orders.bulk-update');
    Route::get('/orders/export', [App\Http\Controllers\Admin\AdminOrderController::class, 'export'])->name('orders.export');
    Route::get('/orders/stats', [App\Http\Controllers\Admin\AdminOrderController::class, 'getStats'])->name('orders.stats');
    
    // Coupons management routes
    Route::resource('coupons', App\Http\Controllers\Admin\AdminCouponController::class);
    
    // Statistics routes
    Route::prefix('statistics')->name('statistics.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\AdminStatisticsController::class, 'index'])->name('index');
        Route::get('/sales', [App\Http\Controllers\Admin\AdminStatisticsController::class, 'sales'])->name('sales');
        Route::get('/customers', [App\Http\Controllers\Admin\AdminStatisticsController::class, 'customers'])->name('customers');
        Route::get('/products', [App\Http\Controllers\Admin\AdminStatisticsController::class, 'products'])->name('products');
        Route::get('/chart-data', [App\Http\Controllers\Admin\AdminStatisticsController::class, 'getChartData'])->name('chart-data');
    });
});
