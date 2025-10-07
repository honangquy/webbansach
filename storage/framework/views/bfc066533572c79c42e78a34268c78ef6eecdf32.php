

<?php $__env->startSection('title', 'Thống kê sản phẩm'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">
        <i class="fas fa-box me-2"></i>Thống kê sản phẩm
    </h1>
    <div class="d-flex gap-2">
        <a href="<?php echo e(route('admin.statistics.index')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
        <a href="#" id="exportCsvBtn" class="btn btn-outline-success">
            <i class="fas fa-file-csv"></i> Xuất CSV
        </a>
        <select class="form-select" id="sortSelect" style="width: auto;">
            <option value="sold" <?php echo e($sap_xep == 'sold' ? 'selected' : ''); ?>>Sắp xếp theo lượt bán</option>
            <option value="revenue" <?php echo e($sap_xep == 'revenue' ? 'selected' : ''); ?>>Sắp xếp theo doanh thu</option>
            <option value="stock" <?php echo e($sap_xep == 'stock' ? 'selected' : ''); ?>>Sắp xếp theo tồn kho</option>
        </select>
    </div>
</div>

<!-- Stock Alert Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Hết hàng
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e(number_format($stockAlerts['out_of_stock'])); ?></div>
                        <small class="text-muted">Sản phẩm cần nhập hàng</small>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Sắp hết hàng
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e(number_format($stockAlerts['low_stock'])); ?></div>
                        <small class="text-muted">Tồn kho ≤ 5 cuốn</small>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Giá trị tồn kho
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e(number_format($stockAlerts['total_stock_value'])); ?>đ</div>
                        <small class="text-muted">Tổng giá trị hàng tồn</small>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Category Performance -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Hiệu suất theo danh mục</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Danh mục</th>
                                <th>Số sách</th>
                                <th>Đã bán</th>
                                <th>Doanh thu</th>
                                <th>Hiệu suất</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $categoryPerformance; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($category->name); ?></strong>
                                    <?php if($category->description): ?>
                                        <br><small class="text-muted"><?php echo e(Str::limit($category->description, 50)); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-info"><?php echo e($category->books_count); ?></span>
                                </td>
                                <td><?php echo e(number_format($category->total_sold)); ?></td>
                                <td><strong class="text-success"><?php echo e(number_format($category->total_revenue)); ?>đ</strong></td>
                                <td>
                                    <?php
                                        $performance = $category->books_count > 0 ? ($category->total_sold / $category->books_count) : 0;
                                    ?>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar 
                                            <?php if($performance >= 10): ?> bg-success
                                            <?php elseif($performance >= 5): ?> bg-warning  
                                            <?php else: ?> bg-danger
                                            <?php endif; ?>" 
                                            role="progressbar" 
                                            style="width: <?php echo e(min(100, $performance * 2)); ?>%">
                                            <?php echo e(number_format($performance, 1)); ?>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Product Performance Table -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Chi tiết hiệu suất sản phẩm</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Sách</th>
                                <th>Danh mục</th>
                                <th>Giá bán</th>
                                <th>Tồn kho</th>
                                <th>Đã bán</th>
                                <th>Doanh thu</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if($product->image): ?>
                                            <img src="<?php echo e($product->image_url); ?>" 
                                                 class="me-2 rounded" 
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" 
                                                 style="width: 40px; height: 40px;">
                                                <i class="fas fa-book text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <strong><?php echo e(Str::limit($product->title, 30)); ?></strong>
                                            <br><small class="text-muted"><?php echo e($product->author); ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary"><?php echo e($product->category->name); ?></span>
                                </td>
                                <td><?php echo e(number_format($product->price)); ?>đ</td>
                                <td>
                                    <span class="badge 
                                        <?php if($product->stock_quantity == 0): ?> bg-danger
                                        <?php elseif($product->stock_quantity <= 5): ?> bg-warning
                                        <?php else: ?> bg-success
                                        <?php endif; ?>">
                                        <?php echo e($product->stock_quantity); ?>

                                    </span>
                                </td>
                                <td><?php echo e(number_format($product->total_sold)); ?></td>
                                <td><strong class="text-success"><?php echo e(number_format($product->total_revenue)); ?>đ</strong></td>
                                <td>
                                    <?php if($product->stock_quantity == 0): ?>
                                        <span class="badge bg-danger">Hết hàng</span>
                                    <?php elseif($product->stock_quantity <= 5): ?>
                                        <span class="badge bg-warning">Sắp hết</span>
                                    <?php elseif($product->total_sold > 50): ?>
                                        <span class="badge bg-success">Bán chạy</span>
                                    <?php else: ?>
                                        <span class="badge bg-info">Bình thường</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    <?php echo e($products->appends(['sap_xep' => $sap_xep])->links()); ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
// Sort selector
document.getElementById('sortSelect').addEventListener('change', function() {
    window.location.href = '<?php echo e(route("admin.statistics.products")); ?>?sap_xep=' + this.value;
});

// Export CSV
document.getElementById('exportCsvBtn').addEventListener('click', function(e) {
    e.preventDefault();
    const s = document.getElementById('sortSelect').value;
    window.open('<?php echo e(route("admin.statistics.export")); ?>?loai=products&sap_xep=' + s, '_blank');
});
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
.border-left-danger {
    border-left: 0.25rem solid #e74a3b !important;
}
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\webbansach\laravel-app\resources\views/admin/statistics/products.blade.php ENDPATH**/ ?>