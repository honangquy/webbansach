<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        // Load giỏ hàng từ database nếu người dùng đã đăng nhập
        if (Auth::check()) {
            $this->loadCartFromDatabase();
        }
        
        $cart = session()->get('cart', []);
        $total = 0;
        $cartItems = [];
        
        foreach ($cart as $id => $details) {
            $book = Book::find($id);
            if ($book) {
                $price = $book->sale_price ?? $book->price;
                $cartItems[] = [
                    'book' => $book,
                    'quantity' => $details['quantity'],
                    'price' => $price,
                    'subtotal' => $price * $details['quantity']
                ];
                $total += $price * $details['quantity'];
            }
        }
        
        // Calculate coupon discount if applied
        $coupon = session('coupon');
        $discountAmount = 0;
        
        if ($coupon && $total >= ($coupon['minimum_order_amount'] ?? 0)) {
            if ($coupon['type'] === 'percentage') {
                $discountAmount = ($total * $coupon['value']) / 100;
            } else {
                $discountAmount = $coupon['value'];
            }
            
            // Update discount amount in session
            session(['coupon.discount_amount' => $discountAmount]);
        }
        
        return view('frontend.cart.index', compact('cartItems', 'total'));
    }
    
    public function add(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1'
        ]);
        
        $book = Book::findOrFail($request->book_id);
        
        // Check stock
        if ($book->stock_quantity < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Không đủ sách trong kho!'
            ]);
        }
        
        $cart = session()->get('cart', []);
        $bookId = $request->book_id;
        
        if (isset($cart[$bookId])) {
            // Check total quantity against stock
            $newQuantity = $cart[$bookId]['quantity'] + $request->quantity;
            if ($newQuantity > $book->stock_quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số lượng vượt quá tồn kho!'
                ]);
            }
            $cart[$bookId]['quantity'] = $newQuantity;
        } else {
            $cart[$bookId] = [
                'quantity' => $request->quantity,
                'added_at' => now()
            ];
        }
        
        session()->put('cart', $cart);
        
        // Lưu vào database nếu người dùng đã đăng nhập
        if (Auth::check()) {
            $this->saveCartToDatabase($bookId, $cart[$bookId]['quantity']);
        }
        
        // Calculate cart summary
        $cartCount = array_sum(array_column($cart, 'quantity'));
        
        return response()->json([
            'success' => true,
            'message' => 'Đã thêm sách vào giỏ hàng!',
            'cart_count' => $cartCount
        ]);
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1'
        ]);
        
        $book = Book::findOrFail($request->book_id);
        
        if ($book->stock_quantity < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Không đủ sách trong kho!'
            ]);
        }
        
        $cart = session()->get('cart', []);
        $bookId = $request->book_id;
        
        if (isset($cart[$bookId])) {
            $cart[$bookId]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            
            // Cập nhật database nếu người dùng đã đăng nhập
            if (Auth::check()) {
                $this->saveCartToDatabase($bookId, $request->quantity);
            }
            
            $cartCount = array_sum(array_column($cart, 'quantity'));
            $price = $book->sale_price ?? $book->price;
            $subtotal = $price * $request->quantity;
            
            // Calculate total
            $total = 0;
            foreach ($cart as $id => $details) {
                $cartBook = Book::find($id);
                if ($cartBook) {
                    $itemPrice = $cartBook->sale_price ?? $cartBook->price;
                    $total += $itemPrice * $details['quantity'];
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Đã cập nhật giỏ hàng!',
                'cart_count' => $cartCount,
                'subtotal' => number_format($subtotal) . 'đ',
                'total' => number_format($total) . 'đ'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Sách không có trong giỏ hàng!'
        ]);
    }
    
    public function remove(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id'
        ]);
        
        $cart = session()->get('cart', []);
        $bookId = $request->book_id;
        
        if (isset($cart[$bookId])) {
            unset($cart[$bookId]);
            session()->put('cart', $cart);
            
            // Xóa khỏi database nếu người dùng đã đăng nhập
            if (Auth::check()) {
                $this->removeFromDatabase($bookId);
            }
            
            $cartCount = array_sum(array_column($cart, 'quantity'));
            
            // Calculate total
            $total = 0;
            foreach ($cart as $id => $details) {
                $book = Book::find($id);
                if ($book) {
                    $price = $book->sale_price ?? $book->price;
                    $total += $price * $details['quantity'];
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Đã xóa sách khỏi giỏ hàng!',
                'cart_count' => $cartCount,
                'total' => number_format($total) . 'đ'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Sách không có trong giỏ hàng!'
        ]);
    }
    
    public function clear()
    {
        session()->forget('cart');
        
        // Xóa khỏi database nếu người dùng đã đăng nhập
        if (Auth::check()) {
            $userId = Auth::id();
            CartItem::where('user_id', $userId)->delete();
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Đã xóa toàn bộ giỏ hàng!',
            'cart_count' => 0
        ]);
    }
    
    public function count()
    {
        $cart = session()->get('cart', []);
        $count = array_sum(array_column($cart, 'quantity'));
        
        return response()->json([
            'cart_count' => $count
        ]);
    }

    /**
     * Đồng bộ giỏ hàng từ session vào database khi người dùng đăng nhập
     */
    public function syncCartToDatabase()
    {
        if (!Auth::check()) {
            return;
        }

        $sessionCart = session()->get('cart', []);
        $userId = Auth::id();

        foreach ($sessionCart as $bookId => $details) {
            $cartItem = CartItem::where('user_id', $userId)
                               ->where('book_id', $bookId)
                               ->first();

            if ($cartItem) {
                // Cập nhật quantity nếu đã tồn tại
                $cartItem->quantity += $details['quantity'];
                $cartItem->save();
            } else {
                // Tạo mới nếu chưa tồn tại
                CartItem::create([
                    'user_id' => $userId,
                    'book_id' => $bookId,
                    'quantity' => $details['quantity']
                ]);
            }
        }

        // Xóa session cart sau khi đồng bộ
        session()->forget('cart');
    }

    /**
     * Load giỏ hàng từ database vào session khi người dùng đăng nhập
     */
    public function loadCartFromDatabase()
    {
        if (!Auth::check()) {
            return;
        }

        $userId = Auth::id();
        $cartItems = CartItem::where('user_id', $userId)->get();

        $cart = [];
        foreach ($cartItems as $item) {
            $cart[$item->book_id] = [
                'quantity' => $item->quantity,
                'added_at' => $item->created_at
            ];
        }

        session()->put('cart', $cart);
    }

    /**
     * Lưu giỏ hàng vào database nếu người dùng đã đăng nhập
     */
    protected function saveCartToDatabase($bookId, $quantity)
    {
        if (!Auth::check()) {
            return;
        }

        $userId = Auth::id();
        $cartItem = CartItem::where('user_id', $userId)
                           ->where('book_id', $bookId)
                           ->first();

        if ($cartItem) {
            $cartItem->quantity = $quantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'user_id' => $userId,
                'book_id' => $bookId,
                'quantity' => $quantity
            ]);
        }
    }

    /**
     * Xóa item khỏi database
     */
    protected function removeFromDatabase($bookId)
    {
        if (!Auth::check()) {
            return;
        }

        $userId = Auth::id();
        CartItem::where('user_id', $userId)
                ->where('book_id', $bookId)
                ->delete();
    }
}
