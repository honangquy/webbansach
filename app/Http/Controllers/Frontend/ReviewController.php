<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Order;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a new review for a purchased book.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'book_id' => 'required|exists:books,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000'
        ]);

        $user = Auth::user();

        // Verify order belongs to user
        $order = Order::where('id', $data['order_id'])->where(function($q) use ($user) {
            $q->where('user_id', $user->id)->orWhere('customer_email', $user->email);
        })->first();

        if (!$order) {
            return back()->withErrors(['error' => 'Đơn hàng không tồn tại hoặc không thuộc về bạn.']);
        }

        // Verify the order contains the book
        $hasBook = $order->orderDetails()->where('book_id', $data['book_id'])->exists();

        if (!$hasBook) {
            return back()->withErrors(['error' => 'Sản phẩm không được tìm thấy trong đơn hàng này.']);
        }

        // Prevent duplicate reviews for same order+book by same user
        $existing = Review::where('user_id', $user->id)
            ->where('order_id', $order->id)
            ->where('book_id', $data['book_id'])
            ->first();

        if ($existing) {
            return back()->with('status', 'Bạn đã đánh giá sản phẩm này cho đơn hàng này.');
        }

        // Create review
        $review = Review::create([
            'user_id' => $user->id,
            'order_id' => $order->id,
            'book_id' => $data['book_id'],
            'rating' => $data['rating'],
            'comment' => $data['comment'] ?? null,
            'approved' => true
        ]);

        return back()->with('status', 'Cảm ơn bạn đã đánh giá sản phẩm!');
    }
}
