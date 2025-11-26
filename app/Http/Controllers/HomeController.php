<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Remove auth middleware to allow guest access
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Get featured books for homepage
        $featuredBooks = \App\Models\Book::where('featured', true)
            ->where('status', true)
            ->with('category')
            ->limit(8)
            ->get();
            
        // Get latest books - 6 rows x 5 products = 30 books
        $latestBooks = \App\Models\Book::where('status', true)
            ->orderBy('created_at', 'desc')
            ->with('category')
            ->limit(30)
            ->get();
            
        // Get all categories
        $categories = \App\Models\Category::withCount('books')->get();
        
        // Get active banners: active=true and now between start_at and end_at if set
        $now = now();
        $banners = \App\Models\Banner::where('active', true)
            ->where(function($q) use ($now) {
                $q->whereNull('start_at')->orWhere('start_at', '<=', $now);
            })
            ->where(function($q) use ($now) {
                $q->whereNull('end_at')->orWhere('end_at', '>=', $now);
            })
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Get active flash sale
        $activeFlashSale = \App\Models\FlashSale::active()
            ->with(['items' => function($query) {
                $query->whereColumn('sold_quantity', '<', 'stock_quantity')
                    ->with(['book' => function($q) {
                        $q->where('status', true);
                    }]);
            }])
            ->first();
            
        // Get flash sale items for price display
        $flashSaleItems = collect();
        if($activeFlashSale) {
            $flashSaleItems = $activeFlashSale->items->pluck('flash_price', 'book_id');
        }

        return view('frontend.home', compact('featuredBooks', 'latestBooks', 'categories', 'banners', 'activeFlashSale', 'flashSaleItems'));
    }
}
