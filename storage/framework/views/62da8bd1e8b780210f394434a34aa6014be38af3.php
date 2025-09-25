

<?php $__env->startSection('title', 'Trang chủ'); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero Section -->
<section class="hero-section bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-3">HNQ BookStore</h1>
                <p class="lead mb-4">Just a book shop :)</p>
            </div>
            <div class="col-lg-6 text-center">
                <i class="fas fa-book-open fa-10x opacity-75"></i>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">Danh mục sách</h2>
        <div class="row">
            <?php $__currentLoopData = $categories->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <a href="<?php echo e(route('books.index', ['category' => $category->id])); ?>" 
                   class="card h-100 text-center border-0 shadow-sm text-decoration-none text-white category-card 
                   <?php switch($category->name):
                        case ('Tiểu thuyết'): ?> category-novel <?php break; ?>
                        <?php case ('Kinh tế - Quản lý'): ?> category-business <?php break; ?>
                        <?php case ('Tâm lý - Kỹ năng sống'): ?> category-psychology <?php break; ?>
                        <?php case ('Sách thiếu nhi'): ?> category-children <?php break; ?>
                        <?php case ('Sách giáo khoa'): ?> category-education <?php break; ?>
                        <?php case ('Khoa học kỹ thuật'): ?> category-science <?php break; ?>
                        <?php case ('Văn học Việt Nam'): ?> category-vietnamese-literature <?php break; ?>
                        <?php case ('Lịch sử'): ?> category-history <?php break; ?>
                        <?php default: ?> category-default 
                   <?php endswitch; ?>">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center position-relative">
                        <div class="category-overlay"></div>
                        <h5 class="card-title text-white fw-bold position-relative z-index-2"><?php echo e($category->name); ?></h5>
                        <p class="card-text text-white-50 mt-auto position-relative z-index-2"><?php echo e($category->books_count ?? 0); ?> sách</p>
                    </div>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<!-- Featured Books Section -->
<section class="py-5 featured-section" id="featured-books">
    <div class="featured-video-wrapper" aria-hidden="true">
        <video class="featured-video" autoplay muted loop playsinline preload="auto" poster="https://i.pinimg.com/1200x/f0/35/5b/f0355b591961ee01c5ee0c519976f347.jpg">
            <source src="https://v1.pinimg.com/videos/mc/720p/af/c4/43/afc44389b0d11b1a7d9afab83d23a56f.mp4" type="video/mp4">
        </video>
    </div>

    <div class="container position-relative">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-white">Sách nổi bật</h2>
            <a href="<?php echo e(route('books.index')); ?>" class="btn btn-outline-light">
                Xem tất cả <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="featured-carousel-wrapper position-relative">
            <div class="featured-carousel" tabindex="0" aria-label="Sách nổi bật">
                <?php $__empty_1 = true; $__currentLoopData = $featuredBooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="featured-item">
                        <a href="<?php echo e(route('books.show', $book->id)); ?>" class="card h-100 shadow-sm text-decoration-none text-dark book-card">
                            <div class="position-relative">
                                <?php if($book->image): ?>
                                    <img src="<?php echo e($book->image_url); ?>" class="card-img-top" alt="<?php echo e($book->title); ?>" style="height: 200px; object-fit: contain; padding: 10px;">
                                <?php else: ?>
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <i class="fas fa-book fa-3x text-muted"></i>
                                    </div>
                                <?php endif; ?>

                                <?php if($book->sale_price && $book->sale_price < $book->price): ?>
                                    <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                                        Giảm <?php echo e(round((($book->price - $book->sale_price) / $book->price) * 100)); ?>%
                                    </span>
                                <?php endif; ?>

                                <!-- 'Nổi bật' badge removed for featured cards -->
                            </div>

                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title flex-grow-1"><?php echo e(Str::limit($book->title, 50)); ?></h6>
                                <p class="text-muted small mb-2"><?php echo e($book->author); ?></p>
                                <p class="text-primary small mb-2"><?php echo e($book->category->name); ?></p>

                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <?php if($book->sale_price && $book->sale_price < $book->price): ?>
                                                <span class="h6 text-danger mb-0"><?php echo e(number_format($book->sale_price)); ?>đ</span>
                                                <small class="text-muted text-decoration-line-through"><?php echo e(number_format($book->price)); ?>đ</small>
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
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-book fa-3x text-muted mb-3"></i>
                        <h5>Chưa có sách nổi bật</h5>
                        <p class="text-muted">Các sách nổi bật sẽ được hiển thị tại đây.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Latest Books Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h2>Sách mới nhất</h2>
            <a href="<?php echo e(route('books.index', ['sort' => 'latest'])); ?>" class="btn btn-outline-primary">
                Xem tất cả <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        
        <div class="row">
            <?php $__empty_1 = true; $__currentLoopData = $latestBooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <a href="<?php echo e(route('books.show', $book->id)); ?>" class="card h-100 shadow-sm text-decoration-none text-dark book-card">
                    <div class="position-relative">
                        <?php if($book->image): ?>
                            <img src="<?php echo e($book->image_url); ?>" class="card-img-top" alt="<?php echo e($book->title); ?>" style="height: 250px; object-fit: contain; padding: 10px;">
                        <?php else: ?>
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                                <i class="fas fa-book fa-3x text-muted"></i>
                            </div>
                        <?php endif; ?>
                        
                        <?php if($book->sale_price && $book->sale_price < $book->price): ?>
                            <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                                Giảm <?php echo e(round((($book->price - $book->sale_price) / $book->price) * 100)); ?>%
                            </span>
                        <?php endif; ?>
                        
                        <span class="badge bg-info position-absolute top-0 end-0 m-2">
                            <i class="fas fa-clock"></i> Mới
                        </span>
                    </div>
                    
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title flex-grow-1"><?php echo e(Str::limit($book->title, 50)); ?></h6>
                        <p class="text-muted small mb-2"><?php echo e($book->author); ?></p>
                        <p class="text-primary small mb-2"><?php echo e($book->category->name); ?></p>
                        
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <?php if($book->sale_price && $book->sale_price < $book->price): ?>
                                        <span class="h6 text-danger mb-0"><?php echo e(number_format($book->sale_price)); ?>đ</span>
                                        <small class="text-muted text-decoration-line-through"><?php echo e(number_format($book->price)); ?>đ</small>
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
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12 text-center py-5">
                <i class="fas fa-book fa-3x text-muted mb-3"></i>
                <h5>Chưa có sách mới</h5>
                <p class="text-muted">Các sách mới nhất sẽ được hiển thị tại đây.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <h3>Đăng ký nhận tin</h3>
                <p class="mb-4">Nhận thông báo về sách mới và ưu đãi đặc biệt</p>
                <form class="d-flex gap-2">
                    <input type="email" class="form-control" placeholder="Nhập email của bạn">
                    <button type="submit" class="btn btn-light">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
