

<?php $__env->startSection('title', 'Danh sách sách'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Danh sách sách</li>
                </ol>
            </nav>
            <h1 class="h3 mb-0">Danh sách sách</h1>
            <p class="text-muted">Tìm và khám phá những cuốn sách yêu thích của bạn</p>
        </div>
    </div>

    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-lg-3 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-filter"></i> Bộ lọc
                    </h5>
                </div>
                <div class="card-body">
                    <form id="filterForm" method="GET" action="<?php echo e(route('books.index')); ?>">
                        <!-- Search Box -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tìm kiếm</label>
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Tên sách, tác giả..." 
                                   value="<?php echo e(request('search')); ?>">
                        </div>

                        <!-- Category Filter -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Danh mục</label>
                            <select name="category" class="form-select">
                                <option value="">Tất cả danh mục</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" 
                                        <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                                    <?php echo e($category->name); ?>

                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- Price Range -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Khoảng giá</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="number" name="min_price" class="form-control" 
                                           placeholder="Từ" min="0" 
                                           value="<?php echo e(request('min_price')); ?>">
                                </div>
                                <div class="col-6">
                                    <input type="number" name="max_price" class="form-control" 
                                           placeholder="Đến" min="0"
                                           value="<?php echo e(request('max_price')); ?>">
                                </div>
                            </div>
                            <small class="text-muted">
                                Giá từ <?php echo e(number_format($minPrice)); ?>đ - <?php echo e(number_format($maxPrice)); ?>đ
                            </small>
                        </div>

                        <!-- Stock Filter -->
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="in_stock" value="1" 
                                       class="form-check-input" id="inStock"
                                       <?php echo e(request('in_stock') ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="inStock">
                                    Chỉ hiển thị sách còn hàng
                                </label>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Lọc sách
                            </button>
                            <a href="<?php echo e(route('books.index')); ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-undo"></i> Xóa bộ lọc
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Books List -->
        <div class="col-lg-9">
            <!-- Sort and View Options -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <span class="text-muted">
                        Hiển thị <?php echo e($books->firstItem() ?? 0); ?> - <?php echo e($books->lastItem() ?? 0); ?> 
                        của <?php echo e($books->total()); ?> sách
                    </span>
                </div>
                <div class="d-flex gap-2">
                    <select name="sort" class="form-select form-select-sm" id="sortSelect" style="width: auto;">
                        <option value="latest" <?php echo e(request('sort') == 'latest' ? 'selected' : ''); ?>>
                            Mới nhất
                        </option>
                        <option value="price_low" <?php echo e(request('sort') == 'price_low' ? 'selected' : ''); ?>>
                            Giá thấp đến cao
                        </option>
                        <option value="price_high" <?php echo e(request('sort') == 'price_high' ? 'selected' : ''); ?>>
                            Giá cao đến thấp
                        </option>
                        <option value="name_az" <?php echo e(request('sort') == 'name_az' ? 'selected' : ''); ?>>
                            Tên A-Z
                        </option>
                        <option value="name_za" <?php echo e(request('sort') == 'name_za' ? 'selected' : ''); ?>>
                            Tên Z-A
                        </option>
                    </select>
                </div>
            </div>

            <!-- Books Grid -->
            <?php if($books->count() > 0): ?>
                <div class="row" id="booksGrid">
                    <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <a href="<?php echo e(route('books.show', $book->id)); ?>" class="card h-100 shadow-sm book-card text-decoration-none text-dark">
                            <div class="position-relative">
                                <?php if($book->image): ?>
                                    <img src="<?php echo e($book->image_url); ?>" 
                                         class="card-img-top" alt="<?php echo e($book->title); ?>" 
                                         style="height: 250px; object-fit: contain; padding: 10px;">
                                <?php else: ?>
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                         style="height: 250px;">
                                        <i class="fas fa-book fa-3x text-muted"></i>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if($book->sale_price && $book->sale_price < $book->price): ?>
                                    <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                                        Giảm <?php echo e(round((($book->price - $book->sale_price) / $book->price) * 100)); ?>%
                                    </span>
                                <?php endif; ?>
                                
                                <?php if($book->stock_quantity <= 0): ?>
                                    <span class="badge bg-secondary position-absolute top-0 end-0 m-2">
                                        Hết hàng
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title flex-grow-1">
                                    <?php echo e(Str::limit($book->title, 50)); ?>

                                </h6>
                                <p class="text-muted small mb-2"><?php echo e($book->author); ?></p>
                                <p class="text-primary small mb-2"><?php echo e($book->category->name); ?></p>

                                
                                <div class="mb-2">
                                    <?php
                                        $avg = $book->average_rating;
                                        $count = $book->reviews()->count();
                                    ?>
                                    <?php if($avg): ?>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                <?php for($i=1;$i<=5;$i++): ?>
                                                    <?php if($i <= floor($avg)): ?>
                                                        <i class="fas fa-star text-warning"></i>
                                                    <?php elseif($i - $avg < 1 && $i - $avg > 0): ?>
                                                        <i class="fas fa-star-half-alt text-warning"></i>
                                                    <?php else: ?>
                                                        <i class="far fa-star text-warning"></i>
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                            </div>
                                            <div class="small text-muted">
                                                (<?php echo e($count); ?> đánh giá)
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted small">Chưa có đánh giá</span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <?php if(isset($flashSaleItems[$book->id])): ?>
                                                <!-- Flash Sale Price -->
                                                <span class="h6 text-danger mb-0 fw-bold"><?php echo e(number_format($flashSaleItems[$book->id])); ?>đ</span>
                                                <small class="text-muted text-decoration-line-through">
                                                    <?php echo e(number_format($book->price)); ?>đ
                                                </small>
                                                <span class="badge bg-danger ms-1">FLASH SALE</span>
                                            <?php elseif($book->sale_price && $book->sale_price < $book->price): ?>
                                                <span class="h6 text-danger mb-0"><?php echo e(number_format($book->sale_price)); ?>đ</span>
                                                <small class="text-muted text-decoration-line-through">
                                                    <?php echo e(number_format($book->price)); ?>đ
                                                </small>
                                            <?php else: ?>
                                                <span class="h6 text-danger mb-0"><?php echo e(number_format($book->price)); ?>đ</span>
                                            <?php endif; ?>
                                        </div>
                                        <?php if($book->stock_quantity > 0): ?>
                                            <span class="badge bg-success">Còn hàng</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Hết hàng</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    <?php echo e($books->links()); ?>

                </div>
            <?php else: ?>
                <!-- No Books Found -->
                <div class="text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h5>Không tìm thấy sách nào</h5>
                    <p class="text-muted mb-3">
                        Thử thay đổi từ khóa tìm kiếm hoặc bộ lọc để tìm thấy kết quả phù hợp hơn.
                    </p>
                    <a href="<?php echo e(route('books.index')); ?>" class="btn btn-primary">
                        <i class="fas fa-undo"></i> Xóa bộ lọc
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Auto submit form when sort changes
document.getElementById('sortSelect').addEventListener('change', function() {
    const form = document.getElementById('filterForm');
    const sortInput = document.createElement('input');
    sortInput.type = 'hidden';
    sortInput.name = 'sort';
    sortInput.value = this.value;
    form.appendChild(sortInput);
    form.submit();
});

// Add to cart functionality
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function() {
        const bookId = this.dataset.bookId;
        addToCart(bookId, 1);
    });
});

// Card hover effects
document.querySelectorAll('.book-card').forEach(card => {
    card.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-5px)';
        this.style.transition = 'transform 0.3s ease';
    });
    
    card.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0)';
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.book-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.book-card:hover {
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.badge {
    font-size: 0.7rem;
}

@media (max-width: 768px) {
    .col-lg-3 {
        order: 2;
    }
    .col-lg-9 {
        order: 1;
    }
}
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\webbansach\laravel-app\resources\views/frontend/books/index.blade.php ENDPATH**/ ?>