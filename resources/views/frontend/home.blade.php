@extends('layouts.frontend')

@section('title', 'Trang chủ')

@section('content')
@include('frontend.partials.banner')

<!-- Flash Sale Section -->
@include('frontend.partials.flash-sale')

<!-- Categories Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">Danh mục sách</h2>
        <div class="row">
            @foreach($categories->take(8) as $category)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <a href="{{ route('books.index', ['category' => $category->id]) }}" 
                   class="card h-100 text-center border-0 shadow-sm text-decoration-none text-white category-card 
                   @switch($category->name)
                        @case('Tiểu thuyết') category-novel @break
                        @case('Kinh tế - Quản lý') category-business @break
                        @case('Tâm lý - Kỹ năng sống') category-psychology @break
                        @case('Sách thiếu nhi') category-children @break
                        @case('Sách giáo khoa') category-education @break
                        @case('Khoa học kỹ thuật') category-science @break
                        @case('Văn học Việt Nam') category-vietnamese-literature @break
                        @case('Lịch sử') category-history @break
                        @default category-default 
                   @endswitch">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center position-relative">
                        <div class="category-overlay"></div>
                        <h5 class="card-title text-white fw-bold position-relative z-index-2">{{ $category->name }}</h5>
                        <p class="card-text text-white-50 mt-auto position-relative z-index-2">{{ $category->books_count ?? 0 }} sách</p>
                    </div>
                </a>
            </div>
            @endforeach
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
            <a href="{{ route('books.index') }}" class="btn btn-outline-light">
                Xem tất cả <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="featured-carousel-wrapper position-relative">
            <div class="featured-carousel" tabindex="0" aria-label="Sách nổi bật">
                @forelse($featuredBooks as $book)
                    <div class="featured-item">
                        <a href="{{ route('books.show', $book->id) }}" class="card h-100 shadow-sm text-decoration-none text-dark book-card">
                            <div class="position-relative">
                                @if($book->image)
                                    <img src="{{ $book->image_url }}" class="card-img-top" alt="{{ $book->title }}" style="height: 200px; object-fit: contain; padding: 10px;">
                                @else
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <i class="fas fa-book fa-3x text-muted"></i>
                                    </div>
                                @endif

                                @if($book->sale_price && $book->sale_price < $book->price)
                                    <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                                        Giảm {{ round((($book->price - $book->sale_price) / $book->price) * 100) }}%
                                    </span>
                                @endif

                                <!-- 'Nổi bật' badge removed for featured cards -->
                            </div>

                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title flex-grow-1">{{ Str::limit($book->title, 50) }}</h6>
                                <p class="text-muted small mb-2">{{ $book->author }}</p>
                                <p class="text-primary small mb-2">{{ $book->category->name }}</p>

                                {{-- Rating display --}}
                                <div class="mb-2">
                                    @php
                                        $avg = $book->average_rating;
                                        $count = $book->reviews()->count();
                                    @endphp
                                    @if($avg)
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                @for($i=1;$i<=5;$i++)
                                                    @if($i <= floor($avg))
                                                        <i class="fas fa-star text-warning"></i>
                                                    @elseif($i - $avg < 1 && $i - $avg > 0)
                                                        <i class="fas fa-star-half-alt text-warning"></i>
                                                    @else
                                                        <i class="far fa-star text-warning"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <div class="small text-muted">
                                                ({{ $count }} đánh giá)
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted small">Chưa có đánh giá</span>
                                    @endif
                                </div>

                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            @if($book->sale_price && $book->sale_price < $book->price)
                                                <span class="h6 text-danger mb-0">{{ number_format($book->sale_price) }}đ</span>
                                                <small class="text-muted text-decoration-line-through">{{ number_format($book->price) }}đ</small>
                                            @else
                                                <span class="h6 text-danger mb-0">{{ number_format($book->price) }}đ</span>
                                            @endif
                                        </div>
                                        @if($book->stock_quantity > 0)
                                            <span class="badge bg-success">Còn hàng</span>
                                        @else
                                            <span class="badge bg-secondary">Hết hàng</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-book fa-3x text-muted mb-3"></i>
                        <h5>Chưa có sách nổi bật</h5>
                        <p class="text-muted">Các sách nổi bật sẽ được hiển thị tại đây.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

