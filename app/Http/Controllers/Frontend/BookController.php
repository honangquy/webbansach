<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('category');
        
        // Search by title, author, or description
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }
        
        // Filter by price range
        if ($request->has('min_price') && $request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }
        
        if ($request->has('max_price') && $request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }
        
        // Filter by availability
        if ($request->has('in_stock') && $request->in_stock) {
            $query->where('stock_quantity', '>', 0);
        }
        
        // Sort options
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name_az':
                $query->orderBy('title', 'asc');
                break;
            case 'name_za':
                $query->orderBy('title', 'desc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        $books = $query->paginate(12)->withQueryString();
        $categories = Category::all();
        
        // Get price range for filter
        $minPrice = Book::min('price');
        $maxPrice = Book::max('price');
        
        // Get active flash sale items for price override
        $flashSaleItems = \App\Models\FlashSaleItem::whereHas('flashSale', function($query) {
            $query->active();
        })
        ->whereColumn('sold_quantity', '<', 'stock_quantity')
        ->pluck('flash_price', 'book_id');
        
        return view('frontend.books.index', compact('books', 'categories', 'minPrice', 'maxPrice', 'flashSaleItems'));
    }
    
    public function show($id)
    {
        $book = Book::with('category')->findOrFail($id);
        $relatedBooks = Book::where('category_id', $book->category_id)
                           ->where('id', '!=', $id)
                           ->take(4)
                           ->get();
        
        // Check if book is in active flash sale
        $flashSaleItem = \App\Models\FlashSaleItem::whereHas('flashSale', function($query) {
            $query->active();
        })
        ->where('book_id', $id)
        ->whereColumn('sold_quantity', '<', 'stock_quantity')
        ->first();
        
        return view('frontend.books.show', compact('book', 'relatedBooks', 'flashSaleItem'));
    }
}
