@extends('layouts.frontend')

@section('title', 'Giỏ hàng')

@section('content')

<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Giỏ hàng</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
            <i class="fas fa-shopping-cart"></i> Giỏ hàng của bạn
        </h1>
        @if(count($cartItems) > 0)
            <button class="btn btn-outline-danger btn-sm" id="clearCartBtn">
                <i class="fas fa-trash"></i> Xóa toàn bộ
            </button>
        @endif
    </div>

    @if(count($cartItems) > 0)
        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Sách đã chọn ({{ count($cartItems) }} sản phẩm)</h5>
                    </div>
                    <div class="card-body p-0">
                        @foreach($cartItems as $index => $item)
                        <div class="cart-item p-3 border-bottom" data-book-id="{{ $item['book']->id }}">
                            <div class="d-flex align-items-center">
                                <!-- Image -->
                                <a href="{{ route('books.show', $item['book']->id) }}" class="flex-shrink-0">
                                    @if($item['book']->image)
                                        {{-- Use the Book model accessor which returns a full URL for external images or an asset() URL for storage paths. --}}
                                        <img src="{{ $item['book']->image_url }}" alt="{{ $item['book']->title }}" class="rounded" style="width: 75px; height: 100px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 75px; height: 100px;">
                                            <i class="fas fa-book text-muted fa-2x"></i>
                                        </div>
                                    @endif
                                </a>
                                
                                <!-- Info -->
                                <div class="flex-grow-1 ms-3">
                                    <a href="{{ route('books.show', $item['book']->id) }}" class="text-decoration-none text-dark fw-bold">{{ $item['book']->title }}</a>
                                    <div class="text-muted small">{{ $item['book']->author }}</div>
                                    <div class="text-primary small">{{ $item['book']->category->name }}</div>
                                </div>

                                <!-- Price -->
                                <div class="text-center mx-4" style="min-width: 120px;">
                                    @if($item['book']->sale_price && $item['book']->sale_price < $item['book']->price)
                                        <div class="fw-bold text-danger">{{ number_format($item['price']) }}đ</div>
                                        <small class="text-muted text-decoration-line-through">{{ number_format($item['book']->price) }}đ</small>
                                    @else
                                        <div class="fw-bold text-danger">{{ number_format($item['price']) }}đ</div>
                                    @endif
                                </div>

                                <!-- Quantity -->
                                <div class="text-center mx-4">
                                    <div class="quantity-controls d-flex align-items-center justify-content-center" style="width: 110px;">
                                        <button class="btn btn-outline-secondary btn-sm quantity-btn" data-action="decrease" data-book-id="{{ $item['book']->id }}"><i class="fas fa-minus"></i></button>
                                        <input type="number" class="form-control form-control-sm text-center mx-1 quantity-input" value="{{ $item['quantity'] }}" min="1" max="{{ $item['book']->stock_quantity }}" data-book-id="{{ $item['book']->id }}">
                                        <button class="btn btn-outline-secondary btn-sm quantity-btn" data-action="increase" data-book-id="{{ $item['book']->id }}"><i class="fas fa-plus"></i></button>
                                    </div>
                                    <small class="text-muted d-block mt-1">Còn {{ $item['book']->stock_quantity }}</small>
                                </div>

                                <!-- Subtotal -->
                                <div class="fw-bold text-danger text-end mx-4" style="min-width: 120px;">
                                    {{ number_format($item['subtotal']) }}đ
                                </div>

                                <!-- Remove Button -->
                                <div class="text-end">
                                    <button class="btn btn-outline-danger btn-sm remove-item" data-book-id="{{ $item['book']->id }}" title="Xóa khỏi giỏ hàng">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Continue Shopping -->
                <div class="mt-3">
                    <a href="{{ route('books.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left"></i> Tiếp tục mua sắm
                    </a>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Tóm tắt đơn hàng</h5>
                    </div>
                    <div class="card-body">
                        <!-- Coupon Section -->
                        <div class="mb-3">
                            <h6 class="mb-2">Mã giảm giá</h6>
                            @if(session('coupon'))
                                <div class="alert alert-success d-flex justify-content-between align-items-center">
                                    <div>
                                        <small class="text-muted">Mã:</small> <code>{{ session('coupon.code') }}</code><br>
                                        <small class="text-muted">Giảm:</small> 
                                        <span class="text-success fw-bold">
                                            @if(session('coupon.type') === 'percentage')
                                                {{ session('coupon.value') }}%
                                            @else
                                                {{ number_format(session('coupon.discount_amount')) }}đ
                                            @endif
                                        </span>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger" id="removeCouponBtn">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            @else
                                <div class="input-group">
                                    <input type="text" class="form-control" id="couponCode" placeholder="Nhập mã giảm giá">
                                    <button class="btn btn-outline-primary" type="button" id="applyCouponBtn">
                                        Áp dụng
                                    </button>
                                </div>
                                <div id="couponMessage" class="mt-2"></div>
                            @endif
                        </div>
                        <hr>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Tạm tính:</span>
                            <span class="cart-subtotal text-nowrap">{{ number_format($total) }}đ</span>
                        </div>
                        
                        @if(session('coupon'))
                            <div class="d-flex justify-content-between mb-2 text-success">
                                <span>Giảm giá ({{ session('coupon.code') }}):</span>
                                <span class="text-nowrap">-{{ number_format(session('coupon.discount_amount', 0)) }}đ</span>
                            </div>
                        @endif
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Phí vận chuyển:</span>
                            <span class="text-success">Miễn phí</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Tổng cộng:</strong>
                            <strong class="text-danger cart-total text-nowrap">{{ number_format($total - session('coupon.discount_amount', 0)) }}đ</strong>
                        </div>

                        <div class="d-grid gap-2">
                            @auth
                                <a href="{{ route('orders.checkout') }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-credit-card"></i> Tiến hành thanh toán
                                </a>
                            @else
                                <div class="alert alert-info text-center mb-3">
                                    <small>Vui lòng đăng nhập để tiến hành thanh toán</small>
                                </div>
                                <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-sign-in-alt"></i> Đăng nhập
                                </a>
                                <a href="{{ route('register') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-user-plus"></i> Đăng ký
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Empty Cart -->
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-shopping-cart fa-5x text-muted"></i>
            </div>
            <h4>Giỏ hàng của bạn đang trống</h4>
            <p class="text-muted mb-4">Hãy thêm một số sách vào giỏ hàng để bắt đầu mua sắm!</p>
            <a href="{{ route('books.index') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-book"></i> Khám phá sách
            </a>
        </div>
    @endif
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="position-fixed top-0 start-0 w-100 h-100 d-none" 
     style="background: rgba(0,0,0,0.5); z-index: 9999;">
    <div class="d-flex align-items-center justify-content-center h-100">
        <div class="text-center text-white">
            <div class="spinner-border mb-2" role="status"></div>
            <div>Đang xử lý...</div>
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