<!-- Latest Books Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="mb-4">
            <h2 class="mb-1">Sách mới nhất</h2>
            <p class="text-muted small mb-0">Khám phá những đầu sách mới nhất vừa được cập nhật</p>
        </div>
        
        <div class="row g-3">
            @forelse($latestBooks as $book)
            <div class="col-xl-2-4 col-lg-3 col-md-4 col-sm-6 col-6 mb-3">
                <a href="{{ route('books.show', $book->id) }}" class="card h-100 shadow-sm text-decoration-none text-dark book-card">
                    <div class="position-relative">
                        @if($book->image)
                            <img src="{{ $book->image_url }}" class="card-img-top" alt="{{ $book->title }}" style="height: 200px; object-fit: contain; padding: 8px;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-book fa-2x text-muted"></i>
                            </div>
                        @endif
                        
                        @if($book->sale_price && $book->sale_price < $book->price)
                            <span class="badge bg-danger position-absolute top-0 start-0 m-1" style="font-size: 10px;">
                                -{{ round((($book->price - $book->sale_price) / $book->price) * 100) }}%
                            </span>
                        @endif
                        
                        <span class="badge bg-info position-absolute top-0 end-0 m-1" style="font-size: 10px;">
                            <i class="fas fa-clock"></i> Mới
                        </span>
                    </div>
                    
                    <div class="card-body d-flex flex-column p-2">
                        <h6 class="card-title flex-grow-1 mb-1">{{ Str::limit($book->title, 45) }}</h6>
                        <p class="text-muted small mb-1" style="font-size: 12px;">{{ Str::limit($book->author, 25) }}</p>
                        <p class="text-primary small mb-2" style="font-size: 12px;">{{ $book->category->name }}</p>
                        
                        {{-- Rating display - compact --}}
                        <div class="mb-1" style="font-size: 11px;">
                            @php
                                $avg = $book->average_rating;
                                $count = $book->reviews()->count();
                            @endphp
                            @if($avg)
                                <div class="d-flex align-items-center">
                                    <div class="me-1">
                                        @for($i=1;$i<=5;$i++)
                                            @if($i <= floor($avg))
                                                <i class="fas fa-star text-warning" style="font-size: 10px;"></i>
                                            @elseif($i - $avg < 1 && $i - $avg > 0)
                                                <i class="fas fa-star-half-alt text-warning" style="font-size: 10px;"></i>
                                            @else
                                                <i class="far fa-star text-warning" style="font-size: 10px;"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-muted" style="font-size: 11px;">({{ $count }})</span>
                                </div>
                            @else
                                <span class="text-muted" style="font-size: 11px;">Chưa có đánh giá</span>
                            @endif
                        </div>

                        <div class="mt-auto">
                            <div class="d-flex flex-column gap-1">
                                <div class="d-flex justify-content-between align-items-center">
                                    @if($book->sale_price && $book->sale_price < $book->price)
                                        <div>
                                            <div class="fw-bold text-danger" style="font-size: 14px;">{{ number_format($book->sale_price) }}đ</div>
                                            <small class="text-muted text-decoration-line-through" style="font-size: 11px;">{{ number_format($book->price) }}đ</small>
                                        </div>
                                    @else
                                        <div class="fw-bold text-danger" style="font-size: 14px;">{{ number_format($book->price) }}đ</div>
                                    @endif
                                    @if($book->stock_quantity > 0)
                                        <span class="badge bg-success" style="font-size: 10px;">Còn hàng</span>
                                    @else
                                        <span class="badge bg-secondary" style="font-size: 10px;">Hết hàng</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-book fa-3x text-muted mb-3"></i>
                <h5>Chưa có sách mới</h5>
                <p class="text-muted">Các sách mới nhất sẽ được hiển thị tại đây.</p>
            </div>
            @endforelse
        </div>
        
        <!-- View All Button -->
        <div class="text-center mt-4">
            <a href="{{ route('books.index', ['sort' => 'latest']) }}" class="btn btn-primary btn-lg px-5">
                <i class="fas fa-book-open me-2"></i>Xem tất cả sách mới
            </a>
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
@endsection

@push('styles')
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
@endpush

@push('scripts')
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
@endpush