/* Featured section base */
.featured-section { position: relative; color: #fff; overflow: hidden; min-height: 360px; }
.featured-section .container { position: relative; z-index: 4; }
.featured-section::before { content: ''; position: absolute; inset: 0; background: linear-gradient(180deg, rgba(0,0,0,0.45) 0%, rgba(0,0,0,0.6) 100%); z-index: 3; }

/* Video: rotate portrait video to landscape and scale to cover */
.featured-video-wrapper { position: absolute; inset: 0; z-index: 0; overflow: hidden; pointer-events: none; }
.featured-video { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(90deg) scale(0.95); transform-origin: center center; min-width: 105%; min-height: 105%; object-fit: cover; filter: brightness(0.78) saturate(1); will-change: transform; backface-visibility: hidden; }

/* Very large screens: small gentle upscale only to maintain coverage */
@media (min-width: 1600px) {
    .featured-video { transform: translate(-50%, -50%) rotate(90deg) scale(1.0); min-width: 110%; min-height: 110%; }
}

/* Improve rendering quality hint (may help some browsers) */
.featured-video { image-rendering: auto; }

/* Responsive: hide video on small devices to save bandwidth */
@media (max-width: 768px) { .featured-video-wrapper { display: none; } .featured-section { background-image: url('https://i.pinimg.com/1200x/f0/35/5b/f0355b591961ee01c5ee0c519976f347.jpg'); background-size: cover; background-position: center; } }

/* Carousel styling */
.featured-carousel-wrapper { overflow: hidden; padding: 0.75rem 0; position: relative; z-index: 4; }
.featured-carousel { display: flex; gap: 1rem; align-items: stretch; overflow-x: auto; scroll-behavior: smooth; -webkit-overflow-scrolling: touch; padding-bottom: 8px; }
.featured-carousel { scrollbar-width: none; -ms-overflow-style: none; }
.featured-carousel::-webkit-scrollbar { display: none; }
.featured-carousel::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 4px; }
.featured-item { flex: 0 0 200px; max-width: 200px; }
.featured-item .card { height: 100%; }
.featured-carousel, .featured-item { will-change: transform; }

/* Make sure headings/buttons are above video */
.featured-section h2, .featured-section .btn { position: relative; z-index: 5; }

