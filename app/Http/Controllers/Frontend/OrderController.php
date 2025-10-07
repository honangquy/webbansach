<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function checkout()
    {
        // Load cart from database if user is logged in
        if (Auth::check()) {
            $cartController = new \App\Http\Controllers\Frontend\CartController();
            $cartController->loadCartFromDatabase();
        }
        
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống!');
        }
        
        $cartItems = [];
        $total = 0;
        
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
        
        // Calculate coupon discount
        $coupon = session('coupon');
        $discountAmount = 0;
        
        if ($coupon && $total >= ($coupon['minimum_order_amount'] ?? 0)) {
            if ($coupon['type'] === 'percentage') {
                $discountAmount = ($total * $coupon['value']) / 100;
            } else {
                $discountAmount = $coupon['value'];
            }
        }
        
        $finalTotal = $total - $discountAmount;
        
        $user = Auth::user();
        
        return view('frontend.orders.checkout', compact('cartItems', 'total', 'discountAmount', 'finalTotal', 'coupon', 'user'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
            'notes' => 'nullable|string|max:1000',
            'payment_method' => 'required|in:cod,bank_transfer,qr_code'
        ]);
        
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return response()->json([
                'success' => false,
                'message' => 'Giỏ hàng của bạn đang trống!'
            ]);
        }
        
        DB::beginTransaction();
        
        try {
            // Calculate total and validate stock
            $total = 0;
            $orderItems = [];
            
            foreach ($cart as $bookId => $details) {
                $book = Book::find($bookId);
                
                if (!$book) {
                    throw new \Exception("Sách không tồn tại!");
                }
                
                if ($book->stock_quantity < $details['quantity']) {
                    throw new \Exception("Sách '{$book->title}' không đủ số lượng trong kho!");
                }
                
                $price = $book->sale_price ?? $book->price;
                $subtotal = $price * $details['quantity'];
                
                $orderItems[] = [
                    'book' => $book,
                    'quantity' => $details['quantity'],
                    'price' => $price,
                    'subtotal' => $subtotal
                ];
                
                $total += $subtotal;
            }
            
            // Calculate coupon discount
            $coupon = session('coupon');
            $discountAmount = 0;
            $couponCode = null;
            
            if ($coupon) {
                $eligibleBookIds = $coupon['eligible_book_ids'] ?? [];
                $eligibleSubtotal = 0;

                foreach ($cart as $id => $details) {
                    $book = Book::find($id);
                    if ($book) {
                        $price = $book->sale_price ?? $book->price;
                        $lineTotal = $price * $details['quantity'];
                        if (empty($eligibleBookIds) || in_array($book->id, $eligibleBookIds)) {
                            $eligibleSubtotal += $lineTotal;
                        }
                    }
                }

                $validationAmount = empty($eligibleBookIds) ? $total : $eligibleSubtotal;

                if ($validationAmount >= ($coupon['minimum_order_amount'] ?? 0)) {
                    if ($coupon['type'] === 'percentage') {
                        $discountAmount = ($eligibleSubtotal ?: $total) * $coupon['value'] / 100;
                    } else {
                        $discountAmount = min($coupon['value'], ($eligibleSubtotal ?: $total));
                    }

                    $couponCode = $coupon['code'];

                    // Update coupon usage
                    if (isset($coupon['id'])) {
                        $couponModel = \App\Models\Coupon::find($coupon['id']);
                        if ($couponModel) {
                            $couponModel->increment('used_count');
                        }
                    }
                }
            }
            
            $finalTotal = $total - $discountAmount;
            
            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid()),
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'shipping_address' => $request->shipping_address,
                'notes' => $request->notes,
                'payment_method' => $request->payment_method,
                'total_amount' => $total,
                'coupon_code' => $couponCode,
                'discount_amount' => $discountAmount,
                'final_amount' => $finalTotal,
                'status' => 'pending',
                'order_date' => now()
            ]);
            
            // Create order details and update stock
            foreach ($orderItems as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'book_id' => $item['book']->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['subtotal']
                ]);
                
                // Update book stock
                $item['book']->decrement('stock_quantity', $item['quantity']);
            }
            
            DB::commit();
            
            // Clear cart
            session()->forget('cart');
            session()->forget('coupon');
            
            // Clear cart from database if user is logged in
            if (Auth::check()) {
                \App\Models\CartItem::where('user_id', Auth::id())->delete();
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Đặt hàng thành công!',
                'order_id' => $order->id,
                'redirect_url' => route('orders.success', $order->id)
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function success($orderId)
    {
        $order = Order::with('orderDetails.book')->where('id', $orderId)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();
        
        return view('frontend.orders.success', compact('order'));
    }
    
    public function index()
    {
        $orders = Order::with('orderDetails.book')
                       ->where('user_id', Auth::id())
                       ->orderBy('created_at', 'desc')
                       ->paginate(10);
        
        // Get order counts by status for tabs
        $orderCounts = Order::where('user_id', Auth::id())
                          ->selectRaw('status, COUNT(*) as count')
                          ->groupBy('status')
                          ->pluck('count', 'status')
                          ->toArray();
        
        // Total orders count
        $totalOrders = Order::where('user_id', Auth::id())->count();
        
        return view('frontend.orders.index', compact('orders', 'orderCounts', 'totalOrders'));
    }
    
    public function show($orderId)
    {
        $order = Order::with('orderDetails.book')->where('id', $orderId)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();
        
        return view('frontend.orders.show', compact('order'));
    }
    
    public function cancel(Request $request, $orderId)
    {
        $order = Order::with('orderDetails.book')
                      ->where('id', $orderId)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();
        
        // Check if order can be cancelled
        if (!in_array($order->status, ['pending', 'processing'])) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể hủy đơn hàng này vì đã được xử lý.'
            ], 400);
        }
        
        DB::beginTransaction();
        try {
            // Update order status
            $order->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'cancel_reason' => $request->input('reason')
            ]);
            
            // Restore book stock
            foreach ($order->orderDetails as $detail) {
                if ($detail->book) {
                    $detail->book->increment('stock_quantity', $detail->quantity);
                }
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Đơn hàng đã được hủy thành công.'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error cancelling order: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi hủy đơn hàng: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function reorder($orderId)
    {
        $order = Order::with('orderDetails.book')->where('id', $orderId)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();
        
        try {
            $cart = session()->get('cart', []);
            $addedItems = 0;
            $unavailableItems = [];
            
            foreach ($order->orderDetails as $detail) {
                $book = $detail->book;
                
                // Check if book is still available
                if ($book->stock < $detail->quantity) {
                    $unavailableItems[] = $book->title;
                    continue;
                }
                
                $bookId = $book->id;
                
                if (isset($cart[$bookId])) {
                    $cart[$bookId]['quantity'] += $detail->quantity;
                    $cart[$bookId]['subtotal'] = $cart[$bookId]['quantity'] * $cart[$bookId]['price'];
                } else {
                    $cart[$bookId] = [
                        'book' => $book,
                        'quantity' => $detail->quantity,
                        'price' => $book->discounted_price ?: $book->price,
                        'subtotal' => $detail->quantity * ($book->discounted_price ?: $book->price)
                    ];
                }
                $addedItems++;
            }
            
            session()->put('cart', $cart);
            
            $message = "Đã thêm {$addedItems} sản phẩm vào giỏ hàng.";
            if (!empty($unavailableItems)) {
                $message .= " Một số sản phẩm không còn đủ hàng: " . implode(', ', $unavailableItems);
            }
            
            return response()->json([
                'success' => true,
                'message' => $message
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng.'
            ], 500);
        }
    }
}
