<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Book;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Apply coupon to cart
     */
    public function apply(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        $couponCode = strtoupper($request->code);
        $coupon = Coupon::where('code', $couponCode)->active()->available()->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn!'
            ]);
        }

        // Tính tổng tiền giỏ hàng
        $cart = session()->get('cart', []);
        $cartTotal = 0;

        foreach ($cart as $id => $details) {
            $book = Book::find($id);
            if ($book) {
                $price = $book->sale_price ?? $book->price;
                $cartTotal += $price * $details['quantity'];
            }
        }

        if (!$coupon->isValid($cartTotal)) {
            $message = 'Mã giảm giá không áp dụng được!';
            
            if ($coupon->minimum_amount && $cartTotal < $coupon->minimum_amount) {
                $message = 'Đơn hàng tối thiểu ' . number_format($coupon->minimum_amount) . 'đ để sử dụng mã này.';
            }

            return response()->json([
                'success' => false,
                'message' => $message
            ]);
        }

        $discount = $coupon->calculateDiscount($cartTotal);

        // Lưu coupon vào session
        session()->put('coupon', [
            'id' => $coupon->id,
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
            'discount_amount' => $discount,
            'minimum_order_amount' => $coupon->minimum_order_amount
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Áp dụng mã giảm giá thành công!',
            'coupon' => [
                'code' => $coupon->code,
                'type' => $coupon->type,
                'value' => $coupon->value,
                'discount' => $discount,
                'discount_formatted' => number_format($discount) . 'đ'
            ],
            'new_total' => $cartTotal - $discount,
            'new_total_formatted' => number_format($cartTotal - $discount) . 'đ'
        ]);
    }

    /**
     * Remove coupon from cart
     */
    public function remove()
    {
        session()->forget('coupon');

        return response()->json([
            'success' => true,
            'message' => 'Đã hủy mã giảm giá!'
        ]);
    }

    /**
     * Check coupon validity
     */
    public function check(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string'
        ]);

        $couponCode = strtoupper($request->coupon_code);
        $coupon = Coupon::where('code', $couponCode)->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá không tồn tại!'
            ]);
        }

        if (!$coupon->isValid()) {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá đã hết hạn hoặc không còn hiệu lực!'
            ]);
        }

        return response()->json([
            'success' => true,
            'coupon' => [
                'code' => $coupon->code,
                'name' => $coupon->name,
                'description' => $coupon->description,
                'type' => $coupon->type,
                'value' => $coupon->value,
                'minimum_amount' => $coupon->minimum_amount
            ]
        ]);
    }
}