@media (max-width: 992px) { .featured-item { flex: 0 0 180px; max-width: 180px; } }
@media (max-width: 576px) { .featured-item { flex: 0 0 140px; max-width: 140px; } }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Smooth auto-scroll for the featured carousel with pause on hover/focus and visibilitychange
(function(){
    const carousel = document.querySelector('.featured-carousel');
    if (!carousel) return;

    // Helper: wait for all images inside the carousel to finish loading
    function imagesLoaded(container) {
        const imgs = Array.from(container.querySelectorAll('img'));
        return Promise.all(imgs.map(img => {
            if (img.complete && img.naturalWidth !== 0) return Promise.resolve();
            return new Promise(res => { img.addEventListener('load', res); img.addEventListener('error', res); });
        }));
    }

    imagesLoaded(carousel).then(() => {
        const originalChildren = Array.from(carousel.children);
        if (originalChildren.length === 0) return;

        // Clone the original set once to allow seamless looping
        originalChildren.forEach(child => carousel.appendChild(child.cloneNode(true)));

        // Ensure the carousel content is wider than the container; if not, clone more times
        let totalScrollWidth = carousel.scrollWidth;
        let baseScrollWidth = Math.round(totalScrollWidth / 2) || totalScrollWidth;
        let cloneCount = 1;
        const maxClones = 6; // safety limit
        while (baseScrollWidth <= carousel.clientWidth && cloneCount < maxClones) {
            // clone original set again
            originalChildren.forEach(child => carousel.appendChild(child.cloneNode(true)));
            cloneCount++;
            totalScrollWidth = carousel.scrollWidth;
            baseScrollWidth = Math.round(totalScrollWidth / (cloneCount + 1)) || totalScrollWidth;
        }

        // If still not scrollable after cloning attempts, we'll still proceed but movement may not be visible
        // Nudge start so rAF has something to change
        try { carousel.scrollLeft = 1; } catch(e) {}

        let isPaused = false;
    // Use pixels per second for more consistent movement across refresh rates
    const speedPxPerSec = 180; // ~180px per second; increased speed per user request
        let lastTime = performance.now();

        function tick(now) {
            const delta = now - lastTime;
            lastTime = now;
            if (!isPaused) {
                const move = speedPxPerSec * (delta / 1000);
                carousel.scrollLeft += move;

                // loop by subtracting the base width when we've advanced past it
                if (carousel.scrollLeft >= baseScrollWidth) {
                    carousel.scrollLeft -= baseScrollWidth;
                }
            }
            requestAnimationFrame(tick);
        }

        // Start animation
        requestAnimationFrame(tick);

    // If after 600ms we still haven't moved, start a gentle fallback interval to ensure motion
        let fallbackInterval = null;
        setTimeout(() => {
            try {
                if (carousel.scrollLeft <= 1) {
                    fallbackInterval = setInterval(() => {
                        if (!isPaused) {
                            carousel.scrollLeft += Math.max(1, speedPxPerSec / 60);
                            if (carousel.scrollLeft >= baseScrollWidth) carousel.scrollLeft -= baseScrollWidth;
                        }
                    }, 16);
                }
            } catch (e) { /* ignore */ }
        }, 600);

        // Pause on hover/focus and when tab is hidden
        ['mouseenter','focusin'].forEach(e => carousel.addEventListener(e, () => isPaused = true));
        ['mouseleave','focusout'].forEach(e => carousel.addEventListener(e, () => isPaused = false));
        document.addEventListener('visibilitychange', () => { isPaused = document.hidden; });

        // Keyboard navigation
        carousel.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowRight') { carousel.scrollBy({ left: 240, behavior: 'smooth' }); e.preventDefault(); }
            if (e.key === 'ArrowLeft') { carousel.scrollBy({ left: -240, behavior: 'smooth' }); e.preventDefault(); }
        });

        // Ensure carousel is focusable for keyboard support
        if (!carousel.hasAttribute('tabindex')) carousel.setAttribute('tabindex', '0');
    }).catch(() => {
        // If images fail to load, still try to initialize quickly
        const originalChildren = Array.from(carousel.children);
        if (originalChildren.length === 0) return;
        const baseScrollWidth = carousel.scrollWidth;
        originalChildren.forEach(child => carousel.appendChild(child.cloneNode(true)));
        let isPaused = false;
        // match speedPxPerSec using per-frame approximation (assuming 60fps)
        let speed = (180 / 60); // pixels per frame
        let lastTime = performance.now();
        function tick(now){ const delta = now - lastTime; lastTime = now; if(!isPaused){ carousel.scrollLeft += speed * (delta / (1000/60)); if(carousel.scrollLeft >= baseScrollWidth) carousel.scrollLeft -= baseScrollWidth; } requestAnimationFrame(tick); }
        requestAnimationFrame(tick);
    });
})();

// Add to cart functionality
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function() {
        const bookId = this.dataset.bookId;
        addToCart(bookId, 1);
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\webbansach\laravel-app\resources\views/frontend/home.blade.php ENDPATH**/ ?>