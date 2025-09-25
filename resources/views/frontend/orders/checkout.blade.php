@extends('layouts.frontend')

@section('title', 'Thanh toán')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a     const paymentInfo = {
        'cod': 'Thanh toán bằng tiền mặt khi nhận hàng.',
        'qr_code': 'Quét mã QR để thanh toán ngay lập tức.'
    };"{{ route('cart.index') }}">Giỏ hàng</a></li>
            <li class="breadcrumb-item active">Thanh toán</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="text-center mb-4">
        <h1 class="h3 mb-2">
            <i class="fas fa-credit-card"></i> Thanh toán đơn hàng
        </h1>
        <p class="text-muted">Vui lòng kiểm tra thông tin và điền đầy đủ để hoàn tất đơn hàng</p>
    </div>

    <form id="checkoutForm">
        @csrf
        <div class="row">
            <!-- Order Summary -->
            <div class="col-lg-5 order-lg-2 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-shopping-bag"></i> Đơn hàng của bạn
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Order Items -->
                        @foreach($cartItems as $item)
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <div class="d-flex align-items-center">
                                @if($item['book']->image)
                                        <img src="{{ $item['book']->image_url }}" 
                                         class="rounded me-2" 
                                         alt="{{ $item['book']->title }}"
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" 
                                         style="width: 50px; height: 50px;">
                                        <i class="fas fa-book text-muted"></i>
                                    </div>
                                @endif
                                <div>
                                    <h6 class="mb-0 small">{{ Str::limit($item['book']->title, 30) }}</h6>
                                    <small class="text-muted">{{ $item['book']->author }}</small>
                                    <br>
                                    <small class="text-primary">Số lượng: {{ $item['quantity'] }}</small>
                                </div>
                            </div>
                            <span class="fw-bold text-danger">{{ number_format($item['subtotal']) }}đ</span>
                        </div>
                        @endforeach

                        <hr>

                        <!-- Order Summary -->
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tạm tính:</span>
                            <span>{{ number_format($total) }}đ</span>
                        </div>
                        
                        @if(isset($coupon) && $discountAmount > 0)
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-success">
                                <i class="fas fa-tag"></i> Mã giảm giá ({{ $coupon['code'] }}):
                            </span>
                            <span class="text-success">-{{ number_format($discountAmount) }}đ</span>
                        </div>
                        @endif
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Phí vận chuyển:</span>
                            <span class="text-success">Miễn phí</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Thuế VAT:</span>
                            <span>Đã bao gồm</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Tổng cộng:</strong>
                            <strong class="text-danger fs-5">{{ number_format($finalTotal ?? $total) }}đ</strong>
                        </div>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-payment"></i> Phương thức thanh toán
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment_method" 
                                   id="cod" value="cod" checked>
                            <label class="form-check-label" for="cod">
                                <i class="fas fa-truck"></i> Thanh toán khi nhận hàng (COD)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" 
                                   id="qr_code" value="qr_code">
                            <label class="form-check-label" for="qr_code">
                                <i class="fas fa-qrcode"></i> Thanh toán QR Code
                            </label>
                        </div>
                        
                        <!-- QR Code Display -->
                        <div id="qr_code_section" class="mt-3" style="display: none;">
                            <div class="qr-instructions">
                                <h6><i class="fas fa-qrcode text-primary"></i> Hướng dẫn thanh toán QR Code:</h6>
                                <ol class="mb-0">
                                    <li>Mở ứng dụng ngân hàng trên điện thoại</li>
                                    <li>Chọn tính năng quét QR Code</li>
                                    <li>Quét mã QR bên dưới</li>
                                    <li>Kiểm tra thông tin và xác nhận thanh toán</li>
                                </ol>
                            </div>
                            <div class="text-center">
                                <div class="d-inline-block">
                                    <img id="qr_image" src="" alt="QR Code Thanh Toán" class="img-fluid" style="max-width: 200px;">
                                </div>
                                <div class="mt-3">
                                    <div class="qr-amount">
                                        Số tiền: <span id="qr_amount">{{ number_format($finalTotal ?? $total) }}đ</span>
                                    </div>
                                    <div class="mt-2">
                                        <small class="text-muted">
                                            <i class="fas fa-comment-dots"></i> <strong>Nội dung:</strong> Thanh toán hóa đơn
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="col-lg-7 order-lg-1">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-user"></i> Thông tin giao hàng
                        </h5>
                        @if($user->phone || $user->address)
                        <button type="button" class="btn btn-sm btn-outline-primary" id="loadProfileInfo" title="Tải lại thông tin từ hồ sơ">
                            <i class="fas fa-sync-alt"></i> Tải từ hồ sơ
                        </button>
                        @endif
                    </div>
                    <div class="card-body">
                        @if($user->phone || $user->address)
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <i class="fas fa-info-circle"></i>
                            <strong>Thông tin tự động:</strong> Số điện thoại và địa chỉ đã được điền từ hồ sơ của bạn. Bạn có thể chỉnh sửa nếu cần.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @else
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Hoàn thiện hồ sơ:</strong> Bạn chưa có số điện thoại và địa chỉ trong hồ sơ. 
                            <a href="{{ route('profile.edit') }}" class="alert-link" target="_blank">
                                Cập nhật hồ sơ <i class="fas fa-external-link-alt"></i>
                            </a> để tự động điền thông tin lần sau.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="customer_name" class="form-label">
                                    Họ và tên <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="customer_name" 
                                       name="customer_name" value="{{ $user->name }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="customer_email" class="form-label">
                                    Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control" id="customer_email" 
                                       name="customer_email" value="{{ $user->email }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="customer_phone" class="form-label">
                                Số điện thoại <span class="text-danger">*</span>
                            </label>
                            <input type="tel" class="form-control" id="customer_phone" 
                                   name="customer_phone" value="{{ $user->phone ?? '' }}" 
                                   placeholder="0123456789" required>
                        </div>

                        <div class="mb-3">
                            <label for="shipping_address" class="form-label">
                                Địa chỉ giao hàng <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" id="shipping_address" name="shipping_address" 
                                      rows="3" placeholder="Số nhà, tên đường, phường/xã, quận/huyện, tỉnh/thành phố" required>{{ $user->address ?? '' }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Ghi chú đơn hàng</label>
                            <textarea class="form-control" id="notes" name="notes" 
                                      rows="3" placeholder="Ghi chú về đơn hàng, ví dụ: thời gian hay chỉ dẫn địa điểm giao hàng chi tiết hơn."></textarea>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="terms" required>
                            <label class="form-check-label" for="terms">
                                Tôi đã đọc và đồng ý với 
                                <a href="#" class="text-decoration-none">điều khoản và điều kiện</a> 
                                của website <span class="text-danger">*</span>
                            </label>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary me-md-2">
                                <i class="fas fa-arrow-left"></i> Quay lại giỏ hàng
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                <i class="fas fa-check"></i> Đặt hàng ngay
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="position-fixed top-0 start-0 w-100 h-100 d-none" 
     style="background: rgba(0,0,0,0.5); z-index: 9999;">
    <div class="d-flex align-items-center justify-content-center h-100">
        <div class="text-center text-white">
            <div class="spinner-border mb-2" role="status"></div>
            <div>Đang xử lý đơn hàng...</div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// CSRF Token for AJAX requests
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Load profile information
$('#loadProfileInfo').on('click', function() {
    const btn = $(this);
    const originalHtml = btn.html();
    
    btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang tải...');
    
    // Reload profile data (from current user data in view)
    $('#customer_phone').val('{{ $user->phone ?? "" }}');
    $('#shipping_address').val('{{ $user->address ?? "" }}');
    
    // Show success message
    showAlert('success', 'Đã tải thông tin từ hồ sơ thành công!');
    
    // Reset button
    setTimeout(function() {
        btn.prop('disabled', false).html(originalHtml);
    }, 1000);
});

// Form submission
$('#checkoutForm').on('submit', function(e) {
    e.preventDefault();
    
    // Validate form
    if (!this.checkValidity()) {
        e.stopPropagation();
        $(this).addClass('was-validated');
        return;
    }
    
    // Show loading
    $('#loadingOverlay').removeClass('d-none');
    $('#submitBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang xử lý...');
    
    // Get form data
    const formData = new FormData(this);
    
    $.ajax({
        url: '{{ route("orders.store") }}',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                // Redirect to success page
                window.location.href = response.redirect_url;
            } else {
                showAlert('error', response.message);
                $('#loadingOverlay').addClass('d-none');
                $('#submitBtn').prop('disabled', false).html('<i class="fas fa-check"></i> Đặt hàng ngay');
            }
        },
        error: function(xhr) {
            let message = 'Có lỗi xảy ra, vui lòng thử lại!';
            
            if (xhr.responseJSON && xhr.responseJSON.message) {
                message = xhr.responseJSON.message;
            } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                const errors = Object.values(xhr.responseJSON.errors).flat();
                message = errors.join('\n');
            }
            
            showAlert('error', message);
            $('#loadingOverlay').addClass('d-none');
            $('#submitBtn').prop('disabled', false).html('<i class="fas fa-check"></i> Đặt hàng ngay');
        }
    });
});

