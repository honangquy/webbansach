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
            
        // Get latest books
        $latestBooks = \App\Models\Book::where('status', true)
            ->orderBy('created_at', 'desc')
            ->with('category')
            ->limit(8)
            ->get();
            
        // Get all categories
        $categories = \App\Models\Category::withCount('books')->get();
        
        return view('frontend.home', compact('featuredBooks', 'latestBooks', 'categories'));
    }
}
