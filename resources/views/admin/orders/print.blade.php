<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa đơn đơn hàng #{{ $order->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Times New Roman', serif;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
            background: white;
        }
        
        .invoice-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 30px;
            background: white;
        }
        
        .invoice-header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 3px solid #333;
            padding-bottom: 20px;
        }
        
        .company-name {
            font-size: 28px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .invoice-title {
            font-size: 24px;
            color: #e74c3c;
            margin: 15px 0;
        }
        
        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        
        .invoice-info div {
            flex: 1;
        }
        
        .order-details {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        
        .customer-info {
            background: #e8f4fd;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        .items-table th,
        .items-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        
        .items-table th {
            background-color: #34495e;
            color: white;
            font-weight: bold;
            text-align: center;
        }
        
        .items-table td:nth-child(3),
        .items-table td:nth-child(4),
        .items-table td:nth-child(5) {
            text-align: right;
        }
        
        .items-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .total-section {
            margin-top: 20px;
            text-align: right;
        }
        
        .total-row {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 10px;
        }
        
        .total-label {
            width: 200px;
            text-align: right;
            padding-right: 20px;
            font-weight: bold;
        }
        
        .total-value {
            width: 150px;
            text-align: right;
            padding: 5px 10px;
            border: 1px solid #ddd;
        }
        
        .grand-total {
            background-color: #e74c3c;
            color: white;
            font-size: 18px;
            font-weight: bold;
        }
        
        .grand-total-label {
            background-color: #e74c3c;
            color: white;
            font-size: 18px;
            font-weight: bold;
        }
        
        .footer {
            margin-top: 50px;
            text-align: center;
            border-top: 2px solid #333;
            padding-top: 20px;
            color: #666;
        }
        
        @media print {
            body {
                margin: 0;
                font-size: 12px;
            }
            
            .invoice-container {
                margin: 0;
                padding: 15px;
                box-shadow: none;
            }
            
            .no-print {
                display: none;
            }
        }
        
        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #3498db;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        
        .print-btn:hover {
            background: #2980b9;
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-pending { background: #f39c12; color: white; }
        .status-processing { background: #3498db; color: white; }
        .status-shipped { background: #9b59b6; color: white; }
        .status-delivered { background: #27ae60; color: white; }
        .status-cancelled { background: #e74c3c; color: white; }
    </style>
</head>
<body>
    <button class="print-btn no-print" onclick="window.print()">In hóa đơn</button>
    
    <div class="invoice-container">
        <!-- Header -->
        <div class="invoice-header">
            <div class="company-name">WEBBANSACH.COM</div>
            <div style="color: #666; font-style: italic;">Hệ thống bán sách trực tuyến</div>
            <div class="invoice-title">HÓA ĐƠN BÁN HÀNG</div>
        </div>
        
        <!-- Invoice Information -->
        <div class="invoice-info">
            <div class="order-details">
                <h3 style="margin-bottom: 15px; color: #2c3e50;">Thông tin đơn hàng</h3>
                <p><strong>Mã đơn hàng:</strong> {{ $order->order_number }}</p>
                <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i:s') }}</p>
                <p><strong>Trạng thái:</strong> 
                    <span class="status-badge status-{{ $order->status }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </p>
                <p><strong>Phương thức thanh toán:</strong> {{ ucfirst($order->payment_method) }}</p>
            </div>
            
            <div class="customer-info">
                <h3 style="margin-bottom: 15px; color: #2c3e50;">Thông tin khách hàng</h3>
                <p><strong>Họ tên:</strong> {{ $order->customer_name }}</p>
                <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                <p><strong>Số điện thoại:</strong> {{ $order->customer_phone }}</p>
                <p><strong>Địa chỉ giao hàng:</strong></p>
                <p style="margin-left: 15px;">{{ $order->shipping_address }}</p>
            </div>
        </div>
        
        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderDetails as $index => $detail)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $detail->book->title }}</strong>
                        @if($detail->book->author)
                            <br><small style="color: #666;">Tác giả: {{ $detail->book->author }}</small>
                        @endif
                    </td>
                    <td>{{ $detail->quantity }}</td>
                    <td>{{ number_format($detail->price, 0, ',', '.') }}đ</td>
                    <td>{{ number_format($detail->total, 0, ',', '.') }}đ</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <!-- Totals -->
        <div class="total-section">
            <div class="total-row">
                <div class="total-label">Tạm tính:</div>
                <div class="total-value">{{ number_format($order->subtotal, 0, ',', '.') }}đ</div>
            </div>
            
            @if($order->shipping_fee > 0)
            <div class="total-row">
                <div class="total-label">Phí vận chuyển:</div>
                <div class="total-value">{{ number_format($order->shipping_fee, 0, ',', '.') }}đ</div>
            </div>
            @endif
            
            @if($order->discount_amount > 0)
            <div class="total-row">
                <div class="total-label">Giảm giá:</div>
                <div class="total-value">-{{ number_format($order->discount_amount, 0, ',', '.') }}đ</div>
            </div>
            @endif
            
            <div class="total-row">
                <div class="total-label grand-total-label">TỔNG CỘNG:</div>
                <div class="total-value grand-total">{{ number_format($order->final_amount ?? $order->total_amount, 0, ',', '.') }}đ</div>
            </div>
        </div>
        
        @if($order->notes)
        <div style="margin-top: 30px; padding: 15px; background: #fff3cd; border-left: 4px solid #ffc107;">
            <h4 style="color: #856404; margin-bottom: 10px;">Ghi chú đơn hàng:</h4>
            <p style="color: #856404;">{{ $order->notes }}</p>
        </div>
        @endif
        
        @if($order->admin_note)
        <div style="margin-top: 15px; padding: 15px; background: #d1ecf1; border-left: 4px solid #bee5eb;">
            <h4 style="color: #0c5460; margin-bottom: 10px;">Ghi chú từ admin:</h4>
            <p style="color: #0c5460;">{{ $order->admin_note }}</p>
        </div>
        @endif
        
        <!-- Footer -->
        <div class="footer">
            <p><strong>Cảm ơn quý khách đã mua hàng tại WEBBANSACH.COM!</strong></p>
            <p>Địa chỉ: 123 Đường ABC, Quận XYZ, TP.HCM | Hotline: 1900-xxxx | Email: support@webbansach.com</p>
            <p style="margin-top: 15px; font-size: 12px;">
                Hóa đơn được in lúc: {{ now()->format('d/m/Y H:i:s') }}
            </p>
        </div>
    </div>
    
    <script>
        // Auto print when page loads (optional)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>