@php
// $banners may be passed; use the first banner if present
$banner = isset($banners) && $banners->count() ? $banners->first() : null;

// Determine image source for banner when available
$imgSrc = null;
if ($banner) {
    $imgSrc = $banner->image_url;
    if (!$imgSrc && $banner->image_path) {
        $imgSrc = asset('storage/' . $banner->image_path);
    }
}

@endphp

<style>
    /* Hide caption by default; reveal on hover/focus */
    .banner-caption { opacity:0; transform: translateY(8px); transition: opacity .28s ease, transform .36s cubic-bezier(.2,.9,.2,1); pointer-events:none; }
    .banner-media { position:relative; }
    .banner-media:hover .banner-caption, .banner-media:focus-within .banner-caption, .carousel-item:hover .banner-caption, .carousel-item:focus-within .banner-caption { opacity:1; transform: translateY(0); pointer-events:auto; }
    @media (max-width:768px) { .banner-caption { opacity:1; transform:none; pointer-events:auto; } }
    
    /* Decorative shapes for banner */
    .banner-shape {
        position: absolute;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        pointer-events: none;
        z-index: 0;
    }
    
    .banner-shape-1 {
        width: 300px;
        height: 300px;
        top: -100px;
        left: -80px;
        animation: float 20s ease-in-out infinite;
    }
    
    .banner-shape-2 {
        width: 200px;
        height: 200px;
        top: 30%;
        right: -60px;
        animation: float 15s ease-in-out infinite reverse;
    }
    
    .banner-shape-3 {
        width: 150px;
        height: 150px;
        bottom: -50px;
        left: 15%;
        animation: float 18s ease-in-out infinite;
    }
    
    .banner-shape-4 {
        width: 180px;
        height: 180px;
        top: 10%;
        right: 20%;
        animation: float 22s ease-in-out infinite;
    }
    
    .banner-shape-5 {
        width: 120px;
        height: 120px;
        bottom: 20%;
        right: 10%;
        animation: float 16s ease-in-out infinite reverse;
    }
    
    @keyframes float {
        0%, 100% {
            transform: translate(0, 0) rotate(0deg);
        }
        25% {
            transform: translate(10px, -10px) rotate(5deg);
        }
        50% {
            transform: translate(-5px, 10px) rotate(-3deg);
        }
        75% {
            transform: translate(-10px, -5px) rotate(7deg);
        }
    }
</style>

<style>
    /* Banner responsive layout */
    .banner-card { background:#fff; border-radius:10px; max-width:1220px; width:100%; overflow:hidden; }
    .banner-media { position:relative; }
    .banner-img { width:100%; display:block; object-fit:contain; }

    /* Preferred heights across breakpoints (use viewport height but keep limits)
       - large: taller hero, medium: slightly shorter, small: natural image height
    */
    .banner-img { height: min(460px, 60vh); }
    @media (max-width:1200px) { .banner-img { height: min(420px, 55vh); } }
    @media (max-width:992px) { .banner-img { height: min(360px, 50vh); } }
    @media (max-width:768px) { 
        .banner-img { height: auto; max-height: 280px; padding:8px; object-fit:contain; } 
        .banner-card { border-radius:8px; margin: 0 8px; }
        .hero-section { padding: 1.5rem 0 !important; }
    }
    @media (max-width:575px) { 
        .banner-img { max-height: 220px; padding: 6px; }
        .banner-card { border-radius: 6px; margin: 0 4px; }
        .hero-section { padding: 1rem 0 !important; }
    }

    /* Caption: hidden by default on pointer devices, visible on hover/focus with smooth animation */
    .banner-caption { opacity:0; transform: translateY(8px); transition: opacity .28s ease, transform .36s cubic-bezier(.2,.9,.2,1); pointer-events:none; }
    .banner-media:hover .banner-caption, .banner-media:focus-within .banner-caption, .carousel-item:hover .banner-caption, .carousel-item:focus-within .banner-caption { opacity:1; transform: translateY(0); pointer-events:auto; }

    /* On small screens, make caption flow below image (no overlay) for readability */
    @media (max-width:768px) {
        .banner-caption { 
            position:relative !important; 
            left:auto !important; 
            bottom:auto !important; 
            width:100% !important; 
            max-width:100% !important; 
            padding:10px !important; 
            margin-top:-6px; 
            border-radius:0 0 6px 6px !important; 
            opacity:1 !important; 
            transform:none !important; 
            pointer-events:auto !important;
            background: rgba(14,42,71,0.9) !important;
        }
        .banner-caption h3 {
            font-size: 1rem !important;
        }
        .banner-caption p {
            font-size: 0.85rem !important;
        }
        .carousel-indicators { bottom: 6px; }
    }
    @media (max-width:575px) {
        .banner-caption {
            padding: 8px !important;
        }
        .banner-caption h3 {
            font-size: 0.9rem !important;
        }
        .banner-caption p {
            font-size: 0.8rem !important;
            margin-bottom: 6px !important;
        }
        .banner-caption .btn {
            font-size: 11px;
            padding: 4px 10px;
        }
    }
    
    /* Carousel controls responsive */
    @media (max-width:768px) {
        .carousel-control-prev,
        .carousel-control-next {
            width: 30px;
        }
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 16px;
            height: 16px;
        }
    }
    @media (max-width:575px) {
        .carousel-control-prev,
        .carousel-control-next {
            width: 24px;
        }
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 12px;
            height: 12px;
        }
        .carousel-indicators {
            margin-bottom: 4px;
        }
        .carousel-indicators button {
            width: 20px;
            height: 3px;
        }
    }
    
    /* Decorative shapes - hide on mobile for performance */
    @media (max-width:768px) {
        .banner-shape {
            display: none;
        }
    }