// Show loading overlay
function showLoading() {
    $('#loadingOverlay').removeClass('d-none');
}

// Hide loading overlay
function hideLoading() {
    $('#loadingOverlay').addClass('d-none');
}

// Update cart badge
function updateCartBadge(count) {
    $('.cart-badge').text(count);
}

// Quantity control buttons
$(document).on('click', '.quantity-btn', function() {
    const action = $(this).data('action');
    const bookId = $(this).data('book-id');
    const input = $(`.quantity-input[data-book-id="${bookId}"]`);
    const currentValue = parseInt(input.val());
    const max = parseInt(input.attr('max'));
    
    let newValue = currentValue;
    
    if (action === 'increase' && currentValue < max) {
        newValue = currentValue + 1;
    } else if (action === 'decrease' && currentValue > 1) {
        newValue = currentValue - 1;
    }
    
    if (newValue !== currentValue) {
        input.val(newValue);
        updateQuantity(bookId, newValue);
    }
});

// Quantity input change
$(document).on('change', '.quantity-input', function() {
    const bookId = $(this).data('book-id');
    const quantity = parseInt($(this).val());
    const max = parseInt($(this).attr('max'));
    
    if (quantity < 1) {
        $(this).val(1);
        updateQuantity(bookId, 1);
    } else if (quantity > max) {
        $(this).val(max);
        updateQuantity(bookId, max);
    } else {
        updateQuantity(bookId, quantity);
    }
});

// Update quantity function
function updateQuantity(bookId, quantity) {
    showLoading();
    
    $.ajax({
        url: '{{ route("cart.update") }}',
        method: 'POST',
        data: {
            book_id: bookId,
            quantity: quantity
        },
        success: function(response) {
            if (response.success) {
                // Update subtotal for this item
                $(`.cart-item[data-book-id="${bookId}"] .subtotal`).text(response.subtotal);
                
                // Update total
                $('.cart-total').text(response.total);
                
                // Update cart badge
                updateCartBadge(response.cart_count);
                
                // Show success message
                showAlert('success', response.message);
            } else {
                showAlert('error', response.message);
            }
        },
        error: function() {
            showAlert('error', 'Có lỗi xảy ra, vui lòng thử lại!');
        },
        complete: function() {
            hideLoading();
        }
    });
}