// Show alert messages
function showAlert(type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
             style="top: 20px; right: 20px; z-index: 10000; min-width: 300px;">
            ${message.replace(/\n/g, '<br>')}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    $('body').append(alertHtml);
    
    // Auto dismiss after 5 seconds
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);
}

// Payment method info
$('input[name="payment_method"]').on('change', function() {
    const paymentInfo = {
        'cod': 'Bạn sẽ thanh toán bằng tiền mặt khi nhận hàng.',
        'bank_transfer': 'Chúng tôi sẽ gửi thông tin chuyển khoản sau khi đặt hàng.',
        'qr_code': 'Quét mã QR để thanh toán ngay lập tức.'
    };
    
    const selectedMethod = $(this).val();
    const info = paymentInfo[selectedMethod];
    
    // Remove existing info
    $('.payment-info').remove();
    
    // Add new info
    $(this).closest('.card-body').append(`
        <div class="alert alert-info payment-info mt-2">
            <small><i class="fas fa-info-circle"></i> ${info}</small>
        </div>
    `);
    
    // Handle QR code display
    if (selectedMethod === 'qr_code') {
        // Show QR code section
        $('#qr_code_section').show();
        
        // Generate QR code with actual amount
        const totalAmount = {{ $finalTotal ?? $total }};
        const qrUrl = `https://img.vietqr.io/image/MB-148492-qr_only.png?amount=${totalAmount}&addInfo=Thanh+toan+hoa+don`;
        
        $('#qr_image').attr('src', qrUrl);
        $('#qr_amount').text(new Intl.NumberFormat('vi-VN').format(totalAmount) + 'đ');
        
    } else {
        // Hide QR code section
        $('#qr_code_section').hide();
    }
});

// Auto-format phone number
$('#customer_phone').on('input', function() {
    let value = $(this).val().replace(/\D/g, '');
    if (value.length > 10) {
        value = value.substring(0, 10);
    }
    $(this).val(value);
});
</script>
@endpush

@push('styles')
<style>
.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.card {
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.was-validated .form-control:invalid {
    border-color: #dc3545;
}

.was-validated .form-control:valid {
    border-color: #198754;
}

@media (max-width: 768px) {
    .order-lg-2 {
        order: 1;
    }
    .order-lg-1 {
        order: 2;
    }
}

.alert {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

#qr_code_section {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border: 2px solid #dee2e6;
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    transition: all 0.3s ease;
}

#qr_code_section:hover {
    border-color: #0d6efd;
    box-shadow: 0 4px 15px rgba(13, 110, 253, 0.1);
}

#qr_image {
    border: 3px solid #fff;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    transition: transform 0.2s ease;
}

#qr_image:hover {
    transform: scale(1.05);
}

.qr-instructions {
    background: rgba(13, 110, 253, 0.1);
    border-left: 4px solid #0d6efd;
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 15px;
}

.qr-amount {
    background: #28a745;
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-weight: bold;
    display: inline-block;
    margin-top: 10px;
}
</style>
@endpush