</style>

@if(isset($banners) && $banners->count() > 1)
    <div id="homepageBannersCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000" data-bs-pause="hover">
        <div class="carousel-indicators">
            @foreach($banners as $i => $ignored)
                <button type="button" data-bs-target="#homepageBannersCarousel" data-bs-slide-to="{{ $i }}" class="{{ $i === 0 ? 'active' : '' }}" aria-current="{{ $i === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $i + 1 }}"></button>
            @endforeach
        </div>
        <div class="carousel-inner">
            @foreach($banners as $index => $b)
                @php
                    $img = $b->image_url;
                    if (!$img && $b->image_path) {
                        $img = asset('storage/' . $b->image_path);
                    }
                @endphp

                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <section class="hero-section position-relative text-white py-5" style="overflow:visible; background: #0e2a47;">
                        <!-- Decorative shapes -->
                        <div class="banner-shape banner-shape-1"></div>
                        <div class="banner-shape banner-shape-2"></div>
                        <div class="banner-shape banner-shape-3"></div>
                        <div class="banner-shape banner-shape-4"></div>
                        <div class="banner-shape banner-shape-5"></div>
                        
                        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0,0,0,0.08); z-index:1;"></div>
                        <div class="container position-relative d-flex justify-content-center" style="z-index:2;">
                            <div class="card p-0 banner-card">
                                <div class="d-flex align-items-center w-100">
                                    {{-- Image fills the card width, keep full visible using object-fit: contain --}}
                                    @if($img)
                                        <div class="banner-media" style="position:relative; width:100%;">
                                            @if($b->link)
                                                <a href="{{ $b->link }}" class="w-100 d-block">
                                                    <img loading="lazy" src="{{ $img }}" alt="{{ $b->title ?? 'Banner' }}" class="banner-img img-fluid mx-auto d-block" />
                                                </a>
                                            @else
                                                <img loading="lazy" src="{{ $img }}" alt="{{ $b->title ?? 'Banner' }}" class="banner-img img-fluid mx-auto d-block" />
                                            @endif

                                            {{-- Caption overlay --}}
                                            <div class="banner-caption" style="position:absolute; left:0; bottom:0; z-index:3; padding:20px; color:#fff; max-width:60%; width:100%; background: linear-gradient(90deg, rgba(14,42,71,0.72) 0%, rgba(14,42,71,0.32) 60%, rgba(14,42,71,0.08) 100%);">
                                                @if($b->title)
                                                    <h3 class="mb-1" style="color:#fff; font-weight:600; font-size:1.5rem;">{{ $b->title }}</h3>
                                                @endif
                                                @if(!empty($b->subtitle))
                                                    <p class="mb-2" style="color:rgba(255,255,255,0.92);">{{ $b->subtitle }}</p>
                                                @endif
                                                @if($b->link)
                                                    <a href="{{ $b->link }}" class="btn btn-primary btn-sm">Xem ngay</a>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <div style="width:100%; height:260px; display:flex; align-items:center; justify-content:center;">
                                            <div class="text-center">
                                                <h3 class="mb-0">BookStore</h3>
                                                <p class="small mb-0">Khám phá bộ sưu tập sách của chúng tôi</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            @endforeach
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#homepageBannersCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#homepageBannersCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>

        {{-- JS fallback: if Bootstrap JS isn't present, rotate items manually and pause on hover --}}
        <script>
            (function(){
                document.addEventListener('DOMContentLoaded', function(){
                    var carouselEl = document.getElementById('homepageBannersCarousel');
                    if (!carouselEl) return;

                    if (typeof bootstrap === 'undefined' || typeof bootstrap.Carousel === 'undefined'){
                        var items = carouselEl.querySelectorAll('.carousel-item');
                        var idx = 0;
                        items.forEach(function(it, i){ if (i!==0) it.classList.remove('active'); else it.classList.add('active'); });

                        var intervalMs = 5000;
                        var intervalId = setInterval(nextSlide, intervalMs);

                        function nextSlide(){
                            items[idx].classList.remove('active');
                            idx = (idx + 1) % items.length;
                            items[idx].classList.add('active');
                        }

                        // Pause on hover
                        carouselEl.addEventListener('mouseenter', function(){ clearInterval(intervalId); });
                        carouselEl.addEventListener('mouseleave', function(){ intervalId = setInterval(nextSlide, intervalMs); });

                        // Indicators click support for fallback
                        var indicators = carouselEl.querySelectorAll('.carousel-indicators [data-bs-slide-to]');
                        indicators.forEach(function(btn){
                            btn.addEventListener('click', function(e){
                                var to = parseInt(btn.getAttribute('data-bs-slide-to') || '0', 10);
                                items[idx].classList.remove('active');
                                idx = to % items.length;
                                items[idx].classList.add('active');
                                // reset interval
                                clearInterval(intervalId);
                                intervalId = setInterval(nextSlide, intervalMs);
                            });
                        });
                    }
                });
            })();
        </script>
    </div>
@else
    {{-- Single banner or no banner: render single centered white card with decorative shapes --}}
    <section class="hero-section position-relative text-white py-5" style="overflow:visible; background: #0e2a47;">
        <!-- Decorative shapes -->
        <div class="banner-shape banner-shape-1"></div>
        <div class="banner-shape banner-shape-2"></div>
        <div class="banner-shape banner-shape-3"></div>
        <div class="banner-shape banner-shape-4"></div>
        <div class="banner-shape banner-shape-5"></div>
        
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0,0,0,0.08); z-index:1;"></div>
        <div class="container position-relative d-flex justify-content-center" style="z-index:2;">
            <div class="card p-0 banner-card">
                @if($imgSrc)
                    <div class="banner-media" style="position:relative; width:100%;">
                        @if($banner && $banner->link)
                            <a href="{{ $banner->link }}">
                                <img loading="lazy" src="{{ $imgSrc }}" alt="{{ $banner->title ?? 'Banner' }}" class="banner-img img-fluid mx-auto d-block" style="border-radius:6px;" />
                            </a>
                        @else
                            <img loading="lazy" src="{{ $imgSrc }}" alt="{{ $banner->title ?? 'Banner' }}" class="banner-img img-fluid mx-auto d-block" style="border-radius:6px;" />
                        @endif

                        {{-- Caption overlay for single banner --}}
                        <div class="banner-caption" style="position:absolute; left:0; bottom:0; z-index:3; padding:18px; color:#fff; max-width:60%; width:100%; background: linear-gradient(90deg, rgba(14,42,71,0.72) 0%, rgba(14,42,71,0.32) 60%, rgba(14,42,71,0.08) 100%); border-bottom-left-radius:6px;">
                            @if($banner && $banner->title)
                                <h3 class="mb-1" style="color:#fff; font-weight:600; font-size:1.25rem;">{{ $banner->title }}</h3>
                            @endif
                            @if($banner && !empty($banner->subtitle))
                                <p class="mb-2" style="color:rgba(255,255,255,0.9);">{{ $banner->subtitle }}</p>
                            @endif
                            @if($banner && $banner->link)
                                <a href="{{ $banner->link }}" class="btn btn-primary btn-sm">Xem ngay</a>
                            @endif
                        </div>
                    </div>
                @else
                    <div style="width:100%; height:260px; display:flex; align-items:center; justify-content:center;">
                        <div class="text-center">
                            <h3 class="mb-0">BookStore</h3>
                            <p class="small mb-0">Khám phá bộ sưu tập sách của chúng tôi</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endif
