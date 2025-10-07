<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of orders
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderDetails'])
                     ->orderBy('created_at', 'desc');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by payment method
        if ($request->has('payment_method') && $request->payment_method) {
            $query->where('payment_method', $request->payment_method);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter by amount range
        if ($request->has('min_amount') && $request->min_amount) {
            $query->where('total_amount', '>=', $request->min_amount);
        }

        if ($request->has('max_amount') && $request->max_amount) {
            $query->where('total_amount', '<=', $request->max_amount);
        }

        // Sort options
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'amount_high':
                $query->orderBy('total_amount', 'desc');
                break;
            case 'amount_low':
                $query->orderBy('total_amount', 'asc');
                break;
            case 'order_number':
                $query->orderBy('order_number', 'asc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $orders = $query->paginate($request->get('per_page', 15))->appends($request->query());

        // Statistics
        $stats = [
            'total' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'monthly_revenue' => Order::where('status', 'delivered')
                                    ->whereMonth('created_at', now()->month)
                                    ->whereYear('created_at', now()->year)
                                    ->sum('total_amount'),
            'average_order_value' => Order::where('status', 'delivered')->avg('total_amount') ?: 0,
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    /**
     * Display the specified order
     */
    public function show($id)
    {
        $order = Order::with(['user', 'orderDetails.book'])
                     ->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, $id)
    {
        // Simple validation first
        try {
            Log::info('UpdateStatus called with:', [
                'request_data' => $request->all(),
                'order_id' => $id,
                'user' => auth()->user()->id ?? 'not logged in'
            ]);
            
            $order = Order::findOrFail($id);
            
            // Simple update without validation first
            $order->update([
                'status' => $request->input('status', $order->status),
                'admin_note' => $request->input('note', '')
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật trạng thái thành công!'
            ]);
            
        } catch (\Exception $e) {
            Log::error('UpdateStatus error:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get order statistics for dashboard
     */
    public function getStats()
    {
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $shippedOrders = Order::where('status', 'shipped')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();

        $todayOrders = Order::whereDate('created_at', today())->count();
        $thisWeekOrders = Order::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $thisMonthOrders = Order::whereMonth('created_at', now()->month)
                                ->whereYear('created_at', now()->year)
                                ->count();

        $totalRevenue = Order::where('status', 'delivered')->sum('total_amount');
        $thisMonthRevenue = Order::where('status', 'delivered')
                                ->whereMonth('created_at', now()->month)
                                ->whereYear('created_at', now()->year)
                                ->sum('total_amount');

        // Order trends over last 7 days
        $dailyOrders = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $count = Order::whereDate('created_at', $date)->count();
            $dailyOrders[] = [
                'date' => $date->format('M d'),
                'count' => $count
            ];
        }

        // Revenue trends over last 6 months
        $monthlyRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $revenue = Order::where('status', 'delivered')
                          ->whereMonth('created_at', $date->month)
                          ->whereYear('created_at', $date->year)
                          ->sum('total_amount');
            $monthlyRevenue[] = [
                'month' => $date->format('M Y'),
                'revenue' => $revenue
            ];
        }

        return response()->json([
            'orders' => [
                'total' => $totalOrders,
                'pending' => $pendingOrders,
                'processing' => $processingOrders,
                'shipped' => $shippedOrders,
                'delivered' => $deliveredOrders,
                'cancelled' => $cancelledOrders,
                'today' => $todayOrders,
                'this_week' => $thisWeekOrders,
                'this_month' => $thisMonthOrders
            ],
            'revenue' => [
                'total' => $totalRevenue,
                'this_month' => $thisMonthRevenue
            ],
            'trends' => [
                'daily_orders' => $dailyOrders,
                'monthly_revenue' => $monthlyRevenue
            ]
        ]);
    }

    /**
     * Bulk update order status
     */
    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:orders,id',
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $updated = 0;
        foreach ($request->order_ids as $orderId) {
            $order = Order::find($orderId);
            if ($order) {
                $order->update(['status' => $request->status]);
                $updated++;
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Đã cập nhật trạng thái cho {$updated} đơn hàng."
        ]);
    }

    /**
     * Export orders to CSV
     */
    public function export(Request $request)
    {
        $query = Order::with(['user', 'orderDetails.book']);

        // Apply same filters as index
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->get();

        // Prepare rows for export
        $rows = [];
        $rows[] = [
            'Mã đơn hàng',
            'Khách hàng',
            'Email',
            'Số điện thoại',
            'Tổng tiền',
            'Trạng thái',
            'Phương thức thanh toán',
            'Ngày đặt',
            'Địa chỉ giao hàng'
        ];

        foreach ($orders as $order) {
            $rows[] = [
                $order->order_number,
                $order->customer_name,
                $order->customer_email,
                $order->customer_phone,
                number_format($order->total_amount),
                $order->status,
                $order->payment_method,
                $order->created_at->format('d/m/Y H:i'),
                $order->shipping_address
            ];
        }

        // If PhpSpreadsheet is available, generate an actual XLSX file
        if (class_exists('\PhpOffice\PhpSpreadsheet\Spreadsheet')) {
            $filename = 'orders_' . now()->format('Y_m_d_H_i_s') . '.xlsx';

            $callback = function() use ($rows) {
                $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();

                $rowNum = 1;
                foreach ($rows as $row) {
                    $colNum = 1;
                    foreach ($row as $cell) {
                        $sheet->setCellValueByColumnAndRow($colNum, $rowNum, $cell);
                        $colNum++;
                    }
                    $rowNum++;
                }

                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                $writer->save('php://output');
            };

            $headers = [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0'
            ];

            return response()->stream($callback, 200, $headers);
        }

        // Fallback: CSV export (works in all environments)
        $filename = 'orders_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=' . $filename,
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() use ($rows) {
            $file = fopen('php://output', 'w');

            // UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            foreach ($rows as $row) {
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Print order invoice
     */
    public function print($id)
    {
        $order = Order::with(['user', 'orderDetails.book'])
                     ->findOrFail($id);

        return view('admin.orders.print', compact('order'));
    }
}