// Remove item from cart
$(document).on('click', '.remove-item', function() {
    const bookId = $(this).data('book-id');
    
    if (confirm('Bạn có chắc chắn muốn xóa sách này khỏi giỏ hàng?')) {
        showLoading();
        
        $.ajax({
            url: '{{ route("cart.remove") }}',
            method: 'POST',
            data: {
                book_id: bookId
            },
            success: function(response) {
                if (response.success) {
                    // Remove item from DOM
                    $(`.cart-item[data-book-id="${bookId}"]`).fadeOut(300, function() {
                        $(this).remove();
                        
                        // Check if cart is empty
                        if ($('.cart-item').length === 0) {
                            location.reload();
                        }
                    });
                    
                    // Update total
                    $('.cart-total').text(response.total);
                    
                    // Update cart badge
                    updateCartBadge(response.cart_count);
                    
                    showAlert('success', response.message);
                } else {
                    showAlert('error', response.message);
                }
            },
            error: function() {
                showAlert('error', 'Có lỗi xảy ra, vui lòng thử lại!');
            },
            complete: function() {
                hideLoading();
            }
        });
    }
});

// Clear entire cart
$(document).on('click', '#clearCartBtn', function() {
    if (confirm('Bạn có chắc chắn muốn xóa toàn bộ giỏ hàng?')) {
        showLoading();
        
        $.ajax({
            url: '{{ route("cart.clear") }}',
            method: 'POST',
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    showAlert('error', response.message);
                }
            },
            error: function() {
                showAlert('error', 'Có lỗi xảy ra, vui lòng thử lại!');
            },
            complete: function() {
                hideLoading();
            }
        });
    }
});

// Apply coupon
$(document).on('click', '#applyCouponBtn', function() {
    const couponCode = $('#couponCode').val().trim();
    
    if (!couponCode) {
        showCouponMessage('error', 'Vui lòng nhập mã giảm giá!');
        return;
    }
    
    showLoading();
    
    $.ajax({
        url: '{{ route("coupon.apply") }}',
        method: 'POST',
        data: {
            code: couponCode
        },
        success: function(response) {
            if (response.success) {
                showCouponMessage('success', response.message);
                setTimeout(function() {
                    location.reload();
                }, 1500);
            } else {
                showCouponMessage('error', response.message);
            }
        },
        error: function(xhr) {
            const response = xhr.responseJSON;
            showCouponMessage('error', response?.message || 'Có lỗi xảy ra, vui lòng thử lại!');
        },
        complete: function() {
            hideLoading();
        }
    });
});

// Remove coupon
$(document).on('click', '#removeCouponBtn', function() {
    if (confirm('Bạn có chắc muốn gỡ mã giảm giá?')) {
        showLoading();
        
        $.ajax({
            url: '{{ route("coupon.remove") }}',
            method: 'POST',
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message);
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    showAlert('error', response.message);
                }
            },
            error: function() {
                showAlert('error', 'Có lỗi xảy ra, vui lòng thử lại!');
            },
            complete: function() {
                hideLoading();
            }
        });
    }
});

// Show coupon message
function showCouponMessage(type, message) {
    const messageClass = type === 'success' ? 'text-success' : 'text-danger';
    const iconClass = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';
    
    $('#couponMessage').html(`
        <small class="${messageClass}">
            <i class="${iconClass}"></i> ${message}
        </small>
    `);
    
    setTimeout(function() {
        $('#couponMessage').html('');
    }, 5000);
}

// Show alert messages
function showAlert(type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
             style="top: 20px; right: 20px; z-index: 10000; min-width: 300px;">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    $('body').append(alertHtml);
    
    // Auto dismiss after 3 seconds
    setTimeout(function() {
        $('.alert').alert('close');
    }, 3000);
}
</script>
@endpush

@push('styles')
<style>
.quantity-controls .btn {
    width: 32px;
    height: 32px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.quantity-input {
    border-left: none;
    border-right: none;
}

.cart-item {
    transition: background-color 0.3s ease;
}

.cart-item:hover {
    background-color: #f8f9fa;
}

.price-info small {
    line-height: 1.2;
}

@media (max-width: 768px) {
    .quantity-controls {
        flex-wrap: nowrap;
    }
    
    .cart-item .col-md-2,
    .cart-item .col-md-1 {
        margin-bottom: 0.5rem;
    }
}

.alert {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
</style>
@endpush