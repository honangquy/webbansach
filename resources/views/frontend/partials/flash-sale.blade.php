@if($activeFlashSale && $activeFlashSale->items->count() > 0)
<section class="flash-sale-section py-4">
    <div class="container position-relative">
        <!-- Decorative shapes -->
        <div class="flash-sale-shape shape-1"></div>
        <div class="flash-sale-shape shape-2"></div>
        <div class="flash-sale-shape shape-3"></div>
        <div class="flash-sale-shape shape-4"></div>
        
        <!-- Header -->
        <div class="flash-sale-header d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center gap-3">
                <!-- Flash icon SVG -->
                <div class="flash-icon-wrapper">
                    <svg class="flash-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13 2L3 14H12L11 22L21 10H12L13 2Z" fill="currentColor"/>
                    </svg>
                </div>
                
                <h2 class="flash-sale-title mb-0">FLASH SALE</h2>
                
                <div class="flash-sale-timer d-flex align-items-center gap-2">
                    <span class="timer-label">Kết thúc trong</span>
                    <div class="timer-boxes d-flex gap-1">
                        <div class="timer-box">
                            <span class="timer-value" id="hours">00</span>
                        </div>
                        <span class="timer-separator">:</span>
                        <div class="timer-box">
                            <span class="timer-value" id="minutes">00</span>
                        </div>
                        <span class="timer-separator">:</span>
                        <div class="timer-box">
                            <span class="timer-value" id="seconds">00</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <a href="{{ route('books.index') }}" class="btn-see-all">
                Xem tất cả
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>
        
        <!-- Products carousel -->
        <div class="flash-sale-carousel-wrapper">
            <button class="carousel-nav carousel-prev" id="flashSalePrev">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            
            <div class="flash-sale-carousel" id="flashSaleCarousel">
                @foreach($activeFlashSale->items->take(10) as $item)
                    @if($item->book && $item->hasStock())
                        <div class="flash-sale-item">
                            <a href="{{ route('books.show', $item->book->id) }}" class="flash-sale-card">
                                <!-- Image -->
                                <div class="flash-sale-image">
                                    @if($item->book->image)
                                        <img src="{{ $item->book->image_url }}" alt="{{ $item->book->title }}">
                                    @else
                                        <div class="no-image">
                                            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M4 19.5C4 18.837 4.26339 18.2011 4.73223 17.7322C5.20107 17.2634 5.83696 17 6.5 17H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M6.5 2H20V22H6.5C5.83696 22 5.20107 21.7366 4.73223 21.2678C4.26339 20.7989 4 20.163 4 19.5V4.5C4 3.83696 4.26339 3.20107 4.73223 2.73223C5.20107 2.26339 5.83696 2 6.5 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    <!-- Badge -->
                                    <span class="flash-badge">Tập {{ $loop->iteration }}</span>
                                </div>
                                
                                <!-- Title -->
                                <h6 class="flash-sale-book-title">{{ Str::limit($item->book->title, 45) }}</h6>
                                
                                <!-- Price -->
                                <div class="flash-sale-price">
                                    <span class="price-flash">{{ number_format($item->flash_price) }} đ</span>
                                    <span class="price-discount">-{{ $item->discount_percent }}%</span>
                                </div>
                                <div class="price-original">{{ number_format($item->book->price) }}đ</div>
                                
                                <!-- Progress bar -->
                                <div class="flash-sale-progress">
                                    @php
                                        $soldPercent = $item->stock_quantity > 0 
                                            ? ($item->sold_quantity / $item->stock_quantity) * 100 
                                            : 0;
                                    @endphp
                                    <div class="progress">
                                        <div class="progress-bar" style="width: {{ $soldPercent }}%"></div>
                                    </div>
                                    <span class="progress-label">Đã bán {{ $item->sold_quantity }}</span>
                                </div>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
            
            <button class="carousel-nav carousel-next" id="flashSaleNext">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
    </div>
</section>

<script>
// Countdown timer
const endTime = new Date("{{ $activeFlashSale->end_time->format('Y-m-d H:i:s') }}").getTime();

function updateCountdown() {
    const now = new Date().getTime();
    const distance = endTime - now;
    
    if (distance < 0) {
        document.querySelector('.flash-sale-section').style.display = 'none';
        return;
    }
    
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
    document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
    document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
    document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');
}

updateCountdown();
setInterval(updateCountdown, 1000);

// Carousel functionality
const carousel = document.getElementById('flashSaleCarousel');
const prevBtn = document.getElementById('flashSalePrev');
const nextBtn = document.getElementById('flashSaleNext');

if (carousel && prevBtn && nextBtn) {
    const scrollAmount = 280; // Width of one item + gap
    
    prevBtn.addEventListener('click', () => {
        carousel.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    });
    
    nextBtn.addEventListener('click', () => {
        carousel.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    });
    
    // Update button visibility
    function updateButtons() {
        prevBtn.style.opacity = carousel.scrollLeft <= 0 ? '0.3' : '1';
        nextBtn.style.opacity = 
            carousel.scrollLeft >= (carousel.scrollWidth - carousel.clientWidth - 10) ? '0.3' : '1';
    }
    
    carousel.addEventListener('scroll', updateButtons);
    updateButtons();
}
</script>
@endif
