<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of customers
     */
    public function index(Request $request)
    {
        $query = User::customers()
                    ->withOrderStats();

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $customers = $query->paginate($request->get('per_page', 15));

        // Statistics
        $stats = [
            // Count both customers and staff so promoted users still count as customers in stats
            'total' => User::whereIn('role', ['customer', 'staff'])->count(),
            'new_this_month' => User::whereIn('role', ['customer', 'staff'])
                                   ->whereMonth('created_at', now()->month)
                                   ->whereYear('created_at', now()->year)
                                   ->count(),
        ];

        return view('admin.customers.index', compact('customers', 'stats'));
    }    /**
     * Display the specified customer
     */
    public function show($id)
    {
        $customer = User::withOrderStats()->findOrFail($id);

        $recentOrders = Order::where('user_id', $id)
                            ->with('orderDetails')
                            ->latest()
                            ->limit(5)
                            ->get();

        $orderStats = [
            'total' => Order::where('user_id', $id)->count(),
            'pending' => Order::where('user_id', $id)->where('status', 'pending')->count(),
            'completed' => Order::where('user_id', $id)->where('status', 'delivered')->count(),
            'cancelled' => Order::where('user_id', $id)->where('status', 'cancelled')->count(),
        ];

        return view('admin.customers.show', compact('customer', 'recentOrders', 'orderStats'));
    }

    /**
     * Show the form for editing the specified customer
     */
    public function edit($id)
    {
        $customer = User::findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified customer
     */
    public function update(Request $request, $id)
    {
    $customer = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($customer->id)
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'status' => 'required|in:active,inactive'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $customer->update($data);

        return redirect()->route('admin.customers.show', $customer)
                        ->with('success', 'Thông tin khách hàng đã được cập nhật thành công.');
    }

    /**
     * Promote a customer to staff
     */
    public function promoteToStaff(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Only allow promoting customers (or demoting back) via admin
        $user->role = 'staff';
        $user->save();

        return redirect()->back()->with('success', 'Người dùng đã được nâng quyền thành nhân viên.');
    }

    /**
     * Demote a staff to customer
     */
    public function demoteToCustomer(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->role = 'customer';
        $user->save();

        return redirect()->back()->with('success', 'Quyền nhân viên đã được gỡ bỏ.');
    }

    /**
     * Remove the specified customer
     */
    public function destroy($id)
    {
        // Allow deleting user if they are customer or staff
        $customer = User::whereIn('role', ['customer', 'staff'])->findOrFail($id);

        // Check if customer has orders
        if ($customer->orders()->count() > 0) {
            return back()->with('error', 'Không thể xóa khách hàng có đơn hàng. Vui lòng hủy tất cả đơn hàng trước.');
        }

        $customer->delete();

        return redirect()->route('admin.customers.index')
                        ->with('success', 'Khách hàng đã được xóa thành công.');
    }
}
