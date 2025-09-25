@extends('layouts.frontend')

@section('title', $book->title)

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('books.index') }}">Sách</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($book->title, 40) }}</li>
        </ol>
    </nav>

    <div class="card border-0 shadow-sm mb-5">
        <div class="card-body p-4">
            <div class="row">
                <!-- Book Image -->
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <div class="sticky-top" style="top: 80px;">
                        @if($book->image)
                            <img src="{{ $book->image_url }}" 
                                 class="img-fluid rounded shadow-lg" 
                                 alt="{{ $book->title }}"
                                 style="width: 100%; max-height: 500px; object-fit: contain; padding: 1rem; background-color: #f8f9fa;">
                        @else
                            <div class="bg-light rounded shadow d-flex align-items-center justify-content-center" 
                                 style="width: 100%; height: 500px;">
                                <i class="fas fa-book fa-5x text-muted"></i>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Book Details -->
                <div class="col-lg-8">
                    <!-- Title -->
                    <h1 class="h2 fw-bold mb-2">{{ $book->title }}</h1>
                    
                    <!-- Author and Category -->
                    <div class="d-flex flex-wrap align-items-center text-muted mb-3">
                        <span>Tác giả: <a href="#" class="text-decoration-none">{{ $book->author }}</a></span>
                        <span class="mx-2">|</span>
                        <span>Danh mục: <a href="{{ route('books.index', ['category' => $book->category_id]) }}" class="text-decoration-none">{{ $book->category->name }}</a></span>
                    </div>

                    <!-- Price -->
                    <div class="bg-light p-3 rounded mb-4">
                        @if($book->sale_price && $book->sale_price < $book->price)
                            <div class="d-flex align-items-center gap-3">
                                <span class="h3 fw-bold text-danger mb-0">{{ number_format($book->sale_price) }}đ</span>
                                <span class="h5 text-muted text-decoration-line-through mb-0">
                                    {{ number_format($book->price) }}đ
                                </span>
                                <span class="badge bg-danger fs-6">
                                    -{{ round((($book->price - $book->sale_price) / $book->price) * 100) }}%
                                </span>
                            </div>
                        @else
                            <span class="h3 fw-bold text-danger mb-0">{{ number_format($book->price) }}đ</span>
                        @endif
                    </div>

                    <!-- Stock Status -->
                    <div class="mb-4">
                        <h6 class="fw-bold">Tình trạng:</h6>
                        @if($book->stock_quantity > 0)
                            <span class="text-success fw-bold">
                                <i class="fas fa-check-circle"></i> Còn hàng ({{ $book->stock_quantity }} sản phẩm)
                            </span>
                        @else
                            <span class="text-secondary fw-bold">
                                <i class="fas fa-times-circle"></i> Hết hàng
                            </span>
                        @endif
                    </div>

                    <!-- Add to Cart -->
                    @if($book->stock_quantity > 0)
                        <div class="d-flex align-items-end gap-3 mb-4">
                            <div class="quantity-selector">
                                <label for="quantity" class="form-label fw-bold mb-2">Số lượng:</label>
                                <div class="input-group">
                                    <button class="btn btn-outline-secondary" type="button" id="decrease-qty">-</button>
                                    <input type="text" class="form-control text-center" id="quantity" value="1" min="1" max="{{ $book->stock_quantity }}">
                                    <button class="btn btn-outline-secondary" type="button" id="increase-qty">+</button>
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-primary add-to-cart" data-book-id="{{ $book->id }}">
                                    <i class="fas fa-cart-plus"></i> Thêm vào giỏ hàng
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-secondary text-center">Sản phẩm này đã hết hàng.</div>
                    @endif
                    
                    <hr>

                    <!-- Book Info Table -->
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3">Thông tin chi tiết</h5>
                        <table class="table table-striped table-sm">
                            <tbody>
                                @if($book->publisher)
                                <tr>
                                    <th scope="row" style="width: 150px;">Nhà xuất bản</th>
                                    <td>{{ $book->publisher }}</td>
                                </tr>
                                @endif
                                @if($book->publish_date)
                                <tr>
                                    <th scope="row">Năm xuất bản</th>
                                    <td>{{ \Carbon\Carbon::parse($book->publish_date)->format('Y') }}</td>
                                </tr>
                                @endif
                                @if($book->pages)
                                <tr>
                                    <th scope="row">Số trang</th>
                                    <td>{{ $book->pages }}</td>
                                </tr>
                                @endif
                                @if($book->isbn)
                                <tr>
                                    <th scope="row">ISBN</th>
                                    <td>{{ $book->isbn }}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Description and Related Books -->
    <div class="row">
        <div class="col-lg-8">
            <!-- Description -->
            @if($book->description)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 pt-3">
                        <h5 class="mb-0 fw-bold">Mô tả sản phẩm</h5>
                    </div>
                    <div class="card-body">
                        <div class="book-description">
                            {!! nl2br(e($book->description)) !!}
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-lg-4">
            <!-- Related Books -->
            @if($relatedBooks->count() > 0)
                <div class="sticky-top" style="top: 80px;">
                    <div class="card border-0 shadow-sm">
                         <div class="card-header bg-white border-0 pt-3">
                            <h5 class="mb-0 fw-bold">Sách cùng danh mục</h5>
                        </div>
                        <div class="card-body">
                            @foreach($relatedBooks as $relatedBook)
                                <div class="d-flex align-items-center mb-3">
                                    <a href="{{ route('books.show', $relatedBook->id) }}">
                                        <img src="{{ $relatedBook->image_url }}" alt="{{ $relatedBook->title }}" class="rounded" style="width: 60px; height: 80px; object-fit: cover;">
                                    </a>
                                    <div class="ms-3">
                                        <h6 class="mb-1 lh-base" style="font-size: 0.9rem;">
                                            <a href="{{ route('books.show', $relatedBook->id) }}" class="text-decoration-none text-dark">{{ Str::limit($relatedBook->title, 40) }}</a>
                                        </h6>
                                        <span class="text-danger fw-bold" style="font-size: 0.9rem;">{{ number_format($relatedBook->sale_price ?? $relatedBook->price) }}đ</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantityInput = document.getElementById('quantity');
    const decreaseBtn = document.getElementById('decrease-qty');
    const increaseBtn = document.getElementById('increase-qty');
    const addToCartBtn = document.querySelector('.add-to-cart');

    function updateQuantity(change) {
        let currentValue = parseInt(quantityInput.value);
        const min = parseInt(quantityInput.min);
        const max = parseInt(quantityInput.max);
        
        let newValue = currentValue + change;
        
        if (newValue < min) newValue = min;
        if (newValue > max) newValue = max;
        
        quantityInput.value = newValue;
    }

    if (decreaseBtn) {
        decreaseBtn.addEventListener('click', () => updateQuantity(-1));
    }

    if (increaseBtn) {
        increaseBtn.addEventListener('click', () => updateQuantity(1));
    }

    if (quantityInput) {
        quantityInput.addEventListener('change', function() {
            const min = parseInt(this.min);
            const max = parseInt(this.max);
            let value = parseInt(this.value);
            
            if (isNaN(value) || value < min) this.value = min;
            if (value > max) this.value = max;
        });
    }

    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function() {
            const bookId = this.dataset.bookId;
            const quantity = quantityInput ? parseInt(quantityInput.value) : 1;
            window.addToCart(bookId, quantity);
        });
    }
});
</script>
@endpush

@push('styles')
<style>
    .quantity-selector {
        max-width: 120px;
    }
    .quantity-selector .form-control {
        height: calc(1.5em + .75rem + 2px);
    }
    .quantity-selector .btn {
        height: calc(1.5em + .75rem + 2px);
    }
    .book-description {
        line-height: 1.8;
        color: #495057;
    }
    .table-striped > tbody > tr:nth-of-type(odd) > * {
        background-color: rgba(0,0,0,.02);
    }
</style>
@endpush