

<?php $__env->startSection('title', 'Tạo Flash Sale mới'); ?>

<?php $__env->startSection('page-title', 'Tạo Flash Sale mới'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-3">
    <a href="<?php echo e(route('admin.flash-sales.index')); ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Quay lại
    </a>
</div>

<?php if($errors->any()): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Có lỗi xảy ra:</strong>
        <ul class="mb-0">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<form action="<?php echo e(route('admin.flash-sales.store')); ?>" method="POST" id="flashSaleForm">
    <?php echo csrf_field(); ?>
    
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Thông tin Flash Sale</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="title">Tiêu đề <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           id="title" 
                           name="title" 
                           value="<?php echo e(old('title')); ?>" 
                           required>
                    <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="status">Trạng thái <span class="text-danger">*</span></label>
                    <select class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                            id="status" 
                            name="status" 
                            required>
                        <option value="1" <?php echo e(old('status', '1') == '1' ? 'selected' : ''); ?>>Bật</option>
                        <option value="0" <?php echo e(old('status') == '0' ? 'selected' : ''); ?>>Tắt</option>
                    </select>
                    <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label" for="description">Mô tả</label>
                <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                          id="description" 
                          name="description" 
                          rows="3"><?php echo e(old('description')); ?></textarea>
                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="start_time">Thời gian bắt đầu <span class="text-danger">*</span></label>
                    <input type="datetime-local" 
                           class="form-control <?php $__errorArgs = ['start_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           id="start_time" 
                           name="start_time" 
                           value="<?php echo e(old('start_time')); ?>" 
                           required>
                    <?php $__errorArgs = ['start_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="end_time">Thời gian kết thúc <span class="text-danger">*</span></label>
                    <input type="datetime-local" 
                           class="form-control <?php $__errorArgs = ['end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           id="end_time" 
                           name="end_time" 
                           value="<?php echo e(old('end_time')); ?>" 
                           required>
                    <?php $__errorArgs = ['end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Sản phẩm trong Flash Sale</h5>
            <button type="button" class="btn btn-light btn-sm" id="addBookBtn">
                <i class="fas fa-plus me-1"></i>Thêm sản phẩm
            </button>
        </div>
        <div class="card-body">
            <div id="booksContainer">
                <!-- Book items will be added here -->
            </div>
            
            <div id="emptyMessage" class="text-center py-4 text-muted">
                <i class="fas fa-book fa-3x mb-3"></i>
                <p>Chưa có sản phẩm nào. Nhấn "Thêm sản phẩm" để bắt đầu.</p>
            </div>
        </div>
    </div>
    
    <div class="mt-4">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-2"></i>Lưu Flash Sale
        </button>
        <a href="<?php echo e(route('admin.flash-sales.index')); ?>" class="btn btn-secondary">Hủy</a>
    </div>
</form>

<!-- Template for book item -->
<template id="bookItemTemplate">
    <div class="book-item card mb-3">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <label class="form-label">Sách <span class="text-danger">*</span></label>
                    <select class="form-select book-select" name="books[INDEX][book_id]" required>
                        <option value="">-- Chọn sách --</option>
                        <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($book->id); ?>" data-price="<?php echo e($book->price); ?>">
                                <?php echo e($book->title); ?> (<?php echo e(number_format($book->price)); ?>đ)
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Giá Flash Sale <span class="text-danger">*</span></label>
                    <input type="number" 
                           class="form-control flash-price-input" 
                           name="books[INDEX][flash_price]" 
                           min="0" 
                           step="0.01" 
                           required>
                    <small class="text-muted discount-percent"></small>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Số lượng <span class="text-danger">*</span></label>
                    <input type="number" 
                           class="form-control" 
                           name="books[INDEX][stock_quantity]" 
                           min="1" 
                           value="10" 
                           required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button type="button" class="btn btn-danger w-100 remove-book-btn">
                        <i class="fas fa-trash"></i> Xóa
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let bookIndex = 0;
    const booksContainer = document.getElementById('booksContainer');
    const emptyMessage = document.getElementById('emptyMessage');
    const addBookBtn = document.getElementById('addBookBtn');
    const template = document.getElementById('bookItemTemplate');
    
    // Add book item
    addBookBtn.addEventListener('click', function() {
        const clone = template.content.cloneNode(true);
        const html = clone.querySelector('.book-item').outerHTML.replace(/INDEX/g, bookIndex);
        booksContainer.insertAdjacentHTML('beforeend', html);
        bookIndex++;
        updateEmptyMessage();
        attachEventListeners();
    });
    
    // Update empty message visibility
    function updateEmptyMessage() {
        emptyMessage.style.display = booksContainer.children.length === 0 ? 'block' : 'none';
    }
    
    // Attach event listeners to newly added items
    function attachEventListeners() {
        // Remove button
        document.querySelectorAll('.remove-book-btn').forEach(btn => {
            btn.onclick = function() {
                this.closest('.book-item').remove();
                updateEmptyMessage();
            };
        });
        
        // Calculate discount when price changes
        document.querySelectorAll('.book-select').forEach(select => {
            select.onchange = function() {
                const item = this.closest('.book-item');
                const originalPrice = this.options[this.selectedIndex]?.dataset.price || 0;
                const flashPriceInput = item.querySelector('.flash-price-input');
                flashPriceInput.dataset.originalPrice = originalPrice;
                calculateDiscount(item);
            };
        });
        
        document.querySelectorAll('.flash-price-input').forEach(input => {
            input.oninput = function() {
                calculateDiscount(this.closest('.book-item'));
            };
        });
    }
    
    // Calculate and display discount percentage
    function calculateDiscount(item) {
        const flashPriceInput = item.querySelector('.flash-price-input');
        const discountSpan = item.querySelector('.discount-percent');
        const originalPrice = parseFloat(flashPriceInput.dataset.originalPrice || 0);
        const flashPrice = parseFloat(flashPriceInput.value || 0);
        
        if (originalPrice > 0 && flashPrice > 0) {
            const discount = Math.round(((originalPrice - flashPrice) / originalPrice) * 100);
            if (discount > 0) {
                discountSpan.textContent = `Giảm ${discount}%`;
                discountSpan.className = 'text-success discount-percent';
            } else if (discount < 0) {
                discountSpan.textContent = 'Giá cao hơn giá gốc!';
                discountSpan.className = 'text-danger discount-percent';
            } else {
                discountSpan.textContent = '';
            }
        } else {
            discountSpan.textContent = '';
        }
    }
    
    // Form validation
    document.getElementById('flashSaleForm').addEventListener('submit', function(e) {
        if (booksContainer.children.length === 0) {
            e.preventDefault();
            alert('Vui lòng thêm ít nhất một sản phẩm!');
            return false;
        }
    });
    
    updateEmptyMessage();
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\webbansach\laravel-app\resources\views/admin/flash-sales/create.blade.php ENDPATH**/ ?>